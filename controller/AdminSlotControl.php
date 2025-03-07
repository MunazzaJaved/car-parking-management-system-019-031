<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../config.php'); // Database connection
include('../model/AdminSlotModel.php'); // Slot model

// Initialize model
$slotModel = new AdminSlotModel($pdo);

// Handle slot status update
if (isset($_GET['id']) && isset($_GET['status'])) {
    $slot_id = $_GET['id'];
    $status = $_GET['status'];

    // Allowed status values
    $validStatuses = ['available', 'reserved'];

    if (!in_array($status, $validStatuses)) {
        echo "Error: Invalid status!";
        exit;
    }
}

// Handle slot deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $slot_id = intval($_GET['id']); // Ensure it's an integer

    if ($slotModel->deleteSlot($slot_id)) {
        header("Location: ../view/admin/manage-parking-slots.php");
        exit;
    } else {
        die("Error deleting the slot! Check constraints.");
    }
}
