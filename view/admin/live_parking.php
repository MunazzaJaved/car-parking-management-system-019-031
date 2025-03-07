<?php
session_start();
include('../../components/admin-header.php'); // Admin header
$filename = '../../slots.txt'; // Adjust path as needed

// Check if file exists
if (!file_exists($filename)) {
    die("Error: File not found.");
}

// Read the file content
$slotsData = file_get_contents($filename);
$slotsArray = str_split(trim($slotsData)); // Convert string to array

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slot Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Parking Slot Status</h2><br>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Slot Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slotsArray as $index => $status): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td>
                            <?php if ($status == '1'): ?>
                                <span class="badge bg-success">Empty</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Filled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include('../../components/footer.php'); ?> <!-- Include the admin footer -->
</body>

</html>