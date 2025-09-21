# src/train_cnn.py
import os
from data_images import get_datasets
from models import mobilenet_finetune
import tensorflow as tf

DATA_DIR = "asl_alphabet"   # run this from src/ with cwd = project root OR change path accordingly
IMG_SIZE = (128,128)
BATCH = 32
EPOCHS = 12

# If you run from project root, use:
train_ds, val_ds, test_ds, class_names, *_ = get_datasets("asl_alphabet", img_size=IMG_SIZE, batch_size=BATCH)

model = mobilenet_finetune(input_shape=IMG_SIZE+(3,), n_classes=len(class_names))

os.makedirs("outputs/models/", exist_ok=True)  # windows friendly; adjust for linux if desired

callbacks = [
    tf.keras.callbacks.ModelCheckpoint("outputs/models/mobilenet_asl_best.h5", save_best_only=True, monitor='val_loss'),
    tf.keras.callbacks.ReduceLROnPlateau(monitor='val_loss', factor=0.5, patience=2),
    tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=4, restore_best_weights=True)
]

history = model.fit(train_ds, validation_data=val_ds, epochs=EPOCHS, callbacks=callbacks)
model.save("outputs/models/mobilenet_asl_final.h5")

# evaluate
print("Evaluating on test set...")
res = model.evaluate(test_ds)
print("Test result:", res)
