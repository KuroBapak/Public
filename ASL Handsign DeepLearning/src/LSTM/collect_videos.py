# src/collect_videos.py (run)python src\collect_videos.py --class A --n 40 --sec 1.5
import cv2, os, time, argparse

def record_clips_for_class(out_dir, class_name, n_clips=50, clip_seconds=1.5, fps=15):
    cls_dir = os.path.join(out_dir, class_name)
    os.makedirs(cls_dir, exist_ok=True)
    cap = cv2.VideoCapture(0)
    print("Press 'r' to record one clip, 'q' to quit class.")
    cnt = 0
    while cnt < n_clips:
        ret, frame = cap.read()
        if not ret:
            break
        display = frame.copy()
        cv2.putText(display, f"Class: {class_name} - clip {cnt+1}/{n_clips}", (10,30), cv2.FONT_HERSHEY_SIMPLEX, 1, (0,255,0),2)
        cv2.imshow("Recorder", display)
        key = cv2.waitKey(1) & 0xFF
        if key == ord('r'):
            # start recording
            fname = os.path.join(cls_dir, f"{class_name}_{int(time.time())}.avi")
            fourcc = cv2.VideoWriter_fourcc(*'XVID')
            h, w = frame.shape[:2]
            out = cv2.VideoWriter(fname, fourcc, fps, (w,h))
            print("Recording...")
            frames_to_capture = int(clip_seconds * fps)
            for i in range(frames_to_capture):
                ret, f = cap.read()
                if not ret:
                    break
                out.write(f)
                cv2.imshow("Recorder", f)
                if cv2.waitKey(1) & 0xFF == ord('q'):
                    break
            out.release()
            print("Saved:", fname)
            cnt += 1
        elif key == ord('q'):
            break
    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    ap = argparse.ArgumentParser()
    ap.add_argument("--out", default="dataset_videos", help="output directory (project root)")
    ap.add_argument("--class", dest="classname", required=True, help="class label to record (e.g., A)")
    ap.add_argument("--n", type=int, default=30)
    ap.add_argument("--sec", type=float, default=1.5)
    args = ap.parse_args()
    record_clips_for_class(args.out, args.classname, n_clips=args.n, clip_seconds=args.sec)
