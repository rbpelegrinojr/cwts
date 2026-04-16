#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>

SoftwareSerial mySerial(2, 3); // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

bool scanning = false;

void setup() {
  Serial.begin(9600);
  finger.begin(57600);

  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1);
  }

  Serial.println("Waiting for scan command...");
}

void loop() {
  if (Serial.available()) {
    char command = Serial.read();
    if (command == 'e') {
      enrollFingerprint(1);
    } else if (command == 'd') {
      deleteFingerprint(1);
    } else if (command == 's') {
      scanning = true;
      Serial.println("Started scanning...");
    } else if (command == 'x') {
      scanning = false;
      Serial.println("Stopped scanning.");
    }
  }

  if (scanning) {
    getFingerprintID();
    delay(1000); // scan delay
  }
}

void getFingerprintID() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) return;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) return;

  p = finger.fingerSearch();
  if (p == FINGERPRINT_OK) {
    Serial.print("ID:");
    Serial.println(finger.fingerID);
  } else {
    Serial.println("ID:0");  // send 0 if not found
  }
}


void enrollFingerprint(uint8_t id) {
  int p = -1;
  Serial.println("Waiting for valid finger to enroll as #" + String(id));
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
  }
  p = finger.image2Tz();
  p = finger.createModel();
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
  } else {
    Serial.println("Failed to store");
  }
}

void deleteFingerprint(uint8_t id) {
  if (finger.deleteModel(id) == FINGERPRINT_OK) {
    Serial.println("Deleted!");
  } else {
    Serial.println("Delete failed");
  }
}
