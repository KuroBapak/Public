import os, cv2, numpy as np, mediapipe as mp

OUT_DIR = "outputs/features"
os.makedirs(OUT_DIR, exist_ok=True)

LABELS = {"u":0, "d":1, "l":2, "r":3}  # up, down, left, right
X, y = [], []

mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=False, max_num_hands=1,
                       min_detection_confidence=0.5, min_tracking_confidence=0.5)
mp_draw = mp.solutions.drawing_utils

def landmarks_to_vec(landmarks):
    vec = []
    for lm in landmarks.landmark:
        vec.extend([lm.x, lm.y, lm.z])
    return np.array(vec, dtype=np.float32)

cap = cv2.VideoCapture(0)
print("Press [U,D,L,R] to record UP/DOWN/LEFT/RIGHT gesture. Press Q to quit.")

try:
    while True:
        ret, frame = cap.read()
        if not ret:
            break
        frame = cv2.flip(frame, 1)  # horizontal mirror
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = hands.process(img_rgb)
        if res.multi_hand_landmarks:
            hm = res.multi_hand_landmarks[0]
            mp_draw.draw_landmarks(frame, hm, mp_hands.HAND_CONNECTIONS)

            key = cv2.waitKey(1) & 0xFF
            if chr(key).lower() in LABELS:
                vec = landmarks_to_vec(hm)
                X.append(vec)
                y.append(LABELS[chr(key).lower()])
                print(f"Captured {chr(key).upper()}, total samples: {len(X)}")

        cv2.imshow("Arrow Capture", frame)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
finally:
    cap.release()
    cv2.destroyAllWindows()
    hands.close()

X = np.array(X, dtype=np.float32)
y = np.array(y, dtype=np.int32)

np.save(os.path.join(OUT_DIR, "X_arrow.npy"), X)
np.save(os.path.join(OUT_DIR, "y_arrow.npy"), y)
with open(os.path.join(OUT_DIR, "arrow_classes.json"), "w") as f:
    import json; json.dump(["UP","DOWN","LEFT","RIGHT"], f)
print("✅ Saved arrow dataset:", X.shape, y.shape)
