🔹 Usage

When you want to run CNN/LSTM:
.venv_cnn\Scripts\activate
python src\CNN\realtime_cnn.py
python src\LSTM\realtime_cnn_lstm.py

When you want to run MLP + Arduino hand detection:
.venv_mlp\Scripts\activate
python src\MLP\realtime_multihand_sentence.py

*choose the Architechture in the folder then run python src\MLP\(Name).py*

Notes :
📂 src/CNN/

models.py
Defines the CNN architectures (e.g. MobileNetV2, custom CNN) used for ASL image classification.

train_cnn.py
Trains a CNN model on the ASL alphabet dataset (images), saves the model (.h5) and plots training results.
➝ Used with datasets like asl_alphabet/train and asl_alphabet/val.

realtime_cnn.py
Runs real-time hand sign classification from the camera using the trained CNN model.
Predictions may be fast-changing (no smoothing).

realtime_cnn_stable.py
Improved version of the above with smoothing, stability, and confidence thresholds to avoid flickering predictions.

📂 src/LSTM/

collect_videos.py
Used to record short sign language videos (A, B, etc.) with your webcam, saving them into dataset_videos/.
These videos are later preprocessed for LSTM training.

data_images.py
Converts video frames into images or sequences for processing (helper script for dataset preparation).

preprocess_videos.py
Extracts frames/landmarks from the collected videos, resizes, normalizes, and saves them in a dataset format usable by LSTM.

train_cnn_lstm.py
Trains a hybrid CNN + LSTM model.
CNN extracts spatial features (hand shapes), LSTM captures temporal dynamics (movement across frames).
➝ This is for video-based sign language recognition.

realtime_cnn_lstm.py
Uses the trained CNN+LSTM model to classify live camera video sequences instead of single images.
More suitable for continuous gesture recognition (signs with motion).

📂 src/MLP/

extract_landmarks_images.py
Uses Mediapipe Hand Landmarks to extract (x, y, z) coordinates from each ASL image or video frame, saving them as .npy or .csv.
➝ Reduces problem to numeric landmark classification instead of raw pixels.

train_landmark_mlp.py
Trains a Multi-Layer Perceptron (MLP) using the extracted landmarks.
➝ Faster and lighter than CNN, very accurate if landmarks are good.

realtime_landmark.py
Real-time recognition using Mediapipe landmarks + trained MLP model.
➝ This was the one that worked really well and stable for you earlier.

realtime_sentence.py
Extension of realtime_landmark.py:
Allows building sentences by combining predicted letters/words (e.g., pressing S to save letters, space between words, etc.).

📂 asl_alphabet
Consist of datasets of ASL handsign datas from kaggle.

📂 dataset_videos
These videos are taken from collect_videos.py later preprocessed for LSTM training.

Runable
Remove-Item -Recurse -Force .venv

pip freeze > requirements-MLP.txt

python -m venv .venv_cnn
.venv_cnn\Scripts\activate
pip install --upgrade pip
pip install -r requirements-CNN.txt
pip install tensorflow==2.11.0 protobuf<3.20 opencv-python numpy scikit-learn matplotlib tqdm mediapipe
deactivate