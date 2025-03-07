<?php
class ParkingModel
{
    // Database connection variable (assuming you already have this)
    private $pdo;

    public function __construct()
    {
        // Database connection setup (adjust this to your database config)
        $this->pdo = new PDO('mysql:host=localhost;dbname=car_parking', 'root', ''); // Replace with your credentials
    }

    // Get the details of a parking slot
    public function getSlotDetails($slotId)
    {
        $query = "SELECT * FROM parking_slots WHERE slot_id = :slot_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':slot_id', $slotId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns details of the slot
    }
}
