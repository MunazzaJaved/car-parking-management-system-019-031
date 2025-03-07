<?php
session_start();

include('../../model/AdminModel.php');
include('../../config.php');  // Database connection file


// Initialize AdminModel
$adminModel = new AdminModel($pdo);
// Fetch all users
$users = $adminModel->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"><!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="./styles.css"> -->
    <link rel="stylesheet" href="../../assets/manage-users.css">
</head>

<body>
    <?php
    include('../../components/admin-header.php');  // Include the admin header 
    ?>
    <section id="section">
        <div style="margin-top: 20px">
            <center>
                <h2>Manage Users</h2> <!-- Title for the user management section -->
            </center>
        </div>
        <div class="container">
            <table class="table table-bordered"> <!-- Table to display users -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created_At</th>
                        <th>Actions</th> <!-- Column for action buttons -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?> <!-- Loop through each user -->
                        <tr>
                            <td><?php echo $user['id']; ?></td> <!-- Display user ID -->
                            <td><?php echo $user['name']; ?></td> <!-- Display username -->
                            <td><?php echo $user['email']; ?></td> <!-- Display email -->
                            <td><?php echo $user['contact']; ?></td> <!-- Display contact -->
                            <td><?php echo $user['role'] == 'admin' ? 'Admin👑' : 'User'; ?></td> <!-- Display role (Admin or User) -->
                            <td><?php echo $user['status'] == 'enabled' ? 'Enabled' : 'Disabled'; ?></td> <!-- Display status (Enabled or Disabled) -->
                            <td><?php echo $user['created_at']; ?></td>
                            <td>
                                <?php if ($user['status'] == 'enabled'): ?>
                                    <!-- Link to disable the user -->
                                    <a class="btn btn-info btn-sm" href="../../controller/statusUpdate.php?id=<?php echo $user['id']; ?>&status=disabled">Disable</a>
                                <?php else: ?>
                                    <!-- Link to enable the user -->
                                    <a class="btn btn-success btn-sm" href="../../controller/statusUpdate.php?id=<?php echo $user['id']; ?>&status=enabled">Enable</a>
                                <?php endif; ?>
                                <!-- delete link -->
                                <a class="btn btn-danger btn-sm" href="../../controller/delete-user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include('../../components/footer.php'); ?> <!-- Include the admin footer -->
</body>

</html>