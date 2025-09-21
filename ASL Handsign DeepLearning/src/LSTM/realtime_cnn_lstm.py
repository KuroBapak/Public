# src/realtime_cnn_lstm.py
import cv2, numpy as np, tensorflow as tf
from collections import deque
import os

IMG_SIZE = (128,128)
TIMESTEPS = 30

# Load feature extractor
from models import mobilenet_feature_extractor
feat_model = mobilenet_feature_extractor(input_shape=IMG_SIZE+(3,))
lstm = tf.keras.models.load_model("outputs/models/cnn_lstm_best.h5")
classes = sorted([d for d in os.listdir("asl_alphabet") if os.path.isdir(os.path.join("asl_alphabet", d))])

cap = cv2.VideoCapture(0)
buffer = deque(maxlen=TIMESTEPS)
status_text = "No hand"

while True:
    ret, frame = cap.read()
    if not ret: break
    frame = cv2.flip(frame, 1)
    img = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    im = cv2.resize(img, IMG_SIZE).astype('float32')/255.0
    feat = feat_model.predict(np.expand_dims(im,0), verbose=0)[0]
    buffer.append(feat)

    label_text, conf = "...", 0.0
    if len(buffer) == TIMESTEPS:
        seq = np.expand_dims(np.array(buffer),0)
        pred = lstm.predict(seq, verbose=0)[0]
        cls, conf = int(np.argmax(pred)), float(np.max(pred))
        label_text = classes[cls]
        status_text = f"Recognized {label_text}" if conf >= 0.6 else "Low confidence"
    else:
        status_text = "Collecting frames..."

    cv2.putText(frame, f"Pred: {label_text} {conf*100:.1f}%", (10,40),
                cv2.FONT_HERSHEY_SIMPLEX, 1.0, (0,255,0),2)
    cv2.putText(frame, status_text, (10,70), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0,200,255), 2)

    cv2.imshow("Realtime LSTM", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'): break

cap.release()
cv2.destroyAllWindows()
