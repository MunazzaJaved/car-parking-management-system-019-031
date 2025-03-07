<?php
class SlotStatusModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Function to get the status of all parking slots
    public function getSlotStatus()
    {
        $query = "SELECT slot_id, status FROM parking_slots";  // Get all slot statuses
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Returns all slots with their status
    }

    // Function to update the status of a slot (e.g., when it's reserved)
    public function updateSlotStatus($slot_id, $status)
    {
        $query = "UPDATE parking_slots SET status = :status WHERE slot_id = :slot_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':slot_id', $slot_id);
        return $stmt->execute();
    }
}
