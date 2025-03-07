When you click a link or button with a URL like update-slot.php?id=5&status=available, the values are passed in 
the URL as query parameters, which are then accessed via $_GET['id'] and $_GET['status'].

:status and :slot_id:
Named Placeholders: They help prevent SQL injection attacks by automatically escaping the values before inserting
 them into the query. ? (positional placeholders) are both used in prepared statements.


 !!!!Parking Management System with Embedded Integration!!!!

Project Overview
This is a PHP-based Parking Management System integrated with an embedded system. It manages parking reservations and tracks live parking slot data using a microcontroller. The embedded system communicates via COM3, updates a file (slot.txt), and the admin panel displays real-time slot status.

Features
User Roles:

1. Admin
Manage users (Enable, Disable, Delete accounts)
Manage parking slots (Mark as available/unavailable)
View and modify reservations
Monitor real-time parking slot updates

2. Customers
Book, update, and cancel reservations

3. Guests
View parking details but need to register for reservations
Core Functionalities:

Reservation booking with vehicle details and entry/exit time
Live parking slot updates from an embedded system
Admin dashboard to manage users, reservations, and slots
Embedded System Integration

Microcontroller reads slot occupancy and sends data to COM3
A C++ program reads COM3 and updates slot.txt
The web application reads slot.txt to display parking availability
Technology Stack

Frontend: HTML, CSS, Bootstrap
Backend: PHP (No Framework)
Database: MySQL (Tables: users, reservations, slots)
Embedded: Microcontroller (8051), C++ for COM3 communication
Installation & Setup

Database Setup:

Import parking_system.sql into MySQL
Update config.php with database credentials
Web Server Setup:

Place files in htdocs (XAMPP) or web root folder
Start Apache & MySQL
Embedded System:

Microcontroller must send slot data to COM3
Run the C++ program to update slot.txt
How It Works

Customer books a parking slot
Microcontroller updates slot.txt via COM3
Admin panel reads slot.txt and updates parking status
Admin can modify reservations, slots, and user accounts
Developer Notes

Ensure slot.txt has write permissions
The C++ program must keep running for real-time updates
This project provides an efficient IT-based parking management system with embedded integration for real-time tracking and admin-controlled management.

