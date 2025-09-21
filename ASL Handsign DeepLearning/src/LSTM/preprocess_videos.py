# src/preprocess_videos.py
import os, glob, numpy as np, cv2
from models import mobilenet_feature_extractor
from tqdm import tqdm

TIMESTEPS = 30
IMG_SIZE = (128,128)

def sample_frames_from_video(video_path, timesteps=TIMESTEPS, img_size=IMG_SIZE):
    cap = cv2.VideoCapture(video_path)
    frames = []
    while True:
        ret, f = cap.read()
        if not ret: break
        f = cv2.cvtColor(f, cv2.COLOR_BGR2RGB)
        f = cv2.resize(f, img_size)
        frames.append(f)
    cap.release()
    if len(frames) == 0:
        return None
    if len(frames) >= timesteps:
        idx = np.linspace(0, len(frames)-1, timesteps, dtype=int)
        frames = [frames[i] for i in idx]
    else:
        # pad by repeating last
        while len(frames) < timesteps:
            frames.append(frames[-1])
    arr = np.array(frames).astype('float32') / 255.0
    return arr  # shape (TIMESTEPS, H, W, 3)

def extract_features_from_videos(videos_root, out_npy="outputs/features", timesteps=TIMESTEPS):
    os.makedirs(out_npy, exist_ok=True)
    feat_model = mobilenet_feature_extractor(input_shape=IMG_SIZE+(3,))
    X_list, y_list = [], []
    classes = sorted([d for d in os.listdir(videos_root) if os.path.isdir(os.path.join(videos_root,d))])
    for i, c in enumerate(classes):
        cls_dir = os.path.join(videos_root, c)
        for v in glob.glob(os.path.join(cls_dir, "*.avi")):
            frames = sample_frames_from_video(v, timesteps=timesteps, img_size=IMG_SIZE)
            if frames is None: continue
            # predict features per frame
            feats = feat_model.predict(frames, verbose=0)  # (TIMESTEPS, feat_dim)
            X_list.append(feats)
            y_list.append(i)
    X = np.array(X_list)   # (N, TIMESTEPS, feat_dim)
    y = np.array(y_list)
    np.save(os.path.join(out_npy, "X_feats.npy"), X)
    np.save(os.path.join(out_npy, "y_labels.npy"), y)
    print("Saved features:", X.shape, y.shape)

if __name__ == "__main__":
    extract_features_from_videos("dataset_videos", out_npy="outputs/features", timesteps=TIMESTEPS)
