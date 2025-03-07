<?php
session_start();
include('../../components/admin-header.php'); // Admin header
include('../../config.php'); // Database connection
include('../../model/AdminSlotModel.php'); // Include Slot Model

// Initialize AdminSlotModel
$slotModel = new AdminSlotModel($pdo);

// Fetch all parking slots
$slots = $slotModel->getAllSlots();

// Check if the form is submitted to add a new slot
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['slot_number'])) {
    $slotNumber = $_POST['slot_number'];
    // Add slot using the model function
    if ($slotModel->addSlot($slotNumber)) {
        // If slot is added successfully, reload the page to display new slot
        header('Location: manage-parking-slots.php');
        exit;
    } else {
        $error = "Failed to add the slot!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Slots - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <section id="section">
        <center>
            <br>
            <h2>Manage Parking Slots</h2> <br>
        </center>

        <div class="container">
            <!-- Parking Slots Table -->
            <table class="table table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Slot ID</th>
                        <th>Slot Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($slots as $slot): ?>
                        <tr>
                            <td><?= $slot['slot_id'] ?></td>
                            <td><?= $slot['slot_number'] ?></td>
                            <td>
                                <span class="p-2 badge badge-<?= ($slot['status'] == 'available') ? 'success' : (($slot['status'] == 'reserved') ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($slot['status']) ?>
                                </span>
                            </td>
                            <td>
                                <!-- Delete button -->
                                <a class="btn btn-danger btn-sm" href="../../controller/AdminSlotControl.php?id=<?= $slot['slot_id'] ?>&action=delete" onclick="return confirm('Are you sure you want to delete this slot?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </section>
    <!-- Add Slot Form -->
    <div class="container mb-2">
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="slot_number">Slot Number:</label>
                <input type="text" name="slot_number" class="form-control" required placeholder="Enter slot number">
            </div>
            <button type="submit" class="btn btn-primary">Add Slot</button>
        </form>
        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>
    </div>
    <?php include('../../components/footer.php'); ?> <!-- Include the admin footer -->

</body>

</html>