<?php
session_start();
include('../config.php');  // Include the PDO connection
include('../model/StatusModel.php'); // Include the StatusModel

// Initialize StatusModel
$statusModel = new StatusModel($pdo);

// Check if parameters are passed in the URL
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    echo "Error: Missing parameters!";
    exit;
}

$id = $_GET['id'];  // User ID
$status = $_GET['status'];  // Status ('enabled' or 'disabled')

// Validate status
if ($status != 'enabled' && $status != 'disabled') {
    echo "Error: Invalid status value.";
    exit;
}

// Check if the user is an admin
if ($statusModel->isAdmin($id)) {
    echo "<script>alert('Error! Admin cannot disable themselves.');</script>";
    echo "<script>location.replace('../view/admin/manage-users.php');</script>";
    exit;
}

// Update user status
if ($statusModel->updateUserStatus($id, $status)) {
    // Redirect to manage users page after status update
    header("Location: ../view/admin/manage-users.php");
    exit;
} else {
    echo "Error updating status.";
}
