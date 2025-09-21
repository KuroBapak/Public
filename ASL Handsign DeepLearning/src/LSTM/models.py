# src/models.py
import tensorflow as tf
from tensorflow.keras import layers, models

def small_cnn(input_shape=(128,128,3), n_classes=26):
    inp = layers.Input(shape=input_shape)
    x = layers.Conv2D(32,3,activation='relu',padding='same')(inp)
    x = layers.MaxPool2D()(x)
    x = layers.Conv2D(64,3,activation='relu',padding='same')(x)
    x = layers.MaxPool2D()(x)
    x = layers.Conv2D(128,3,activation='relu',padding='same')(x)
    x = layers.GlobalAveragePooling2D()(x)
    x = layers.Dense(256, activation='relu')(x)
    x = layers.Dropout(0.4)(x)
    out = layers.Dense(n_classes, activation='softmax')(x)
    model = models.Model(inp, out)
    model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model

def mobilenet_finetune(input_shape=(128,128,3), n_classes=26):
    base = tf.keras.applications.MobileNetV2(input_shape=input_shape, include_top=False, weights='imagenet', pooling='avg')
    base.trainable = False
    inp = layers.Input(shape=input_shape)
    x = tf.keras.applications.mobilenet_v2.preprocess_input(inp*255.0)  # if images are [0,1]
    x = base(x, training=False)
    x = layers.Dropout(0.3)(x)
    x = layers.Dense(256, activation='relu')(x)
    out = layers.Dense(n_classes, activation='softmax')(x)
    model = models.Model(inp, out)
    model.compile(optimizer=tf.keras.optimizers.Adam(1e-4), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model

def mobilenet_feature_extractor(input_shape=(128,128,3)):
    base = tf.keras.applications.MobileNetV2(input_shape=input_shape, include_top=False, weights='imagenet', pooling='avg')
    base.trainable = False
    # returns a model that maps image -> feature vector (e.g., 1280)
    return models.Model(base.input, base.output, name='mobilenet_feat')
    
def build_lstm(timesteps, feature_dim, n_classes=26):
    inp = layers.Input(shape=(timesteps, feature_dim))
    x = layers.Masking(mask_value=0.0)(inp)
    x = layers.Bidirectional(layers.LSTM(256, return_sequences=False))(x)
    x = layers.Dense(256, activation='relu')(x)
    x = layers.Dropout(0.4)(x)
    out = layers.Dense(n_classes, activation='softmax')(x)
    model = models.Model(inp, out)
    model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model
