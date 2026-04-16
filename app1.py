import serial
import sys
import time

if len(sys.argv) < 2:
    print("ERROR: No command provided")
    sys.exit(1)

command = sys.argv[1]
finger_id = None

if len(sys.argv) > 2:
    finger_id = sys.argv[2]

SERIAL_PORT = 'COM16'  # Change if needed
BAUD_RATE = 9600

try:
    ser = serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=10)
    time.sleep(2)

    if command == "ENROLL" and finger_id:
        ser.write(f"ENROLL {finger_id}\n".encode())
    elif command == "DELETE" and finger_id:
        ser.write(f"DELETE {finger_id}\n".encode())
    elif command == "SCAN":
        ser.write(b"SCAN\n")
    else:
        print("Invalid command or missing ID.")
        ser.close()
        sys.exit(1)

    response = ""
    while True:
        line = ser.readline().decode().strip()
        if line:
            print(line)
            response += line + "\n"
            if "SUCCESS" in line and command == "ENROLL":
                print("Enrollment successful")
            if any(word in line for word in ["SUCCESS", "FAILED", "Re-enroll", "Found ID", "not found"]):
                break


    ser.close()

except Exception as e:
    print("ERROR:", str(e))
    sys.exit(1)
