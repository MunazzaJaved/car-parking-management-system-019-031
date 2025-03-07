<?php

class StatusModel
{
    private $pdo;

    // Constructor to initialize PDO
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Check if the user is an admin
    public function isAdmin($id)
    {
        $query = "SELECT role FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user found and role is admin, return true
        return ($user && $user['role'] === 'admin');
    }

    // Update user status (enabled/disabled)
    public function updateUserStatus($id, $status)
    {
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();  // Executes the query and returns true/false based on success
    }
}
