import tkinter as tk
from tkinter import messagebox
import serial
import time
import mysql.connector
from datetime import datetime, timedelta, date
import threading
import winsound


# Connect to Arduino
arduino = serial.Serial('COM5', 9600, timeout=1)
time.sleep(2)

# Connect to MySQL
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="cwts"
)
cursor = db.cursor()

# Store recent attendance timestamps to avoid duplicates
last_attendance = {}

# GUI setup
root = tk.Tk()
root.title("Fingerprint Attendance")

# tk.Label(root, text="ID").grid(row=0)
# tk.Label(root, text="Name").grid(row=1)

# entry_id = tk.Entry(root)
# entry_name = tk.Entry(root)
# entry_id.grid(row=0, column=1)
# entry_name.grid(row=1, column=1)

log_display = tk.Text(root, height=10, width=40, state=tk.DISABLED)
log_display.grid(row=4, column=0, columnspan=2)

def update_log(message):
    log_display.config(state=tk.NORMAL)
    log_display.insert(tk.END, message + "\n")
    log_display.config(state=tk.DISABLED)
    log_display.yview(tk.END)

def play_ok_sound():
    winsound.Beep(1000, 200)   # frequency, duration(ms)

def play_error_sound():
    winsound.Beep(400, 400)

def play_duplicate_sound():
    winsound.Beep(700, 300)
    winsound.Beep(700, 300)

def handle_attendance(finger_id):
    now = datetime.now()
    today = date.today()

    if finger_id not in last_attendance or now - last_attendance[finger_id] > timedelta(seconds=15):
        last_attendance[finger_id] = now

        # Get member's name
        cursor.execute("SELECT fname, lname FROM members_tbl WHERE member_id = %s", (finger_id,))
        result = cursor.fetchone()

        if not result:
            update_log(f"ID {finger_id} not found in members_tbl.")
            play_error_sound()   # ❌ Error sound
            return

        full_name = f"{result[0]} {result[1]}"
        update_log(f"{full_name} scanned at {now.strftime('%Y-%m-%d %I:%M:%S %p')}")

        # Check today's attendance record
        cursor.execute("SELECT id, am_in, am_out, pm_in, pm_out FROM attendance WHERE user_id = %s AND DATE(timestamp) = %s", (finger_id, today))
        record = cursor.fetchone()

        current_time = now.time()
        update_field = None

        if record:
            attendance_id, am_in, am_out, pm_in, pm_out = record

            if pm_in and not pm_out:
                update_field = "pm_out"
            elif not am_in:
                update_field = "am_in"
            elif not am_out and current_time < datetime.strptime("12:00", "%H:%M").time():
                update_field = "am_out"
            elif not pm_in:
                update_field = "pm_in"
            elif not pm_out:
                update_field = "pm_out"

            if update_field:
                cursor.execute(f"UPDATE attendance SET {update_field} = %s WHERE id = %s", (now, attendance_id))
                db.commit()
                update_log(f"{update_field.replace('_', ' ').title()} recorded.")
                play_ok_sound()   # ✅ OK sound
            else:
                update_log("All attendance slots already filled for today.")
                play_error_sound()   # ❌ Error sound (no more slots)
        else:
            if current_time >= datetime.strptime("12:00", "%H:%M").time():
                cursor.execute("INSERT INTO attendance (user_id, timestamp, pm_in) VALUES (%s, %s, %s)", (finger_id, now, now))
                db.commit()
                update_log("PM In recorded (new record).")
            else:
                cursor.execute("INSERT INTO attendance (user_id, timestamp, am_in) VALUES (%s, %s, %s)", (finger_id, now, now))
                db.commit()
                update_log("AM In recorded (new record).")
            play_ok_sound()   # ✅ OK sound
    else:
        update_log(f"Duplicate scan ignored for ID {finger_id}.")
        play_duplicate_sound()   # ⚠️ Duplicate sound


# Listen for fingerprint scans
def listen_for_fingerprints():
    while True:
        if arduino.in_waiting:
            line = arduino.readline().decode().strip()
            if line.startswith("ID:"):
                try:
                    fid = int(line.split(":")[1])
                    update_log(f"Detected ID: {fid}")
                    handle_attendance(fid)
                except ValueError:
                    update_log("Invalid fingerprint ID received.")

# Fingerprint control
def enroll_fingerprint():
    user_id = entry_id.get()
    fname_lname = entry_name.get()

    if not user_id.isdigit() or not fname_lname:
        messagebox.showerror("Input Error", "Enter valid ID and Name.")
        return

    try:
        fname, lname = fname_lname.split()
        arduino.write(b'e')
        time.sleep(8)
        messagebox.showinfo("Enroll", "Fingerprint enrolled!")

        sql = "INSERT INTO members_tbl (member_id, fname, lname) VALUES (%s, %s, %s)"
        cursor.execute(sql, (user_id, fname, lname))
        db.commit()

        update_log(f"Fingerprint for {fname} {lname} (ID: {user_id}) enrolled.")
    except Exception as e:
        messagebox.showerror("Error", str(e))

def delete_fingerprint():
    user_id = entry_id.get()

    if not user_id.isdigit():
        messagebox.showerror("Input Error", "Enter a valid ID.")
        return

    try:
        arduino.write(b'd')
        time.sleep(3)
        messagebox.showinfo("Delete", "Fingerprint deleted!")

        sql = "DELETE FROM members_tbl WHERE member_id = %s"
        cursor.execute(sql, (user_id,))
        db.commit()

        update_log(f"Fingerprint with ID {user_id} deleted.")
    except Exception as e:
        messagebox.showerror("Error", str(e))

def start_scanning():
    arduino.write(b's')
    update_log("Started scanning...")

def stop_scanning():
    arduino.write(b'x')
    update_log("Stopped scanning.")

# Background fingerprint listener
threading.Thread(target=listen_for_fingerprints, daemon=True).start()

# GUI Buttons
# tk.Button(root, text='Enroll Fingerprint', command=enroll_fingerprint).grid(row=2, column=0, pady=4)
# tk.Button(root, text='Delete Fingerprint', command=delete_fingerprint).grid(row=2, column=1, pady=4)
tk.Button(root, text='Start Scanning', command=start_scanning).grid(row=3, column=0, pady=4)
tk.Button(root, text='Stop Scanning', command=stop_scanning).grid(row=3, column=1, pady=4)

root.mainloop()
