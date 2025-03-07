<?php
include('../../components/customer-header.php');
include('../../config.php');
include('../../model/SlotStatusModel.php');  // Include the SlotStatusModel to fetch parking slot status

// Create an instance of SlotStatusModel
$slotStatusModel = new SlotStatusModel($pdo);

// Fetch all the slot statuses
$slots = $slotStatusModel->getSlotStatus();  // Fetch the status of all parking slots
?>

<div class="container mt-5 mb-5">
    <center>
        <h2>Current Parking Status</h2>
    </center><br>
    <div class="row">
        <?php
        // Loop through each slot based on the data fetched from the database
        foreach ($slots as $slot) {
            $slot_id = $slot['slot_id'];
            $slot_status = $slot['status'];
            $available = false;
            $status_class = 'bg-danger';  // Default to red (reserved)

            // Check if the slot is available or not
            if ($slot_status == 'available') {
                $available = true;
                $status_class = 'bg-success';  // Set to green (available)
            }

            // Set the status text and cursor style based on availability
            $status_text = $available ? 'Available' : 'Not Available';
            $cursor_style = $available ? 'pointer' : 'not-allowed';
        ?>
            <div class="col-md-2 mb-4">
                <div class="card <?= $status_class; ?>" style="cursor: <?= $cursor_style; ?>;">
                    <div class="card-body">
                        <div style="text-align:center;">
                            <a href="book.php?slot_id=<?= $slot_id; ?>" style="text-decoration: none; color:black;">
                                Book Now <br> Parking lot P<?= $slot_id; ?>
                            </a>
                        </div>
                        <p class="card-text"><?= $status_text; ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php include('../../components/footer.php'); ?>