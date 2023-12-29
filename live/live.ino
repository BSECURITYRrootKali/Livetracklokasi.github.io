#include <ESP8266WiFi.h>
#include <SoftwareSerial.h>
#include <TinyGPS++.h>
#include <ESP8266HTTPClient.h>

#define GPS_TX D5
#define GPS_RX D6

SoftwareSerial gpsSerial(GPS_TX, GPS_RX);
TinyGPSPlus gps;

const char* ssid = "FIBER A1";
const char* password = "disiplino";
const char* serverUrl = "http://localhost/livetrack/terimaData.php"; // Ganti dengan alamat server Anda

void setup() {
  Serial.begin(115200);
  gpsSerial.begin(9600);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void loop() {
  smartDelay(1000);
  if (gps.location.isValid()) {
    float latitude = gps.location.lat();
    float longitude = gps.location.lng();

    if (sendLocationData(latitude, longitude)) {
      Serial.println("Location sent to server successfully");
    } else {
      Serial.println("Failed to send location data");
    }
  }
}

void smartDelay(unsigned long ms) {
  unsigned long start = millis();
  do {
    while (gpsSerial.available())
      gps.encode(gpsSerial.read());
  } while (millis() - start < ms);
}

bool sendLocationData(float lat, float lng) {
  HTTPClient http;
  String postData = "lat=" + String(lat, 6) + "&lng=" + String(lng, 6);

  http.begin(serverUrl);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpResponseCode = http.POST(postData);

  http.end();
  return httpResponseCode == 200; // Return true if data sent successfully
}
