# src/train_cnn_lstm.py
import numpy as np
from sklearn.model_selection import train_test_split
from models import build_lstm
import tensorflow as tf
import os

X = np.load("outputs/features/X_feats.npy")  # shape (N, T, feat_dim)
y = np.load("outputs/features/y_labels.npy")

# train/val/test split
X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.25, stratify=y, random_state=42)
X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=0.5, stratify=y_temp, random_state=42)

timesteps = X_train.shape[1]
feat_dim  = X_train.shape[2]
n_classes = len(np.unique(y))

model = build_lstm(timesteps, feat_dim, n_classes=n_classes)

os.makedirs("outputs/models", exist_ok=True)
callbacks = [
    tf.keras.callbacks.ModelCheckpoint("outputs/models/cnn_lstm_best.h5", save_best_only=True, monitor='val_loss'),
    tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=6, restore_best_weights=True)
]

history = model.fit(X_train, y_train, validation_data=(X_val, y_val), epochs=50, batch_size=16, callbacks=callbacks)

print("Evaluate LSTM on test:")
print(model.evaluate(X_test, y_test))
model.save("outputs/models/cnn_lstm_final.h5")
