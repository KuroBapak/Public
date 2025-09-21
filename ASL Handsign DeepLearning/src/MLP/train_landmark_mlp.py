# src/train_landmark_mlp.py  (robust version)
import os
import numpy as np
from collections import Counter
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
import tensorflow as tf
import json

FEATURE_DIR = "outputs/features"
OUT_DIR = "outputs/models"
os.makedirs(OUT_DIR, exist_ok=True)

# Minimum samples per class to keep. Change this if you prefer.
MIN_SAMPLES_PER_CLASS = 8

# Load data
X = np.load(os.path.join(FEATURE_DIR, "X_landmarks.npy"))
y = np.load(os.path.join(FEATURE_DIR, "y_labels.npy"))
print("Loaded:", X.shape, y.shape)

# Load class names if present
classes = None
classes_path = os.path.join(FEATURE_DIR, "classes.json")
if os.path.exists(classes_path):
    with open(classes_path, "r") as f:
        classes = json.load(f)

# Print counts
cnt = Counter(y.tolist())
print("Class counts (index -> count -> name):")
for idx in sorted(cnt.keys()):
    name = classes[idx] if classes and idx < len(classes) else str(idx)
    print(f"  {idx:3d} -> {cnt[idx]:5d} -> {name}")

# Identify classes to keep
keep_classes = [c for c, ccount in cnt.items() if ccount >= MIN_SAMPLES_PER_CLASS]
removed = [c for c in sorted(cnt.keys()) if c not in keep_classes]
print(f"\nKeeping {len(keep_classes)} classes; removing {len(removed)} classes with < {MIN_SAMPLES_PER_CLASS} samples.")
if removed:
    print("Removed class indices:", removed)
    if classes:
        print("Removed names:", [classes[i] for i in removed])

# If nothing would remain, relax MIN_SAMPLES_PER_CLASS to 2
if len(keep_classes) < 2:
    print("Warning: not enough classes kept. Relaxing MIN_SAMPLES_PER_CLASS to 2.")
    MIN_SAMPLES_PER_CLASS = 2
    keep_classes = [c for c, ccount in cnt.items() if ccount >= MIN_SAMPLES_PER_CLASS]
    removed = [c for c in sorted(cnt.keys()) if c not in keep_classes]
    print(f"Now keeping classes: {keep_classes}")

# Filter dataset
mask = np.isin(y, keep_classes)
X_f = X[mask]
y_f = y[mask]

# Remap labels to 0..K-1
old_to_new = {old:i for i,old in enumerate(sorted(keep_classes))}
y_mapped = np.array([old_to_new[int(v)] for v in y_f], dtype=np.int32)

# Save filtered arrays so you can inspect them
np.save(os.path.join(FEATURE_DIR, "X_landmarks_filtered.npy"), X_f)
np.save(os.path.join(FEATURE_DIR, "y_labels_filtered.npy"), y_mapped)
if classes:
    kept_names = [classes[old] for old in sorted(keep_classes)]
    with open(os.path.join(FEATURE_DIR, "classes_filtered.json"), "w") as f:
        json.dump(kept_names, f)
    print("Saved filtered classes.json with", len(kept_names), "classes.")

print("Filtered dataset shape:", X_f.shape, y_mapped.shape)

# Standardize features
scaler = StandardScaler()
X_train_tmp, X_test_tmp, y_train_tmp, y_test_tmp = train_test_split(
    X_f, y_mapped, test_size=0.25, stratify=y_mapped, random_state=42
)
# Split test into val+test
X_val_tmp, X_test_tmp, y_val_tmp, y_test_tmp = train_test_split(
    X_test_tmp, y_test_tmp, test_size=0.5, stratify=y_test_tmp, random_state=42
)

# Fit scaler on train
scaler.fit(X_train_tmp)
X_train = scaler.transform(X_train_tmp)
X_val = scaler.transform(X_val_tmp)
X_test = scaler.transform(X_test_tmp)

# Save scaler params
np.save(os.path.join(FEATURE_DIR, "scaler_mean.npy"), scaler.mean_)
np.save(os.path.join(FEATURE_DIR, "scaler_scale.npy"), scaler.scale_)

# Build and train small MLP
n_classes = len(np.unique(y_mapped))
nfeat = X_train.shape[1]
print(f"Training MLP with {n_classes} classes and {nfeat} features.")

model = tf.keras.Sequential([
    tf.keras.layers.Input(shape=(nfeat,)),
    tf.keras.layers.Dense(128, activation="relu"),
    tf.keras.layers.Dropout(0.4),
    tf.keras.layers.Dense(64, activation="relu"),
    tf.keras.layers.Dropout(0.3),
    tf.keras.layers.Dense(n_classes, activation="softmax")
])
model.compile(optimizer=tf.keras.optimizers.Adam(1e-3), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
model.summary()

callbacks = [
    tf.keras.callbacks.ModelCheckpoint(os.path.join(OUT_DIR, "landmark_mlp_best.h5"), save_best_only=True, monitor='val_loss'),
    tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=8, restore_best_weights=True)
]

history = model.fit(X_train, y_train_tmp, validation_data=(X_val, y_val_tmp), epochs=100, batch_size=64, callbacks=callbacks)

print("Test eval:", model.evaluate(X_test, y_test_tmp))
model.save(os.path.join(OUT_DIR, "landmark_mlp_final.h5"))
print("Saved model to", OUT_DIR)
