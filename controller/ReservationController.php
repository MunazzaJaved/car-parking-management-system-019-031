<?php
include('../config.php'); // Ensure DB connection
include('../model/ReservationModel.php');

session_start();
$user_id = $_SESSION['user_id'] ?? null; // Ensure user is logged in

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_number = $_POST['vehicle_number'];
    $slot_id = $_POST['slot_id'];
    $entry_time = $_POST['entry_time'];
    $exit_time = $_POST['exit_time'];

    // Initialize ReservationModel
    $reservationModel = new ReservationModel($pdo);

    // Call function to insert data
    $result = $reservationModel->createReservation($user_id, $vehicle_type, $vehicle_number, $slot_id, $entry_time, $exit_time);

    if ($result === true) {
        echo "Success: Reservation booked!";
        header("Location: ../view/customer/customer-dashboard.php");
        echo '<script>alert("Success: Reservation booked!") </script>';
        exit;
    } else {
        echo "Error: " . $result; // Show detailed error
    }
} else {
    echo "Invalid request or not logged in!";
}
