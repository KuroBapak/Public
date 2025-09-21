# src/extract_landmarks_images.py
import os, json
import numpy as np
import cv2
from tqdm import tqdm

# MediaPipe import
import mediapipe as mp

ASL_DIR = "asl_alphabet"   # adjust if needed (project root/asl_alphabet)
OUT_DIR = "outputs/features"
os.makedirs(OUT_DIR, exist_ok=True)

mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=True, max_num_hands=1, min_detection_confidence=0.5)
mp_drawing = mp.solutions.drawing_utils

classes = sorted([d for d in os.listdir(ASL_DIR) if os.path.isdir(os.path.join(ASL_DIR, d))])
print("Found classes:", classes)

X = []
y = []
skipped = 0
for label_idx, cls in enumerate(classes):
    cls_dir = os.path.join(ASL_DIR, cls)
    files = [f for f in os.listdir(cls_dir) if f.lower().endswith((".jpg",".jpeg",".png"))]
    for fname in tqdm(files, desc=f"Processing {cls}"):
        path = os.path.join(cls_dir, fname)
        img = cv2.imread(path)
        if img is None:
            skipped += 1
            continue
        img_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        results = hands.process(img_rgb)
        if not results.multi_hand_landmarks:
            # skip if no hand detected
            skipped += 1
            continue
        # take first hand
        hand = results.multi_hand_landmarks[0]
        # landmarks: 21 points; each has x,y,z normalized coordinates
        vec = []
        for lm in hand.landmark:
            vec.extend([lm.x, lm.y, lm.z])
        X.append(vec)
        y.append(label_idx)
        # optional: add horizontally flipped version (augment)
        img_flip = cv2.flip(img_rgb, 1)
        res2 = hands.process(img_flip)
        if res2.multi_hand_landmarks:
            hand2 = res2.multi_hand_landmarks[0]
            vec2 = []
            for lm in hand2.landmark:
                # because flip changes x coordinate relative to image, but MediaPipe's normalized coords correspond to flipped image already
                vec2.extend([lm.x, lm.y, lm.z])
            X.append(vec2)
            y.append(label_idx)

hands.close()

X = np.array(X, dtype=np.float32)
y = np.array(y, dtype=np.int32)
print("Saved samples:", X.shape, y.shape, "skipped:", skipped)

np.save(os.path.join(OUT_DIR, "X_landmarks.npy"), X)
np.save(os.path.join(OUT_DIR, "y_labels.npy"), y)
with open(os.path.join(OUT_DIR, "classes.json"), "w") as f:
    json.dump(classes, f)
print("Features saved to", OUT_DIR)
