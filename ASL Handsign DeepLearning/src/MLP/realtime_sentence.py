import os, json, time
import cv2
import numpy as np
import tensorflow as tf
from collections import deque
import mediapipe as mp

# ===== USER CONFIG =====
MODEL_PATH = "outputs/models/landmark_mlp_best.h5"
FEATURE_DIR = "outputs/features"
CLASSES_JSON = os.path.join(FEATURE_DIR, "classes_filtered.json")  # prefer filtered classes if present
SCALER_MEAN = os.path.join(FEATURE_DIR, "scaler_mean.npy")
SCALER_SCALE = os.path.join(FEATURE_DIR, "scaler_scale.npy")

SMOOTH_WINDOW = 8
STABILITY_COUNT = 12
CONF_THRESH = 0.55
SHOW_THUMBNAIL = True
txt_color1 = (0,255,255)  
# =======================

# load classes
if not os.path.exists(CLASSES_JSON):
    CLASSES_JSON = os.path.join(FEATURE_DIR, "classes.json")
with open(CLASSES_JSON, "r") as f:
    classes = json.load(f)

# load scaler
mean = np.load(SCALER_MEAN)
scale = np.load(SCALER_SCALE)

# load model
model = tf.keras.models.load_model(MODEL_PATH, compile=False)
print("Loaded model:", MODEL_PATH)

# MediaPipe
mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=False, max_num_hands=1,
                       min_detection_confidence=0.5, min_tracking_confidence=0.3)
mp_draw = mp.solutions.drawing_utils

# state
buf = deque(maxlen=SMOOTH_WINDOW)
last_pred = None
consec = 0
candidate_label = "..."
candidate_conf = 0.0
sentence = ""
auto_accept = False
save_idx = 0

# helper convert landmarks to vector (63 dims)
def landmarks_to_vector(landmarks):
    vec = []
    for lm in landmarks.landmark:
        vec.extend([lm.x, lm.y, lm.z])
    return np.array(vec, dtype=np.float32)

# UI drawing
def draw_ui(frame, bbox, hand_found, candidate_label, candidate_conf, consec, sentence, auto_accept):
    h, w = frame.shape[:2]
    x1,y1,x2,y2 = bbox
    color = (0,200,0) if hand_found else (255,150,0)
    cv2.rectangle(frame, (x1,y1), (x2,y2), color, 2)

    # pilih warna dinamis untuk teks berdasarkan confidence
    if candidate_conf < 0.5:
        txt_color = (0,0,255)   # merah
    elif candidate_conf < 0.75:
        txt_color = (0,255,255) # kuning
    else:
        txt_color = (0,255,0)   # hijau

    # candidate text
    txt = f"Candidate: {candidate_label}  {candidate_conf*100:4.1f}%"
    cv2.putText(frame, txt, (10,30), cv2.FONT_HERSHEY_SIMPLEX, 0.9, txt_color, 2)

    # confidence bar
    bar_x, bar_y, bar_w, bar_h = 10, 55, 220, 18
    cv2.rectangle(frame, (bar_x,bar_y), (bar_x+bar_w, bar_y+bar_h), txt_color, 1)
    fill = int(bar_w * min(1.0, candidate_conf))
    cv2.rectangle(frame, (bar_x,bar_y), (bar_x+fill, bar_y+bar_h), txt_color, -1)
    cv2.putText(frame, f"Stable: {consec}/{STABILITY_COUNT}", (bar_x, bar_y+bar_h+20),
                cv2.FONT_HERSHEY_SIMPLEX, 0.45, txt_color1, 1)

    # sentence
    max_chars = 40
    display = sentence[-(max_chars*2):]
    cv2.putText(frame, f"Sentence: {display}", (10, h-30),
                cv2.FONT_HERSHEY_SIMPLEX, 0.8, txt_color1, 2)

    # mode text
    mode_text = "AUTO-ACCEPT ON" if auto_accept else "Manual accept (press 's')"
    cv2.putText(frame, mode_text, (10, h-60),
                cv2.FONT_HERSHEY_SIMPLEX, 0.6, txt_color1, 1)

    # key help
    cv2.putText(frame,
                "Keys: s=accept b=backspace SPACE=space c=clear f=auto w=write q=quit",
                (10, h-10), cv2.FONT_HERSHEY_SIMPLEX, 0.45, txt_color1, 1)

# center-crop fallback bbox
def center_crop_bbox(frame):
    h,w = frame.shape[:2]
    side = min(h,w)
    cx,cy = w//2, h//2
    half = side//2
    xmin,ymin = max(0, cx-half), max(0, cy-half)
    return (xmin,ymin,xmin+side,ymin+side)

cap = cv2.VideoCapture(0)
if not cap.isOpened():
    raise RuntimeError("Cannot open webcam")

try:
    while True:
        ret, frame = cap.read()
        if not ret:
            break
        frame = cv2.flip(frame, 1)
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = hands.process(img_rgb)

        hand_found = False
        bbox = center_crop_bbox(frame)
        if res.multi_hand_landmarks:
            hand_found = True
            hm = res.multi_hand_landmarks[0]
            mp_draw.draw_landmarks(frame, hm, mp_hands.HAND_CONNECTIONS)
            vec = landmarks_to_vector(hm)
            vec_s = (vec - mean) / (scale + 1e-12)
            probs = model.predict(np.expand_dims(vec_s, axis=0), verbose=0)[0]
            buf.append(probs)

            # bbox from landmarks
            h_img, w_img = frame.shape[:2]
            xs = [lm.x for lm in hm.landmark]; ys = [lm.y for lm in hm.landmark]
            xmin = int(max(0, min(xs) * w_img) - 20); ymin = int(max(0, min(ys) * h_img) - 20)
            xmax = int(min(w_img, max(xs) * w_img) + 20); ymax = int(min(h_img, max(ys) * h_img) + 20)
            bbox = (xmin,ymin,xmax,ymax)
        else:
            if len(buf) > 0:
                buf.append(buf[-1] * 0.6)

        # compute averaged probs
        if len(buf) > 0:
            avg = np.mean(np.array(buf), axis=0)
            cls = int(np.argmax(avg)); conf = float(avg[cls])
            if last_pred is None or cls != last_pred:
                last_pred = cls; consec = 1
            else:
                consec += 1
            candidate_label = classes[cls]
            candidate_conf = conf
        else:
            candidate_label = "..."
            candidate_conf = 0.0
            consec = 0

        # auto-accept
        if auto_accept and consec >= STABILITY_COUNT and candidate_conf >= CONF_THRESH:
            ch = candidate_label
            lower = ch.lower()
            if lower in ("space", "blank", "nothing"):
                sentence += " "
            elif lower == "del":
                sentence = sentence[:-1]
            else:
                sentence += ch[0] if len(ch) > 0 else ""
            buf.clear()
            last_pred = None
            consec = 0

        # draw UI
        draw_ui(frame, bbox, hand_found, candidate_label, candidate_conf, consec, sentence, auto_accept)

        # thumbnail
        if SHOW_THUMBNAIL:
            x1,y1,x2,y2 = bbox
            x1,y1 = max(0,x1), max(0,y1)
            x2,y2 = min(frame.shape[1],x2), min(frame.shape[0],y2)
            try:
                thumb = cv2.resize(frame[y1:y2, x1:x2], (120,120))
                frame[10:130, frame.shape[1]-130:frame.shape[1]-10] = thumb
                cv2.rectangle(frame, (frame.shape[1]-130,10), (frame.shape[1]-10,130), (200,200,200), 1)
            except Exception:
                pass

        cv2.imshow("ASL Image Recognition", frame)
        key = cv2.waitKey(1) & 0xFF

        # key handling
        if key == ord('q'):
            break
        elif key == ord('s'):
            ch = candidate_label
            lower = ch.lower()
            if lower in ("space", "blank", "nothing"):
                sentence += " "
            elif lower == "del":
                sentence = sentence[:-1]
            else:
                sentence += ch[0] if len(ch) > 0 else ""
            buf.clear()
            last_pred = None
            consec = 0
        elif key == ord('b'):
            sentence = sentence[:-1]
        elif key == ord('c'):
            sentence = ""
        elif key == ord('f'):
            auto_accept = not auto_accept
        elif key == ord('w'):
            fname = f"outputs/sentences_{int(time.time())}.txt"
            os.makedirs("outputs", exist_ok=True)
            with open(fname, "w", encoding="utf-8") as fw:
                fw.write(sentence)
            print("Saved sentence to", fname)
        elif key == 32:
            sentence += " "
        elif key == ord('p'):
            print("Sentence:", sentence)

finally:
    cap.release()
    cv2.destroyAllWindows()
    hands.close()
