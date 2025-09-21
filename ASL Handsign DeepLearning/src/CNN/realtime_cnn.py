import os, cv2, numpy as np, tensorflow as tf
from collections import deque

MODEL_PATH = "outputs/models/mobilenet_asl_best.h5"
ASL_DIR   = "asl_alphabet"
IMG_SIZE  = (128, 128)
SMOOTH_WINDOW = 10
STABILITY_COUNT = 5
CONFIDENCE_THRESHOLD = 0.60
USE_MEDIAPIPE = True

classes = sorted([d for d in os.listdir(ASL_DIR) if os.path.isdir(os.path.join(ASL_DIR, d))])
print(f"Classes ({len(classes)}): {classes[:10]}{'...' if len(classes)>10 else ''}")
model = tf.keras.models.load_model(MODEL_PATH, compile=False)
print("Model loaded:", MODEL_PATH)

# Mediapipe optional
mp_hands = None
if USE_MEDIAPIPE:
    try:
        import mediapipe as mp
        mp_hands = mp.solutions.hands
        hands_detector = mp_hands.Hands(static_image_mode=False,
                                        max_num_hands=1,
                                        min_detection_confidence=0.5,
                                        min_tracking_confidence=0.3)
        mp_draw = mp.solutions.drawing_utils
        print("MediaPipe Hands available.")
    except Exception as e:
        print("Mediapipe failed, fallback to full frame:", e)
        mp_hands = None

cap = cv2.VideoCapture(0)
if not cap.isOpened():
    raise RuntimeError("Cannot open webcam.")

prob_buffer = deque(maxlen=SMOOTH_WINDOW)
last_pred, consecutive = None, 0
display_label, display_conf = "...", 0.0
status_text = "No hand"

def crop_hand_from_frame(frame_rgb):
    global hands_detector
    results = hands_detector.process(frame_rgb)
    if not results.multi_hand_landmarks:
        return None
    h, w, _ = frame_rgb.shape
    all_x = [lm.x for lm in results.multi_hand_landmarks[0].landmark]
    all_y = [lm.y for lm in results.multi_hand_landmarks[0].landmark]
    xmin = int(max(0, min(all_x) * w) - 20)
    ymin = int(max(0, min(all_y) * h) - 20)
    xmax = int(min(w, max(all_x) * w) + 20)
    ymax = int(min(h, max(all_y) * h) + 20)
    return frame_rgb[ymin:ymax, xmin:xmax], (xmin,ymin,xmax,ymax)

def center_crop_square(frame_rgb):
    h, w, _ = frame_rgb.shape
    side = min(h, w)
    cx, cy = w//2, h//2
    half = side//2
    xmin, ymin = max(0, cx-half), max(0, cy-half)
    xmax, ymax = xmin+side, ymin+side
    return frame_rgb[ymin:ymax, xmin:xmax], (xmin,ymin,xmax,ymax)

try:
    while True:
        ret, frame = cap.read()
        if not ret: break
        frame = cv2.flip(frame, 1)
        frame_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

        crop_res = crop_hand_from_frame(frame_rgb) if mp_hands else None
        if crop_res is None:
            crop_img, bbox = center_crop_square(frame_rgb)
            hand_found = False
            status_text = "No hand"
        else:
            crop_img, bbox = crop_res
            hand_found = True
            status_text = "Hand detected"

        try:
            im = cv2.resize(crop_img, IMG_SIZE)
        except:
            im = cv2.resize(frame_rgb, IMG_SIZE)
            bbox = (0,0,frame.shape[1], frame.shape[0])
            hand_found = False
            status_text = "No hand"

        im_arr = im.astype("float32")/255.0
        pred_probs = model.predict(np.expand_dims(im_arr,0), verbose=0)[0]
        prob_buffer.append(pred_probs)

        avg_probs = np.mean(np.array(prob_buffer), axis=0)
        pred_cls, pred_conf = int(np.argmax(avg_probs)), float(avg_probs[np.argmax(avg_probs)])

        if last_pred is None or pred_cls != last_pred:
            last_pred, consecutive = pred_cls, 1
        else:
            consecutive += 1

        if consecutive >= STABILITY_COUNT and pred_conf >= CONFIDENCE_THRESHOLD:
            display_label, display_conf = classes[pred_cls], pred_conf
            status_text = f"Recognized {display_label}"
        elif hand_found:
            status_text = "Hand detected - low conf"

        x1,y1,x2,y2 = bbox
        color = (0,255,0) if hand_found else (255,150,0)
        cv2.rectangle(frame, (x1,y1), (x2,y2), color, 2)

        cv2.putText(frame, f"{display_label} {display_conf*100:.1f}%", (10,35),
                    cv2.FONT_HERSHEY_SIMPLEX, 1.0, (0,255,0), 2)
        cv2.putText(frame, status_text, (10,70), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0,200,255), 2)

        cv2.imshow("ASL - stable realtime", frame)
        key = cv2.waitKey(1) & 0xFF
        if key == ord("q"): break

finally:
    cap.release()
    cv2.destroyAllWindows()
    if mp_hands: hands_detector.close()
