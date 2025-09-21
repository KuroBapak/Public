import os, cv2, json, numpy as np, tensorflow as tf
from collections import deque
import mediapipe as mp

# Paths
ASL_MODEL = "outputs/models/landmark_mlp_best.h5"
ARROW_MODEL = "outputs/models/landmark_arrow_best.h5"
FEATURE_DIR = "outputs/features"

# Load ASL model
with open(os.path.join(FEATURE_DIR,"classes.json")) as f: asl_classes = json.load(f)
asl_mean = np.load(os.path.join(FEATURE_DIR,"scaler_mean.npy"))
asl_scale = np.load(os.path.join(FEATURE_DIR,"scaler_scale.npy"))
asl_model = tf.keras.models.load_model(ASL_MODEL, compile=False)

# Load Arrow model
with open(os.path.join(FEATURE_DIR,"arrow_classes.json")) as f: arrow_classes = json.load(f)
arrow_mean = np.load(os.path.join(FEATURE_DIR,"arrow_scaler_mean.npy"))
arrow_scale = np.load(os.path.join(FEATURE_DIR,"arrow_scaler_scale.npy"))
arrow_model = tf.keras.models.load_model(ARROW_MODEL, compile=False)

# Params
SMOOTH_WINDOW = 8
STABILITY_COUNT = 4
CONF_THRESH = 0.55

mp_hands = mp.solutions.hands
hands = mp_hands.Hands(max_num_hands=2, min_detection_confidence=0.6, min_tracking_confidence=0.5)
mp_draw = mp.solutions.drawing_utils

cap = cv2.VideoCapture(0)

def landmarks_to_vec(hm):
    vec = []
    for lm in hm.landmark:
        vec.extend([lm.x, lm.y, lm.z])
    return np.array(vec, dtype=np.float32)

# Buffers per hand
buf = {"Right": deque(maxlen=SMOOTH_WINDOW), "Left": deque(maxlen=SMOOTH_WINDOW)}
disp_label = {"Right":"...", "Left":"..."}
disp_conf = {"Right":0.0, "Left":0.0}
last_pred, consec = {"Right":None,"Left":None}, {"Right":0,"Left":0}

try:
    while True:
        ret, frame = cap.read()
        if not ret: break
        frame = cv2.flip(frame, 1)  # horizontal mirror
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = hands.process(img_rgb)

        if res.multi_hand_landmarks and res.multi_handedness:
            for hm, handedness in zip(res.multi_hand_landmarks, res.multi_handedness):
                label = handedness.classification[0].label  # "Left"/"Right"
                vec = landmarks_to_vec(hm)
                mp_draw.draw_landmarks(frame, hm, mp_hands.HAND_CONNECTIONS)

                if label=="Right":  # Alphabet
                    vec_s = (vec - asl_mean)/(asl_scale+1e-12)
                    probs = asl_model.predict(np.expand_dims(vec_s,0), verbose=0)[0]
                    classes, model_type = asl_classes, "Right/Alphabet"
                else:  # Left = Arrow
                    vec_s = (vec - arrow_mean)/(arrow_scale+1e-12)
                    probs = arrow_model.predict(np.expand_dims(vec_s,0), verbose=0)[0]
                    classes, model_type = arrow_classes, "Left/Arrow"

                buf[label].append(probs)
                if len(buf[label])>0:
                    avg = np.mean(np.array(buf[label]),axis=0)
                    cls = int(np.argmax(avg)); conf=float(avg[cls])
                    if last_pred[label] is None or cls!=last_pred[label]:
                        last_pred[label]=cls; consec[label]=1
                    else:
                        consec[label]+=1
                    if consec[label]>=STABILITY_COUNT and conf>=CONF_THRESH:
                        disp_label[label]=classes[cls]; disp_conf[label]=conf

                cv2.putText(frame,f"{model_type}: {disp_label[label]} {disp_conf[label]*100:.1f}%",
                            (10,40 if label=="Right" else 80), cv2.FONT_HERSHEY_SIMPLEX,
                            1.0,(0,255,0),2)

        cv2.imshow("ASL + Arrow (multi-hand)", frame)
        if cv2.waitKey(1) & 0xFF==ord('q'): break
finally:
    cap.release(); cv2.destroyAllWindows(); hands.close()
