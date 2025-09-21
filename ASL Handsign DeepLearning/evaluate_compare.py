# evaluate_compare.py
"""
Train & compare three approaches on ASL image dataset (folder structure: asl_alphabet/<CLASS>/*.jpg).
Fixed: MLP (landmark) remaps labels to contiguous indices 0..K-1 for training & evaluation,
so classification_report/plotting won't fail when MediaPipe misses some classes.

Notes:
 - Requires TensorFlow, sklearn, matplotlib.
 - MediaPipe is optional: if not installed, the MLP part will be skipped.
 - This script prints reports and displays plots, it does not save model files by default.
"""

import os
import random
import time
from pathlib import Path
import numpy as np
import matplotlib.pyplot as plt
import tensorflow as tf
from collections import Counter
from sklearn.model_selection import train_test_split
from sklearn.metrics import classification_report, confusion_matrix
from sklearn.preprocessing import StandardScaler
import itertools

# ------------- CONFIG -------------
DATA_DIR = Path("asl_alphabet")   # dataset root (subfolders = classes)
IMG_SIZE = (128, 128)
MAX_PER_CLASS = 400        # limit samples per class to keep memory reasonable
BATCH_SIZE = 32
EPOCHS_CNN = 12
EPOCHS_LSTM = 12
EPOCHS_MLP = 40
VAL_SIZE = 0.15
TEST_SIZE = 0.15
RANDOM_SEED = 42

# LSTM synthetic sequence config
TIMESTEPS = 12
SEQUENCES_PER_CLASS = 200   # number of sequences to generate per class for each split

CACHE = True               # cache extracted landmarks under outputs/features if useful
OUT_FEATURE_DIR = Path("outputs") / "features"
OUT_FEATURE_DIR.mkdir(parents=True, exist_ok=True)
# ----------------------------------

tf.random.set_seed(RANDOM_SEED)
np.random.seed(RANDOM_SEED)
random.seed(RANDOM_SEED)

# ---------- Utilities ----------
def scan_dataset(data_dir, max_per_class=MAX_PER_CLASS):
    classes = sorted([d.name for d in data_dir.iterdir() if d.is_dir()])
    paths = []
    labels = []
    for i, cls in enumerate(classes):
        cls_dir = data_dir / cls
        imgs = [p for p in cls_dir.glob("*") if p.is_file()]
        random.shuffle(imgs)
        use = imgs[:max_per_class] if max_per_class and len(imgs) > max_per_class else imgs
        for p in use:
            paths.append(str(p))
            labels.append(i)
    return np.array(paths), np.array(labels), classes

def preprocess_image_tf(path):
    img = tf.io.read_file(path)
    img = tf.image.decode_image(img, channels=3)
    img.set_shape([None, None, 3])
    img = tf.image.resize(img, IMG_SIZE)
    img = tf.cast(img, tf.float32) / 255.0
    return img

def build_tf_dataset(paths, labels, batch_size=BATCH_SIZE, shuffle=True, augment=False):
    ds = tf.data.Dataset.from_tensor_slices((paths, labels))
    if shuffle:
        ds = ds.shuffle(buffer_size=len(paths), seed=RANDOM_SEED)
    def _map(path, label):
        img = preprocess_image_tf(path)
        if augment:
            img = tf.image.random_flip_left_right(img)
            img = tf.image.random_brightness(img, 0.08)
            img = tf.image.random_contrast(img, 0.95, 1.05)
        return img, label
    ds = ds.map(_map, num_parallel_calls=tf.data.AUTOTUNE)
    ds = ds.batch(batch_size).prefetch(tf.data.AUTOTUNE)
    return ds

def build_cnn(num_classes, input_shape=IMG_SIZE+(3,), base_trainable=False):
    base = tf.keras.applications.MobileNetV2(input_shape=input_shape, include_top=False, weights='imagenet', alpha=0.35)
    base.trainable = base_trainable
    x = base.output
    x = tf.keras.layers.GlobalAveragePooling2D()(x)
    x = tf.keras.layers.Dropout(0.3)(x)
    out = tf.keras.layers.Dense(num_classes, activation='softmax')(x)
    model = tf.keras.Model(inputs=base.input, outputs=out)
    model.compile(optimizer=tf.keras.optimizers.Adam(1e-4), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model, base

def build_lstm(timesteps, feat_dim, num_classes):
    inp = tf.keras.layers.Input(shape=(timesteps, feat_dim))
    x = tf.keras.layers.Masking()(inp)
    x = tf.keras.layers.Bidirectional(tf.keras.layers.LSTM(128, return_sequences=False))(x)
    x = tf.keras.layers.Dropout(0.4)(x)
    out = tf.keras.layers.Dense(num_classes, activation='softmax')(x)
    model = tf.keras.Model(inputs=inp, outputs=out)
    model.compile(optimizer=tf.keras.optimizers.Adam(1e-4), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model

def build_mlp(nfeat, num_classes):
    model = tf.keras.Sequential([
        tf.keras.layers.Input(shape=(nfeat,)),
        tf.keras.layers.Dense(256, activation='relu'),
        tf.keras.layers.Dropout(0.4),
        tf.keras.layers.Dense(128, activation='relu'),
        tf.keras.layers.Dropout(0.3),
        tf.keras.layers.Dense(num_classes, activation='softmax')
    ])
    model.compile(optimizer=tf.keras.optimizers.Adam(1e-3), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model

def extract_landmarks_for_paths(paths):
    """
    Return (feats, valid_idx) where feats is an array (N_valid, 63) and valid_idx are indices into `paths`.
    Uses MediaPipe - if MediaPipe isn't installed, returns (None, None).
    """
    try:
        import mediapipe as mp
    except Exception as e:
        print("MediaPipe not available:", e)
        return None, None
    mp_hands = mp.solutions.hands
    hands = mp_hands.Hands(static_image_mode=True, max_num_hands=1, min_detection_confidence=0.5)
    feats = []
    valid_idx = []
    for i, p in enumerate(paths):
        try:
            raw = tf.io.read_file(p)
            img = tf.image.decode_image(raw, channels=3).numpy()
            img_rgb = img[:, :, ::-1]  # ensure RGB for MediaPipe (tf decoded as RGB already, but keep safe)
            res = hands.process(img_rgb)
            if res and res.multi_hand_landmarks:
                lm = res.multi_hand_landmarks[0]
                vec = []
                for l in lm.landmark:
                    vec.extend([l.x, l.y, l.z])
                feats.append(vec)
                valid_idx.append(i)
        except Exception:
            continue
    hands.close()
    if len(feats) == 0:
        return None, None
    return np.array(feats, dtype=np.float32), np.array(valid_idx, dtype=int)

def plot_history(history, title):
    acc = history.history.get('accuracy') or history.history.get('acc')
    val_acc = history.history.get('val_accuracy') or history.history.get('val_acc')
    loss = history.history.get('loss')
    val_loss = history.history.get('val_loss')
    epochs = range(1, 1 + len(loss))
    plt.figure(figsize=(10,4))
    plt.subplot(1,2,1)
    if acc: plt.plot(epochs, acc, '-', label='train_acc')
    if val_acc: plt.plot(epochs, val_acc, '-', label='val_acc')
    plt.title(f"{title} accuracy"); plt.legend()
    plt.subplot(1,2,2)
    if loss: plt.plot(epochs, loss, '-', label='train_loss')
    if val_loss: plt.plot(epochs, val_loss, '-', label='val_loss')
    plt.title(f"{title} loss"); plt.legend()
    plt.tight_layout()
    plt.show()

def plot_confusion(cm, classes, title="Confusion matrix"):
    plt.figure(figsize=(8,6))
    plt.imshow(cm, interpolation='nearest', cmap=plt.cm.Blues)
    plt.title(title)
    plt.colorbar()
    tick_marks = np.arange(len(classes))
    plt.xticks(tick_marks, classes, rotation=90)
    plt.yticks(tick_marks, classes)
    thresh = cm.max() / 2. if cm.size else 0.0
    for i, j in itertools.product(range(cm.shape[0]), range(cm.shape[1])):
        plt.text(j, i, format(cm[i, j], 'd'),
                 horizontalalignment="center",
                 color="white" if cm[i, j] > thresh else "black")
    plt.ylabel('True label'); plt.xlabel('Predicted label')
    plt.tight_layout()
    plt.show()

# ---------------- MAIN ----------------
def main():
    print("Scanning dataset...")
    paths, labels, class_names = scan_dataset(DATA_DIR, max_per_class=MAX_PER_CLASS)
    if len(paths) == 0:
        raise RuntimeError(f"No images found under {DATA_DIR}. Ensure dataset is arranged as {DATA_DIR}/<class>/*.jpg")
    n_classes = len(class_names)
    print(f"Found {len(paths)} images across {n_classes} classes.")

    # train/val/test split (file paths)
    p_trainval, p_test, y_trainval, y_test = train_test_split(paths, labels, test_size=TEST_SIZE, stratify=labels, random_state=RANDOM_SEED)
    p_train, p_val, y_train, y_val = train_test_split(p_trainval, y_trainval, test_size=VAL_SIZE/(1 - TEST_SIZE), stratify=y_trainval, random_state=RANDOM_SEED)
    print("Split sizes -> train:", len(p_train), "val:", len(p_val), "test:", len(p_test))

    # ---------------- CNN ----------------
    print("\n=== TRAINING CNN (image-based) ===")
    train_ds = build_tf_dataset(p_train, y_train, batch_size=BATCH_SIZE, shuffle=True, augment=True)
    val_ds = build_tf_dataset(p_val, y_val, batch_size=BATCH_SIZE, shuffle=False, augment=False)
    test_ds = build_tf_dataset(p_test, y_test, batch_size=BATCH_SIZE, shuffle=False, augment=False)

    cnn_model, cnn_base = build_cnn(n_classes, input_shape=IMG_SIZE+(3,), base_trainable=False)
    cnn_model.summary()
    cb = [tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=4, restore_best_weights=True)]
    hist_cnn = cnn_model.fit(train_ds, validation_data=val_ds, epochs=EPOCHS_CNN, callbacks=cb, verbose=2)
    plot_history(hist_cnn, "CNN")
    print("Evaluating CNN on test set...")
    test_loss, test_acc = cnn_model.evaluate(test_ds, verbose=0)
    print(f"CNN test loss: {test_loss:.4f}, test acc: {test_acc:.4f}")

    # predictions for confusion
    y_true = []
    y_pred = []
    for xb, yb in test_ds:
        preds = cnn_model.predict(xb, verbose=0)
        y_pred.extend(np.argmax(preds, axis=1).tolist())
        y_true.extend(yb.numpy().tolist())
    print("CNN classification report:")
    print(classification_report(y_true, y_pred, target_names=class_names, zero_division=0))
    cm = confusion_matrix(y_true, y_pred)
    plot_confusion(cm, class_names, title="CNN confusion matrix")

    # ---------------- CNN->LSTM (synthetic sequences) ----------------
    print("\n=== TRAINING CNN->LSTM (synthetic sequences) ===")
    feat_model = tf.keras.Model(cnn_base.input, tf.keras.layers.GlobalAveragePooling2D()(cnn_base.output))
    feat_dim = feat_model.output_shape[-1]
    print("Feature dim:", feat_dim)

    def create_sequences(paths_split, labels_split, seq_per_class=SEQUENCES_PER_CLASS, timesteps=TIMESTEPS):
        by_class = {}
        for p, l in zip(paths_split, labels_split):
            by_class.setdefault(int(l), []).append(p)
        Xs = []
        Ys = []
        for cls_idx, items in by_class.items():
            if len(items) == 0:
                continue
            for _ in range(seq_per_class):
                seq_paths = [random.choice(items) for _ in range(timesteps)]
                imgs = np.stack([tf.image.resize(tf.io.decode_image(tf.io.read_file(sp), channels=3), IMG_SIZE).numpy().astype(np.float32)/255.0 for sp in seq_paths], axis=0)
                feats = feat_model.predict(imgs, verbose=0)  # (T, feat_dim)
                Xs.append(feats)
                Ys.append(cls_idx)
        return np.array(Xs), np.array(Ys, dtype=np.int32)

    X_seq_train, y_seq_train = create_sequences(p_train, y_train, seq_per_class=SEQUENCES_PER_CLASS, timesteps=TIMESTEPS)
    X_seq_val, y_seq_val = create_sequences(p_val, y_val, seq_per_class=max(40, SEQUENCES_PER_CLASS//4), timesteps=TIMESTEPS)
    X_seq_test, y_seq_test = create_sequences(p_test, y_test, seq_per_class=max(60, SEQUENCES_PER_CLASS//3), timesteps=TIMESTEPS)
    print("Sequences shapes:", X_seq_train.shape, X_seq_val.shape, X_seq_test.shape)

    lstm_model = build_lstm(TIMESTEPS, feat_dim, n_classes)
    lstm_model.summary()
    cb = [tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=4, restore_best_weights=True)]
    hist_lstm = lstm_model.fit(X_seq_train, y_seq_train, validation_data=(X_seq_val, y_seq_val), epochs=EPOCHS_LSTM, batch_size=16, callbacks=cb, verbose=2)
    plot_history(hist_lstm, "CNN->LSTM")

    loss_lstm, acc_lstm = lstm_model.evaluate(X_seq_test, y_seq_test, verbose=0)
    print(f"LSTM test loss: {loss_lstm:.4f}, test acc: {acc_lstm:.4f}")
    preds = lstm_model.predict(X_seq_test, verbose=0)
    ypred = np.argmax(preds, axis=1)
    print("LSTM classification report:")
    print(classification_report(y_seq_test, ypred, target_names=class_names, zero_division=0))
    cm_l = confusion_matrix(y_seq_test, ypred)
    plot_confusion(cm_l, class_names, title="LSTM confusion matrix")

    # ---------------- Landmark MLP (with remapping) ----------------
    print("\n=== TRAINING Landmark MLP (MediaPipe) ===")
    lm_cache = OUT_FEATURE_DIR / "X_landmarks.npy"
    idx_cache = OUT_FEATURE_DIR / "idx_landmarks.npy"
    landmark_available = False
    if lm_cache.exists() and idx_cache.exists():
        print("Loading cached landmarks...")
        X_land = np.load(lm_cache)
        idxs = np.load(idx_cache)
        landmark_available = True
    else:
        feats, valid_idx = extract_landmarks_for_paths(paths)
        if feats is None or valid_idx is None:
            print("No landmarks extracted or MediaPipe not available. Skipping MLP.")
            landmark_available = False
        else:
            X_land = feats
            idxs = valid_idx
            if CACHE:
                np.save(str(lm_cache), X_land)
                np.save(str(idx_cache), idxs)
            landmark_available = True

    if landmark_available:
        # Build y_all from original labels aligned to 'paths'
        full_labels = labels  # labels from scan_dataset
        y_all_raw = full_labels[idxs]  # original label ids for images with landmarks

        # REMAP original label ids -> contiguous 0..K-1
        unique_all = np.unique(y_all_raw)
        old2new = {old: idx for idx, old in enumerate(sorted(unique_all))}
        y_all_mapped = np.array([old2new[int(v)] for v in y_all_raw], dtype=np.int32)
        class_names_filtered = [class_names[int(old)] for old in sorted(unique_all)]
        print("Landmark classes present (original ids):", list(sorted(unique_all)))
        print("Filtered class names (for MLP):", class_names_filtered)

        # Now split using y_all_mapped (stratified)
        X_tr, X_tmp, y_tr, y_tmp = train_test_split(X_land, y_all_mapped, test_size=TEST_SIZE + VAL_SIZE, stratify=y_all_mapped, random_state=RANDOM_SEED)
        prop = TEST_SIZE / (TEST_SIZE + VAL_SIZE)
        X_val_l, X_test_l, y_val_l, y_test_l = train_test_split(X_tmp, y_tmp, test_size=prop, stratify=y_tmp, random_state=RANDOM_SEED)

        # scale features
        scaler = StandardScaler()
        X_tr_s = scaler.fit_transform(X_tr)
        X_val_s = scaler.transform(X_val_l)
        X_test_s = scaler.transform(X_test_l)

        # build & train MLP with n_classes = len(class_names_filtered)
        mlp = build_mlp(X_tr_s.shape[1], len(class_names_filtered))
        mlp.summary()
        cb = [tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=6, restore_best_weights=True)]
        hist_mlp = mlp.fit(X_tr_s, y_tr, validation_data=(X_val_s, y_val_l), epochs=EPOCHS_MLP, batch_size=64, callbacks=cb, verbose=2)
        plot_history(hist_mlp, "Landmark MLP")

        loss_m, acc_m = mlp.evaluate(X_test_s, y_test_l, verbose=0)
        print(f"MLP test loss: {loss_m:.4f}, test acc: {acc_m:.4f}")

        ypred_m = np.argmax(mlp.predict(X_test_s, verbose=0), axis=1)
        print("MLP classification report (filtered classes):")
        print(classification_report(y_test_l, ypred_m, target_names=class_names_filtered, zero_division=0))

        cm_m = confusion_matrix(y_test_l, ypred_m)
        plot_confusion(cm_m, class_names_filtered, title="MLP confusion matrix (filtered classes)")
    else:
        print("MLP (landmark) not run.")

    # ---------------- Summary ----------------
    print("\n=== SUMMARY ===")
    print("CNN test acc:", f"{test_acc:.4f}")
    print("LSTM test acc:", f"{acc_lstm:.4f}")
    if landmark_available:
        print("MLP test acc:", f"{acc_m:.4f}")
    print("Finished.")

if __name__ == "__main__":
    t0 = time.time()
    main()
    print("Elapsed (s):", round(time.time() - t0, 1))
