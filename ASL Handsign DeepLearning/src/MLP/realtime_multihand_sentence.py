# src/realtime_sentence_multi.py
import os, json, time
import cv2
import numpy as np
import tensorflow as tf
from collections import deque
import mediapipe as mp

# ===== USER CONFIG =====
ASL_MODEL = "outputs/models/landmark_mlp_best.h5"
ARROW_MODEL = "outputs/models/landmark_arrow_best.h5"
FEATURE_DIR = "outputs/features"

# ASL
ASL_CLASSES_JSON = os.path.join(FEATURE_DIR, "classes_filtered.json")
if not os.path.exists(ASL_CLASSES_JSON):
    ASL_CLASSES_JSON = os.path.join(FEATURE_DIR, "classes.json")
with open(ASL_CLASSES_JSON, "r") as f:
    asl_classes = json.load(f)
asl_mean = np.load(os.path.join(FEATURE_DIR, "scaler_mean.npy"))
asl_scale = np.load(os.path.join(FEATURE_DIR, "scaler_scale.npy"))
asl_model = tf.keras.models.load_model(ASL_MODEL, compile=False)

# Arrow
with open(os.path.join(FEATURE_DIR, "arrow_classes.json"), "r") as f:
    arrow_classes = json.load(f)
arrow_mean = np.load(os.path.join(FEATURE_DIR, "arrow_scaler_mean.npy"))
arrow_scale = np.load(os.path.join(FEATURE_DIR, "arrow_scaler_scale.npy"))
arrow_model = tf.keras.models.load_model(ARROW_MODEL, compile=False)

# Params
SMOOTH_WINDOW = 8
STABILITY_COUNT = 10
CONF_THRESH = 0.55
SHOW_THUMBNAIL = True

# MediaPipe
mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=False, max_num_hands=2,
                       min_detection_confidence=0.5, min_tracking_confidence=0.3)
mp_draw = mp.solutions.drawing_utils

# State
buf = {"Right": deque(maxlen=SMOOTH_WINDOW), "Left": deque(maxlen=SMOOTH_WINDOW)}
last_pred, consec = {"Right":None, "Left":None}, {"Right":0, "Left":0}
candidate_label, candidate_conf = {"Right":"...", "Left":"..."}, {"Right":0.0, "Left":0.0}
sentence = ""
auto_accept = False

# Helpers
def landmarks_to_vector(landmarks):
    vec = []
    for lm in landmarks.landmark:
        vec.extend([lm.x, lm.y, lm.z])
    return np.array(vec, dtype=np.float32)

def draw_ui(frame, bbox, hand_found, candidate_label, candidate_conf, consec, sentence, auto_accept):
    h, w = frame.shape[:2]
    x1,y1,x2,y2 = bbox
    color = (0,200,0) if hand_found else (255,150,0)
    cv2.rectangle(frame, (x1,y1), (x2,y2), color, 2)

    # candidate text (always Right hand for sentence)
    txt = f"Candidate: {candidate_label['Right']}  {candidate_conf['Right']*100:4.1f}%"
    cv2.putText(frame, txt, (10,30), cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0,255,0), 2)

    # confidence bar
    bar_x, bar_y, bar_w, bar_h = 10, 55, 220, 18
    cv2.rectangle(frame, (bar_x,bar_y), (bar_x+bar_w, bar_y+bar_h), (50,50,50), 1)
    fill = int(bar_w * min(1.0, candidate_conf['Right']))
    cv2.rectangle(frame, (bar_x,bar_y), (bar_x+fill, bar_y+bar_h), (0,200,0), -1)
    cv2.putText(frame, f"Stable: {consec['Right']}/{STABILITY_COUNT}", (bar_x, bar_y+bar_h+20),
                cv2.FONT_HERSHEY_SIMPLEX, 0.45, (200,200,0), 1)

    # Left hand arrow label (shown separately)
    cv2.putText(frame, f"Left hand: {candidate_label['Left']} {candidate_conf['Left']*100:.1f}%",
                (10,120), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (255,200,0), 2)

    # sentence
    max_chars = 40
    display = sentence[-(max_chars*2):]
    cv2.putText(frame, f"Sentence: {display}", (10, h-30),
                cv2.FONT_HERSHEY_SIMPLEX, 0.8, (220,220,255), 2)

    # mode
    mode_text = "AUTO-ACCEPT ON" if auto_accept else "Manual accept (press 's')"
    cv2.putText(frame, mode_text, (10, h-60), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (180,180,180), 1)

    # key help
    cv2.putText(frame, "Keys: s=accept b=backspace SPACE=space c=clear f=toggle auto w=write q=quit",
                (10, h-10), cv2.FONT_HERSHEY_SIMPLEX, 0.45, (150,150,150), 1)

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
        if not ret: break
        frame = cv2.flip(frame, 1)  # horizontal mirror
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = hands.process(img_rgb)

        hand_found = False
        bbox = center_crop_bbox(frame)

        if res.multi_hand_landmarks and res.multi_handedness:
            for hm, handedness in zip(res.multi_hand_landmarks, res.multi_handedness):
                hand_found = True
                label = handedness.classification[0].label  # "Left"/"Right"
                mp_draw.draw_landmarks(frame, hm, mp_hands.HAND_CONNECTIONS)
                vec = landmarks_to_vector(hm)

                # Select model
                if label == "Right":
                    vec_s = (vec - asl_mean) / (asl_scale + 1e-12)
                    probs = asl_model.predict(np.expand_dims(vec_s,0), verbose=0)[0]
                    classes = asl_classes
                else:
                    vec_s = (vec - arrow_mean) / (arrow_scale + 1e-12)
                    probs = arrow_model.predict(np.expand_dims(vec_s,0), verbose=0)[0]
                    classes = arrow_classes

                # update buffer & prediction
                buf[label].append(probs)
                if len(buf[label]) > 0:
                    avg = np.mean(np.array(buf[label]), axis=0)
                    cls = int(np.argmax(avg)); conf = float(avg[cls])
                    if last_pred[label] is None or cls != last_pred[label]:
                        last_pred[label], consec[label] = cls, 1
                    else:
                        consec[label] += 1
                    candidate_label[label] = classes[cls]
                    candidate_conf[label] = conf
                else:
                    candidate_label[label], candidate_conf[label], consec[label] = "...", 0.0, 0

        # auto-accept for Right hand only
        if auto_accept and consec["Right"] >= STABILITY_COUNT and candidate_conf["Right"] >= CONF_THRESH:
            ch = candidate_label["Right"]
            lower = ch.lower()
            if lower in ("space","blank","nothing"):
                sentence += " "
            elif lower == "del":
                sentence = sentence[:-1]
            else:
                sentence += ch[0] if len(ch)>0 else ""
            buf["Right"].clear(); last_pred["Right"]=None; consec["Right"]=0

        # UI
        draw_ui(frame, bbox, hand_found, candidate_label, candidate_conf, consec, sentence, auto_accept)

        # Thumbnail (optional, Right hand only)
        if SHOW_THUMBNAIL and res.multi_hand_landmarks:
            try:
                h_img, w_img = frame.shape[:2]
                xs = [lm.x for lm in res.multi_hand_landmarks[0].landmark]
                ys = [lm.y for lm in res.multi_hand_landmarks[0].landmark]
                xmin = int(max(0, min(xs) * w_img) - 20); ymin = int(max(0, min(ys) * h_img) - 20)
                xmax = int(min(w_img, max(xs) * w_img) + 20); ymax = int(min(h_img, max(ys) * h_img) + 20)
                thumb = cv2.resize(frame[ymin:ymax, xmin:xmax], (120,120))
                frame[10:130, frame.shape[1]-130:frame.shape[1]-10] = thumb
                cv2.rectangle(frame, (frame.shape[1]-130,10), (frame.shape[1]-10,130), (200,200,200), 1)
            except: pass

        cv2.imshow("ASL Sentence Builder (multi-hand)", frame)
        key = cv2.waitKey(1) & 0xFF

        # key handling (same as original)
        if key == ord('q'): break
        elif key == ord('s'):
            ch = candidate_label["Right"]
            lower = ch.lower()
            if lower in ("space","blank","nothing"):
                sentence += " "
            elif lower == "del":
                sentence = sentence[:-1]
            else:
                sentence += ch[0] if len(ch)>0 else ""
            buf["Right"].clear(); last_pred["Right"]=None; consec["Right"]=0
        elif key == ord('b'): sentence = sentence[:-1]
        elif key == ord('c'): sentence = ""
        elif key == ord('f'): auto_accept = not auto_accept
        elif key == ord('w'):
            fname = f"outputs/sentences_{int(time.time())}.txt"
            os.makedirs("outputs", exist_ok=True)
            with open(fname,"w",encoding="utf-8") as fw: fw.write(sentence)
            print("Saved sentence to", fname)
        elif key == 32: sentence += " "
        elif key == ord('p'): print("Sentence:", sentence)

finally:
    cap.release(); cv2.destroyAllWindows(); hands.close()
