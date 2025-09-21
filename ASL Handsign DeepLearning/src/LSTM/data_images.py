# src/data_images.py
import os, random
import numpy as np
import tensorflow as tf
from sklearn.model_selection import train_test_split

def collect_files(root_dir):
    classes = sorted([d for d in os.listdir(root_dir) if os.path.isdir(os.path.join(root_dir,d))])
    filepaths, labels = [], []
    for i, c in enumerate(classes):
        cls_dir = os.path.join(root_dir, c)
        for fname in os.listdir(cls_dir):
            if fname.lower().endswith((".jpg", ".jpeg", ".png")):
                filepaths.append(os.path.join(cls_dir, fname))
                labels.append(i)
    return filepaths, labels, classes

def split_paths(filepaths, labels, test_size=0.15, val_size=0.15, seed=42):
    # first split off test
    train_paths, test_paths, train_labels, test_labels = train_test_split(
        filepaths, labels, test_size=test_size, stratify=labels, random_state=seed)
    # from train split val
    val_relative = val_size / (1.0 - test_size)
    train_paths, val_paths, train_labels, val_labels = train_test_split(
        train_paths, train_labels, test_size=val_relative, stratify=train_labels, random_state=seed)
    return (train_paths, train_labels), (val_paths, val_labels), (test_paths, test_labels)

def _read_and_preprocess(path, label, img_size=(128,128)):
    image = tf.io.read_file(path)
    image = tf.image.decode_jpeg(image, channels=3)
    image = tf.image.resize(image, img_size)
    image = tf.cast(image, tf.float32) / 255.0
    return image, label

def make_dataset(paths, labels, img_size=(128,128), batch_size=32, shuffle=True, augment=False):
    paths = np.array(paths)
    labels = np.array(labels, dtype=np.int32)
    ds = tf.data.Dataset.from_tensor_slices((paths, labels))
    if shuffle:
        ds = ds.shuffle(buffer_size=len(paths))
    ds = ds.map(lambda p,l: _read_and_preprocess(p,l,img_size), num_parallel_calls=tf.data.AUTOTUNE)
    if augment:
        aug = tf.keras.Sequential([
            tf.keras.layers.RandomFlip("horizontal"),
            tf.keras.layers.RandomRotation(0.08),
            tf.keras.layers.RandomZoom(0.08),
        ])
        ds = ds.map(lambda x,y: (aug(x, training=True), y), num_parallel_calls=tf.data.AUTOTUNE)
    ds = ds.batch(batch_size).prefetch(tf.data.AUTOTUNE)
    return ds

def get_datasets(root_dir, img_size=(128,128), batch_size=32, test_size=0.15, val_size=0.15):
    filepaths, labels, classes = collect_files(root_dir)
    (train_p, train_l), (val_p, val_l), (test_p, test_l) = split_paths(filepaths, labels, test_size=test_size, val_size=val_size)
    train_ds = make_dataset(train_p, train_l, img_size, batch_size, shuffle=True, augment=True)
    val_ds   = make_dataset(val_p, val_l, img_size, batch_size, shuffle=False, augment=False)
    test_ds  = make_dataset(test_p, test_l, img_size, batch_size, shuffle=False, augment=False)
    return train_ds, val_ds, test_ds, classes, (train_p, train_l), (val_p, val_l), (test_p, test_l)
