import os, numpy as np, tensorflow as tf
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
import json

FEATURE_DIR = "outputs/features"
MODEL_PATH = "outputs/models/landmark_arrow_best.h5"
os.makedirs("outputs/models", exist_ok=True)

X = np.load(os.path.join(FEATURE_DIR, "X_arrow.npy"))
y = np.load(os.path.join(FEATURE_DIR, "y_arrow.npy"))

# scale
scaler = StandardScaler()
X = scaler.fit_transform(X)
np.save(os.path.join(FEATURE_DIR, "arrow_scaler_mean.npy"), scaler.mean_)
np.save(os.path.join(FEATURE_DIR, "arrow_scaler_scale.npy"), scaler.scale_)

# split
X_train, X_val, y_train, y_val = train_test_split(X, y, test_size=0.2, stratify=y, random_state=42)

# build model
model = tf.keras.Sequential([
    tf.keras.layers.Input(shape=(63,)),
    tf.keras.layers.Dense(128, activation='relu'),
    tf.keras.layers.Dropout(0.3),
    tf.keras.layers.Dense(64, activation='relu'),
    tf.keras.layers.Dense(4, activation='softmax')
])
model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])

# train
history = model.fit(X_train, y_train, validation_data=(X_val,y_val),
                    epochs=30, batch_size=32)

model.save(MODEL_PATH)
print("✅ Arrow model saved to", MODEL_PATH)

with open(os.path.join(FEATURE_DIR, "arrow_classes.json"), "r") as f:
    classes = json.load(f)
print("Classes:", classes)
