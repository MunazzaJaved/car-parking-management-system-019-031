<?php
class AdminSlotModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all parking slots
    public function getAllSlots()
    {
        $stmt = $this->pdo->query("SELECT * FROM parking_slots ORDER BY slot_id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new slot
    public function addSlot($slot_number)
    {
        $stmt = $this->pdo->prepare("INSERT INTO parking_slots (slot_number, status) VALUES (:slot_number, 'available')");
        $stmt->bindParam(':slot_number', $slot_number, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Delete a slot
    public function deleteSlot($slot_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM parking_slots WHERE slot_id = :slot_id");
        $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
