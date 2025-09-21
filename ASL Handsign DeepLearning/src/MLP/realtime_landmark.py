# src/realtime_landmark.py
import os, time
import cv2, json, numpy as np, tensorflow as tf
from collections import deque
import mediapipe as mp

MODEL_PATH = "outputs/models/landmark_mlp_best.h5"
FEATURE_DIR = "outputs/features"
CLASSES_JSON = os.path.join(FEATURE_DIR, "classes.json")

# params
SMOOTH_WINDOW = 8
STABILITY_COUNT = 4
CONF_THRESH = 0.55

with open(CLASSES_JSON, "r") as f:
    classes = json.load(f)

# load scaler
mean = np.load(os.path.join(FEATURE_DIR, "scaler_mean.npy"))
scale = np.load(os.path.join(FEATURE_DIR, "scaler_scale.npy"))

model = tf.keras.models.load_model(MODEL_PATH, compile=False)
print("Loaded model:", MODEL_PATH)

mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=False, max_num_hands=1,
                       min_detection_confidence=0.5, min_tracking_confidence=0.3)
mp_draw = mp.solutions.drawing_utils

cap = cv2.VideoCapture(0)
buf = deque(maxlen=SMOOTH_WINDOW)
last_pred = None
consec = 0
disp_label = "..."
disp_conf = 0.0

def landmarks_to_vector(landmarks):
    vec = []
    for lm in landmarks.landmark:
        vec.extend([lm.x, lm.y, lm.z])
    return np.array(vec, dtype=np.float32)

try:
    while True:
        ret, frame = cap.read()
        if not ret:
            break
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = hands.process(img_rgb)
        if res.multi_hand_landmarks:
            hm = res.multi_hand_landmarks[0]
            vec = landmarks_to_vector(hm)
            # standardize using saved mean/scale
            vec_s = (vec - mean) / (scale + 1e-12)
            # predict
            probs = model.predict(np.expand_dims(vec_s, axis=0), verbose=0)[0]
            buf.append(probs)
            # draw landmarks
            mp_draw.draw_landmarks(frame, hm, mp_hands.HAND_CONNECTIONS)
        else:
            # no hand detected: append small uniform probs to keep buffer moving
            if len(buf) > 0:
                buf.append(buf[-1]*0.5)  # decay
        if len(buf) > 0:
            avg = np.mean(np.array(buf), axis=0)
            cls = int(np.argmax(avg)); conf = float(avg[cls])
            # stability
            if last_pred is None or cls != last_pred:
                last_pred = cls; consec = 1
            else:
                consec += 1
            if consec >= STABILITY_COUNT and conf >= CONF_THRESH:
                disp_label = classes[cls]
                disp_conf = conf
        # UI
        text = f"{disp_label} {disp_conf*100:4.1f}%"
        cv2.putText(frame, text, (10,40), cv2.FONT_HERSHEY_SIMPLEX, 1.0, (0,255,0), 2)
        # show
        cv2.imshow("ASL - landmarks", frame)
        key = cv2.waitKey(1) & 0xFF
        if key == ord('q'):
            break
        if key == ord('c'):
            buf.clear(); last_pred=None; consec=0; disp_label="..."; disp_conf=0.0
finally:
    cap.release()
    cv2.destroyAllWindows()
    hands.close()
