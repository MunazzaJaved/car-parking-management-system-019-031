<?php
session_start();
include('../config.php');  // Database connection

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Check if the user is an admin before deleting
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user['role'] === 'admin') {
        echo "<script>alert('You cannot delete an Admin!'); window.location.href = '../view/admin/manage-users.php';</script>";
        exit;
    }

    else if ($user && $user['role'] !== 'admin') {
        // Delete the user if they are not an admin
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($deleteStmt->execute([$userId])) {
            $_SESSION['message'] = "User deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete user.";
        }
    } 
}

// Redirect back to manage users page
header("Location: ../view/admin/manage-users.php");
exit();
?>
