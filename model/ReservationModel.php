<?php
class ReservationModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //  Function to create a new reservation
    public function createReservation($user_id, $vehicle_type, $vehicle_number, $slot_id, $entry_time, $exit_time)
    {
        $status = 'active'; // Default reservation status

        $entry_time = date('Y-m-d H:i:s', strtotime($entry_time));
        $exit_time = date('Y-m-d H:i:s', strtotime($exit_time));

        // Check if slot exists and is available
        $checkSlotQuery = "SELECT * FROM parking_slots WHERE slot_id = :slot_id AND status = 'available'";
        $stmt = $this->pdo->prepare($checkSlotQuery);
        $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return "Error: Slot ID does not exist or is not available.";
        }

        // Start transaction
        $this->pdo->beginTransaction();

        try {
            // Insert reservation
            $query = "INSERT INTO reservations (user_id, vehicle_type, vehicle_number, slot_id, entry_time, exit_time, status) 
                      VALUES (:user_id, :vehicle_type, :vehicle_number, :slot_id, :entry_time, :exit_time, :status)";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':vehicle_type', $vehicle_type);
            $stmt->bindParam(':vehicle_number', $vehicle_number);
            $stmt->bindParam(':slot_id', $slot_id);
            $stmt->bindParam(':entry_time', $entry_time);
            $stmt->bindParam(':exit_time', $exit_time);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            // Update slot status
            $updateSlotQuery = "UPDATE parking_slots SET status = 'reserved' WHERE slot_id = :slot_id";
            $stmt = $this->pdo->prepare($updateSlotQuery);
            $stmt->bindParam(':slot_id', $slot_id);
            $stmt->execute();

            // Commit the transaction if everything is successful
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction in case of any error to execute both queries
            $this->pdo->rollBack();

            // Log or return the error message for debugging purposes
            return "Database Error: " . $e->getMessage();
        }
    }

    //  Function to fetch all reservations (Fix for your issue)
    public function getAllReservations()
    {
        $query = "SELECT r.reservation_id, u.name AS user_name, r.vehicle_type, r.vehicle_number, 
                         r.slot_id, r.entry_time, r.exit_time, r.status
                  FROM reservations r
                  JOIN users u ON r.user_id = u.id"; // Adjust table and column names if needed

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Function to update reservation status
    public function updateReservationStatus($reservation_id, $status)
    {
        $query = "UPDATE reservations SET status = :status WHERE reservation_id = :reservation_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':reservation_id', $reservation_id);

        return $stmt->execute();
    }
}
