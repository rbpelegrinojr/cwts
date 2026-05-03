#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>

// Pins for the fingerprint sensor
SoftwareSerial mySerial(2, 3); // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

String inputString = "";  
bool stringComplete = false;
bool scanning = false;

void setup() {
  Serial.begin(9600);
  finger.begin(57600);

  if (finger.verifyPassword()) {
    Serial.println("✅ Fingerprint sensor detected.");
  } else {
    Serial.println("❌ Fingerprint sensor not found.");
    while (1);
  }

  inputString.reserve(50);
  Serial.println("Ready for commands.");
  Serial.println("Commands: s=start scan, x=stop scan, E,<id>=enroll, D,<id>=delete");
}

void loop() {
  // Check if we have a complete command
  if (stringComplete) {
    processCommand(inputString);
    inputString = "";
    stringComplete = false;
  }

  // Continuous scanning mode
  if (scanning) {
    getFingerprintID();
    delay(500); // reasonable delay to avoid spamming
  }
}

void serialEvent() {
  while (Serial.available()) {
    char inChar = (char)Serial.read();

    // End of command
    if (inChar == '\n' || inChar == '\r') {
      if (inputString.length() > 0) {
        stringComplete = true;
      }
    } else {
      inputString += inChar;

      // Single-character commands should execute immediately
      if (inChar == 's' || inChar == 'x') {
        stringComplete = true;
      }
    }
  }
}

void processCommand(String command) {
  command.trim();
  if (command.length() == 0) return;

  // ---- Scan control ----
  if (command.equalsIgnoreCase("s")) {
    scanning = true;
    Serial.println("🔍 Started scanning...");
    return;
  }
  if (command.equalsIgnoreCase("x")) {
    scanning = false;
    Serial.println("⏹ Stopped scanning.");
    return;
  }

  // ---- Enroll/Delete ----
  char cmd = command.charAt(0);
  int commaIndex = command.indexOf(',');
  int id = -1;
  if (commaIndex > 0) {
    id = command.substring(commaIndex + 1).toInt();
  }

  if (cmd == 'E') {
    if (id > 0) enrollFingerprint(id);
    else Serial.println("⚠️ Invalid enroll ID.");
  } else if (cmd == 'D') {
    if (id > 0) deleteFingerprint(id);
    else Serial.println("⚠️ Invalid delete ID.");
  } else {
    Serial.println("⚠️ Unknown command.");
  }
}

void getFingerprintID() {
  uint8_t p = finger.getImage();
  if (p == FINGERPRINT_NOFINGER) return;   // no finger
  if (p != FINGERPRINT_OK) return;         // try again

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) {
    Serial.println("⚠️ Could not convert image.");
    return;
  }

  p = finger.fingerSearch();
  if (p == FINGERPRINT_OK) {
    // ✅ Always output clean ID format for Python
    Serial.print("ID:");
    Serial.println(finger.fingerID);
  } else {
    // No match → Python treats as error
    Serial.println("ID:0");
  }
}

void enrollFingerprint(int id) {
  Serial.print("📝 Enrolling ID #"); Serial.println(id);

  int p = -1;
  Serial.println("👉 Place finger...");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
  }
  p = finger.image2Tz(1);
  if (p != FINGERPRINT_OK) {
    Serial.println("⚠️ Failed to convert image (step 1).");
    return;
  }

  Serial.println("✋ Remove finger.");
  delay(2000);

  p = -1;
  Serial.println("👉 Place same finger again...");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
  }
  p = finger.image2Tz(2);
  if (p != FINGERPRINT_OK) {
    Serial.println("⚠️ Failed to convert image (step 2).");
    return;
  }

  p = finger.createModel();
  if (p != FINGERPRINT_OK) {
    Serial.println("⚠️ Failed to create model.");
    return;
  }

  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("✅ Fingerprint stored successfully!");
  } else {
    Serial.println("❌ Failed to store fingerprint.");
  }
}

void deleteFingerprint(int id) {
  Serial.print("🗑 Deleting ID #"); Serial.println(id);

  int p = finger.deleteModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("✅ Deleted successfully!");
  } else {
    Serial.println("❌ Failed to delete fingerprint.");
  }
}
