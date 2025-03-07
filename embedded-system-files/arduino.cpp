#include <iostream>
#include <fstream>  // For file handling
#include <windows.h>

using namespace std;

int main() {
    // Open COM port
    HANDLE hSerial = CreateFile("COM3", GENERIC_READ | GENERIC_WRITE, 0, NULL, OPEN_EXISTING, 0, NULL);
    if (hSerial == INVALID_HANDLE_VALUE) {
        cerr << "Error: Unable to open COM port!" << endl;
        return 1;
    }
    cout << "COM Port Opened Successfully!" << endl;

    // Configure serial port
    DCB dcbSerialParams = {0};
    dcbSerialParams.DCBlength = sizeof(dcbSerialParams);
    dcbSerialParams.BaudRate = CBR_9600;
    dcbSerialParams.ByteSize = 8;
    dcbSerialParams.StopBits = ONESTOPBIT;
    dcbSerialParams.Parity   = NOPARITY;

    if (!SetCommState(hSerial, &dcbSerialParams)) {
        cerr << "Error: Unable to configure serial port!" << endl;
        return 1;
    }

    // Set timeouts
    COMMTIMEOUTS timeouts = {0};
    timeouts.ReadIntervalTimeout = 50;
    timeouts.ReadTotalTimeoutConstant = 50;
    timeouts.ReadTotalTimeoutMultiplier = 10;
    SetCommTimeouts(hSerial, &timeouts);

    cout << "Listening to Arduino on COM3..." << endl;

    char buffer[128];
    DWORD bytesRead;

    // Open file to write received data
    ofstream file("D:/xampp/htdocs/car-parking-management/slots.txt", ios::out | ios::trunc); // Overwrite previous data
    if (!file) {
        cerr << "Error: Unable to open slots.txt for writing!" << endl;
        return 1;
    }

    while (true) {
        bool result = ReadFile(hSerial, buffer, sizeof(buffer) - 1, &bytesRead, NULL);
        
        if (result && bytesRead > 0) {
            buffer[bytesRead] = '\0';  // Null-terminate the string
            cout << "Received: " << buffer << endl;

            // Write received data to file
            file.seekp(0);   // Move to the beginning (overwrite existing content)
            file << buffer;  // Write received data
            file.flush();    // Ensure immediate write to file
        } else {
            cout << "No data received..." << endl;
        }

        Sleep(1000);
    }

    // Close file and COM port
    file.close();
    CloseHandle(hSerial);

    return 0;
}

