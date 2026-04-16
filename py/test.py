import tkinter as tk
from tkinter import ttk, messagebox
import serial
import serial.tools.list_ports
import time
import pymysql   # 🔹 use pymysql instead of mysql.connector
from datetime import datetime, timedelta, date
import threading
import winsound


# ---------- Detect Available COM Ports ----------
def get_com_ports():
    ports = serial.tools.list_ports.comports()
    return [port.device for port in ports]

# ---------- Connect to Arduino ----------
arduino = None
def connect_arduino(port):
    global arduino
    try:
        arduino = serial.Serial(port, 9600, timeout=1)
        time.sleep(2)
        arduino.reset_input_buffer()
        update_log(f"✅ Connected to {port}")
    except Exception as e:
        messagebox.showerror("Connection Error", f"Could not open {port}\n{e}")


# ---------- Connect to MySQL ----------
db = pymysql.connect(      # 🔹 changed
    host="localhost",
    user="root",
    password="",
    database="cwts"
)
cursor = db.cursor()

# ---------- Store recent attendance timestamps ----------
last_attendance = {}

# ---------- GUI Setup ----------
root = tk.Tk()
root.title("Fingerprint Attendance")

log_display = tk.Text(root, height=10, width=50, state=tk.DISABLED)
log_display.grid(row=5, column=0, columnspan=3, pady=10)

def update_log(message):
    log_display.config(state=tk.NORMAL)
    log_display.insert(tk.END, message + "\n")
    log_display.config(state=tk.DISABLED)
    log_display.yview(tk.END)

# ---------- Sounds ----------
def play_ok_sound():
    winsound.PlaySound("ok.wav", winsound.SND_FILENAME | winsound.SND_ASYNC)

def play_error_sound():
    winsound.PlaySound("error.wav", winsound.SND_FILENAME | winsound.SND_ASYNC)

def play_duplicate_sound():
    winsound.Beep(800, 200)
    winsound.Beep(600, 200)


def handle_attendance(finger_id):
    global cursor, db, port_var
    now = datetime.now()
    today = date.today()
    current_time = now.time()

    # 🔹 Get connected device ID (based on selected COM port)
    device_id = port_var.get()

    # 🔹 Find active schedule for today, this device
    cursor.execute("""
        SELECT schedule_id, start_time, end_time, status, schedule_type 
        FROM schedules_tbl 
        WHERE schedule_date=%s AND device_id=%s AND status='active'
        """, (today, device_id))
    sched = cursor.fetchone()

    if not sched:
        update_log("⚠️ No active schedule for this device today.")
        play_error_sound()
        return

    schedule_id, start_time, end_time, status, schedule_type = sched

    # 🔹 Convert schedule times to datetime.time
    start_time = datetime.strptime(str(start_time), "%H:%M:%S").time()
    end_time = datetime.strptime(str(end_time), "%H:%M:%S").time()

    # 🔹 If current time is outside schedule → ignore
    if not (start_time <= current_time <= end_time):
        update_log("⏰ Outside allowed schedule time.")
        play_error_sound()
        return

    # 🔹 Auto-mark schedule inactive if past end_time
    if current_time > end_time:
        cursor.execute("UPDATE schedules_tbl SET status='inactive' WHERE schedule_id=%s", (schedule_id,))
        db.commit()
        update_log("📅 Schedule ended, marked inactive.")
        return

    # Prevent duplicate scans
    if finger_id in last_attendance and now - last_attendance[finger_id] < timedelta(seconds=15):
        update_log(f"Duplicate scan ignored for ID {finger_id}.")
        play_duplicate_sound()
        return
    last_attendance[finger_id] = now

    # 🔹 Verify member exists
    cursor.execute("SELECT fname, lname FROM members_tbl WHERE member_id=%s", (finger_id,))
    result = cursor.fetchone()
    if not result:
        update_log(f"ID {finger_id} not found in members_tbl.")
        play_error_sound()
        return

    full_name = f"{result[0]} {result[1]}"
    update_log(f"{full_name} scanned at {now.strftime('%Y-%m-%d %I:%M:%S %p')}")

    # 🔹 Get today’s attendance record
    # cursor.execute("SELECT id, am_in, am_out, pm_in, pm_out FROM attendance WHERE user_id=%s AND DATE(timestamp)=%s", (finger_id, today))
    # record = cursor.fetchone()
    # 🔹 Get today’s attendance record
    cursor.execute("SELECT id, am_in, am_out, pm_in, pm_out FROM attendance WHERE user_id=%s AND DATE(timestamp)=%s", (finger_id, today))
    record = cursor.fetchone()


    update_field = None
    if record:
        attendance_id, am_in, am_out, pm_in, pm_out = record

        if schedule_type == "morning":
            if not am_in:
                update_field = "am_in"
            elif not am_out:
                update_field = "am_out"
        elif schedule_type == "afternoon":
            if not pm_in:
                update_field = "pm_in"
            elif not pm_out:
                update_field = "pm_out"
        elif schedule_type == "both":
            if not am_in and current_time < datetime.strptime("12:00", "%H:%M").time():
                update_field = "am_in"
            elif not am_out and current_time < datetime.strptime("12:00", "%H:%M").time():
                update_field = "am_out"
            elif not pm_in and current_time >= datetime.strptime("12:00", "%H:%M").time():
                update_field = "pm_in"
            elif not pm_out and current_time >= datetime.strptime("12:00", "%H:%M").time():
                update_field = "pm_out"

        if update_field:
            cursor.execute(f"UPDATE attendance SET {update_field}=%s WHERE id=%s", (now, attendance_id))
            db.commit()
            update_log(f"{update_field.replace('_', ' ').title()} recorded.")
            play_ok_sound()
        else:
            update_log("All attendance slots already filled.")
            play_error_sound()
    else:
        # First entry
        if schedule_type == "morning":
            cursor.execute("""
                INSERT INTO attendance (user_id, schedule_id, timestamp, am_in)
                VALUES (%s,%s,%s,%s)
            """, (finger_id, schedule_id, now, now))
            db.commit()
            update_log("✅ AM In recorded.")
        elif schedule_type == "afternoon":
            cursor.execute("""
                INSERT INTO attendance (user_id, schedule_id, timestamp, pm_in)
                VALUES (%s,%s,%s,%s)
            """, (finger_id, schedule_id, now, now))
            db.commit()
            update_log("✅ PM In recorded.")
        elif schedule_type == "both":
            if current_time < datetime.strptime("12:00", "%H:%M").time():
                cursor.execute("""
                    INSERT INTO attendance (user_id, schedule_id, timestamp, am_in)
                    VALUES (%s,%s,%s,%s)
                """, (finger_id, schedule_id, now, now))
                db.commit()
                update_log("✅ AM In recorded.")
            else:
                cursor.execute("""
                    INSERT INTO attendance (user_id, schedule_id, timestamp, pm_in)
                    VALUES (%s,%s,%s,%s)
                """, (finger_id, schedule_id, now, now))
                db.commit()
                update_log("✅ PM In recorded.")
        play_ok_sound()



# ---------- Fingerprint Listener ----------
def listen_for_fingerprints():
    global arduino
    while True:
        if arduino and arduino.in_waiting:
            line = arduino.readline().decode().strip()
            if line.startswith("ID:"):
                try:
                    fid = int(line.split(":")[1])
                    if fid == 0:
                        update_log("Scan ERROR.")
                        play_error_sound()
                    else:
                        update_log(f"Detected ID: {fid}")
                        handle_attendance(fid)
                except ValueError:
                    update_log("Invalid fingerprint ID received.")


# ---------- Start/Stop Scan ----------
def start_scanning():
    if arduino:
        arduino.write(b's')
        update_log("Started scanning...")
    else:
        messagebox.showerror("Error", "No Arduino connected.")

def stop_scanning():
    if arduino:
        arduino.write(b'x')
        update_log("Stopped scanning.")


# ---------- COM Port Selector ----------
tk.Label(root, text="Select COM Port:").grid(row=0, column=0, padx=5, pady=5, sticky="w")

port_var = tk.StringVar()
ports_combo = ttk.Combobox(root, textvariable=port_var, values=get_com_ports(), state="readonly")
ports_combo.grid(row=0, column=1, padx=5, pady=5)

def connect_selected_port():
    port = port_var.get()
    if port:
        connect_arduino(port)
    else:
        messagebox.showwarning("Warning", "Please select a COM port.")

tk.Button(root, text="Connect", command=connect_selected_port).grid(row=0, column=2, padx=5, pady=5)

# ---------- Buttons ----------
tk.Button(root, text='Start Scanning', command=start_scanning).grid(row=3, column=0, pady=4)
tk.Button(root, text='Stop Scanning', command=stop_scanning).grid(row=3, column=1, pady=4)

# ---------- Background Listener ----------
threading.Thread(target=listen_for_fingerprints, daemon=True).start()

root.mainloop()
