<?php
class AdminModel
{
    private $pdo;

    // Constructor to initialize the PDO instance
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all users
    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update user status (Enable/Disable)
    public function updateUserStatus($userId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    // Fetch a specific user by ID (for editing)
    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user data (for editing)
    public function updateUser($userId, $name, $email, $contact)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email, contact = :contact WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    // Delete a user
    public function deleteSlot($slot_id)
    {
        if (!is_numeric($slot_id)) {
            echo "Invalid slot ID!"; // Debugging
            return false;
        }

        $query = "DELETE FROM parking_slots WHERE slot_id = :slot_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Slot deleted in database!"; // Debugging
            return true;
        } else {
            echo "SQL error: Could not delete."; // Debugging
            return false;
        }
    }
}
