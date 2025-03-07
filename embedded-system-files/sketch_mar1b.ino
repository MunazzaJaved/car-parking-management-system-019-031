#include <SoftwareSerial.h>
#include <Servo.h>
#include <Arduino.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// Set the LCD address to 0x27 for a 16x2 display
LiquidCrystal_I2C lcd(0x27, 16, 2);

// Servo motors for entrance and exit gates
Servo myservo1;  // Entrance gate servo
Servo myservo2;  // Exit gate servo

// SoftwareSerial for NodeMCU communication
SoftwareSerial nodemcu(0, 1);

// Define IR sensor pins for parking slots
#define parking1_slot1_ir_s  5 // IR sensor for Parking Slot 1
#define parking1_slot2_ir_s  6 // IR sensor for Parking Slot 2
#define parking1_slot3_ir_s  7 // IR sensor for Parking Slot 3
#define parking2_slot1_ir_s  8 // IR sensor for Parking Slot 4
#define parking2_slot2_ir_s  9 // IR sensor for Parking Slot 5
#define parking2_slot3_ir_s  10 // IR sensor for Parking Slot 6

// Define entrance and exit gate control pins
#define entrance_gate 2
#define exit_gate 4

// Initial gate positions
int pos1 = 90; // Entrance gate position
int pos2 = 90; // Exit gate position

// Variables to store parking slot statuses
int S1, S2, S3, S4, S5, S6;
int slot = 6; // Total parking slots

void setup() {
    Serial.begin(9600);  // Initialize serial monitor
    nodemcu.begin(9600); // Initialize communication with NodeMCU

    // Set IR sensor pins as input
    pinMode(parking1_slot1_ir_s, INPUT);
    pinMode(parking1_slot2_ir_s, INPUT);
    pinMode(parking1_slot3_ir_s, INPUT);
    pinMode(parking2_slot1_ir_s, INPUT);
    pinMode(parking2_slot2_ir_s, INPUT);
    pinMode(parking2_slot3_ir_s, INPUT);

    // Set entrance and exit gate pins as input
    pinMode(entrance_gate, INPUT);
    pinMode(exit_gate, INPUT);

    // Attach servos to designated pins
    myservo1.attach(3);
    myservo2.attach(11);
    myservo1.write(0); // Initialize entrance gate position

    // Initialize LCD display
    lcd.begin(16, 2);
    lcd.backlight();
}

// Function to read IR sensor values and update slot availability
void Read_Sensor() {
    // Read IR sensors (LOW means slot is occupied)
    S1 = (digitalRead(parking1_slot1_ir_s) == LOW) ? 1 : 0;
    S2 = (digitalRead(parking1_slot2_ir_s) == LOW) ? 1 : 0;
    S3 = (digitalRead(parking1_slot3_ir_s) == LOW) ? 1 : 0;
    S4 = (digitalRead(parking2_slot1_ir_s) == LOW) ? 1 : 0;
    S5 = (digitalRead(parking2_slot2_ir_s) == LOW) ? 1 : 0;
    S6 = (digitalRead(parking2_slot3_ir_s) == LOW) ? 1 : 0;

    // Calculate available parking slots
    slot = 6 - (S1 + S2 + S3 + S4 + S5 + S6);

    // Display available slots on Serial Monitor
    Serial.print("S1: "); Serial.print(S1);
    Serial.print(", S2: "); Serial.print(S2);
    Serial.print(", S3: "); Serial.print(S3);
    Serial.print(", S4: "); Serial.print(S4);
    Serial.print(", S5: "); Serial.print(S5);
    Serial.print(", S6: "); Serial.print(S6);
    Serial.print(" => Available Slots: "); Serial.println(slot);

    // Update LCD display with available parking slots
    lcd.clear();
    lcd.setCursor(0, 0);
    if (slot == 0) {
        lcd.print("No Parking Space");
    } else {
        lcd.print("Slots Available: ");
        lcd.print(slot);
    }
    delay(1000);
}

void loop() {
    // Display system title on LCD
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Car Parking System");
    delay(1000);

    // Read parking slot statuses
    Read_Sensor();

    // Display individual slot statuses on LCD
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("S1:"); lcd.print(S1 ? "Full " : "Empty");
    lcd.setCursor(9, 0);
    lcd.print("S2:"); lcd.print(S2 ? "Full " : "Empty");
    lcd.setCursor(3, 1);
    lcd.print("S3:"); lcd.print(S3 ? "Full " : "Empty");
    delay(1500);

    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("S4:"); lcd.print(S4 ? "Full " : "Empty");
    lcd.setCursor(9, 0);
    lcd.print("S5:"); lcd.print(S5 ? "Full " : "Empty");
    lcd.setCursor(3, 1);
    lcd.print("S6:"); lcd.print(S6 ? "Full " : "Empty");
    delay(1500);

    lcd.clear();
    
    // Send slot statuses to Serial and NodeMCU
    String cdata = String(S1) + "," + String(S2) + "," + String(S3) + "," +
                   String(S4) + "," + String(S5) + "," + String(S6);
    Serial.println(cdata);  
    nodemcu.println(cdata);  // Send to NodeMCU
    delay(1000);
}

// Function to control entrance and exit gates based on parking status
void gates() {
    // Open exit gate if vehicle is detected at exit
    if (digitalRead(exit_gate) == LOW) {
        for (pos2 = 90; pos2 <= 180; pos2++) {
            myservo2.write(pos2);
            delay(15);
        }
        delay(1000);
        for (pos2 = 180; pos2 >= 90; pos2--) {
            myservo2.write(pos2);
            delay(15);
        }
    }

    // Open entrance gate only if slots are available and a vehicle is detected
    if ((S1 + S2 + S3 + S4 + S5 + S6) < 6 && (digitalRead(entrance_gate) == LOW)) {
        for (pos1 = 0; pos1 <= 90; pos1++) {
            myservo1.write(pos1);
            delay(15);
        }
        delay(1000);
        for (pos1 = 90; pos1 >= 0; pos1--) {
            myservo1.write(pos1);
            delay(15);
        }
    }
}
