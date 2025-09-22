# streamlit_launcher_fixed2.py
import streamlit as st
import subprocess
import sys
import threading
import time
from pathlib import Path

st.set_page_config(page_title="ASL Image Recognition", layout="centered")
st.title("ASL MLP Image Recognition - Model Launcher")

HERE = Path(__file__).resolve().parent

def find_script(filename: str):
    # cari file skrip di seluruh project tree (rekursif)
    for p in HERE.rglob(filename):
        return p
    return None

multi_name = "realtime_multihand_sentence.py"
single_name = "realtime_sentence.py"

multi_script = find_script(multi_name)
single_script = find_script(single_name)

if multi_script:
    st.write(f"Multihand file Found: `{multi_script}`")
else:
    st.warning(f"Multihand file `{multi_name}` Not found At {HERE}.")

if single_script:
    st.write(f"Single-hand file Found: `{single_script}`")
else:
    st.warning(f"Single-hand file `{single_name}` Not found At {HERE}.")

# helper: cari project root (ancestor dari skrip yang berisi folder 'outputs')
def find_project_root(script_path: Path):
    for anc in script_path.parents:
        if (anc / "outputs").exists():
            return anc
    # fallback: gunakan HERE if outputs exists there
    if (HERE / "outputs").exists():
        return HERE
    # terakhir fallback: use script parent two levels up (usual layout)
    return script_path.parents[1] if len(script_path.parents) > 1 else script_path.parent

mode = st.radio("Choose mode", ("Multihand (Right=alphabet & Left=arrow)", "Single hand (alphabet only)"))

start_btn = st.button("▶️ Start")
stop_btn  = st.button("⏹ Stop")

if "proc" not in st.session_state: st.session_state.proc = None
if "thread" not in st.session_state: st.session_state.thread = None
if "logfile" not in st.session_state: st.session_state.logfile = None

def run_script(script_path: Path, project_root: Path):
    log_path = project_root / f"launcher_{script_path.stem}.log"
    st.session_state.logfile = log_path
    try:
        with open(log_path, "ab") as logf:  # append binary to avoid encoding problems
            proc = subprocess.Popen(
                [sys.executable, str(script_path)],
                cwd=str(project_root),
                stdout=logf,
                stderr=subprocess.STDOUT,
            )
            st.session_state.proc = proc
            proc.wait()
    except Exception as e:
        with open(log_path, "a", encoding="utf-8") as f:
            f.write(f"\n[{time.asctime()}] Launcher internal error: {e}\n")
    finally:
        st.session_state.proc = None

def start_selected():
    target = multi_script if mode.startswith("Multihand") else single_script
    if target is None:
        st.error("Skrip target tidak ditemukan.")
        return

    project_root = find_project_root(target)
    if not (project_root / "outputs").exists():
        st.warning(f"Tidak menemukan folder `outputs` di ancestor {target}. Akan memakai `{project_root}` sebagai working dir, tetapi pastikan `outputs` ada di sana.")
    if st.session_state.proc is not None:
        st.warning("Proses sudah berjalan. Tekan Stop dulu jika ingin restart.")
        return

    thread = threading.Thread(target=run_script, args=(target, project_root), daemon=True)
    st.session_state.thread = thread
    thread.start()
    time.sleep(0.2)
    st.success(f"Running `{target.name}` with cwd=`{project_root}`. Log: `{project_root / f'launcher_{target.stem}.log'}`")

def stop_process():
    proc = st.session_state.proc
    if proc is None:
        st.info("No running process.")
        return
    try:
        proc.terminate()
        time.sleep(1.0)
        if proc.poll() is None:
            proc.kill()
        st.session_state.proc = None
        st.success("Process stopped.")
    except Exception as e:
        st.error(f"Failed to stop process: {e}")

if start_btn:
    start_selected()
if stop_btn:
    stop_process()

st.markdown("## Status")
proc = st.session_state.proc
if proc is None:
    st.info("No running process.")
else:
    st.write(f"PID={proc.pid} running={proc.poll() is None}")

if st.session_state.logfile and st.session_state.logfile.exists():
    st.markdown("### Log snapshot (tail 2000 chars)")
    try:
        with open(st.session_state.logfile, "r", encoding="utf-8", errors="ignore") as f:
            data = f.read()[-2000:]
            st.code(data)
    except Exception:
        st.write("Gagal baca log (cek file log langsung).")
