<?php
include('../config.php');
include('../model/ReservationModel.php');

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    echo "Error: Missing parameters!";
    exit;
}

$reservation_id = $_GET['id'];
$status = $_GET['status'];

// Validate status
if (!in_array($status, ['active', 'completed', 'cancelled'])) {
    echo "Error: Invalid status!";
    exit;
}

// Initialize model
$reservationModel = new ReservationModel($pdo);

// Update reservation status
if ($reservationModel->updateReservationStatus($reservation_id, $status)) {
    header("Location: ../view/admin/manage-reservations.php"); // Redirect back
    exit;
} else {
    echo "Error updating reservation status.";
}
