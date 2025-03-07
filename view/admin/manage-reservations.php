<?php
// Include necessary files
include('../../components/admin-header.php');
include('../../config.php');  // Db connection
include('../../model/ReservationModel.php');  // Reservation model file

// Initialize ReservationModel
$reservationModel = new ReservationModel($pdo);

// Fetch all reservations from the database
$reservations = $reservationModel->getAllReservations();
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Reservations</h2>

    <!-- Table to display all reservations -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Vehicle</th>
                <th>Slot</th>
                <th>Entry Time</th>
                <th>Exit Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $res) { ?>
                <tr>
                    <td><?= $res['reservation_id'] ?></td>
                    <td><?= $res['user_name'] ?></td>
                    <td><?= $res['vehicle_type'] ?> (<?= $res['vehicle_number'] ?>)</td>
                    <td>P<?= $res['slot_id'] ?></td>
                    <td><?= $res['entry_time'] ?></td>
                    <td><?= $res['exit_time'] ?></td>
                    <td>
                        <!-- Display status with color coding -->
                        <span class="p-2 badge bg-<?= ($res['status'] == 'active') ? 'success' : (($res['status'] == 'completed') ? 'primary' : 'danger') ?>">
                            <?= ucfirst($res['status']) ?>
                        </span>
                    </td>
                    <td>
                        <!-- Action buttons for updating reservation status -->
                        <a href="../../controller/ReservationStatusUpdate.php?id=<?= $res['reservation_id'] ?>&status=completed" class="btn btn-primary btn-sm">Complete</a>
                        <a href="../../controller/ReservationStatusUpdate.php?id=<?= $res['reservation_id'] ?>&status=cancelled" class="btn btn-danger btn-sm">Cancel</a>
                        <a href="../../controller/ReservationStatusUpdate.php?id=<?= $res['reservation_id'] ?>&status=active" class="btn btn-success btn-sm">Activate</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include('../../components/footer.php'); // Footer file 
?>