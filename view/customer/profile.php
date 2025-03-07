<?php
include '../../components/customer-header.php';
include_once '../../model/UserModel.php';  // Use UserModel since you are using user-related fields
include('../../config.php');
session_start();

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: ../../index.php');
    exit;
}

// Create instance of UserModel
$userModel = new UserModel($pdo);

// Fetch user data using the userId
$user = $userModel->getUserById($userId);

?>

<div class="container mt-5 mb-5">
    <h1>My Profile</h1>
    <form method="POST" action="">
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <!-- Phone Field -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
        </div>

        <!-- Password Field (Optional, only for updating password) -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <small>Leave blank to keep current password</small>
        </div>

        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
</div>

<?php
// Include footer
include '../../components/footer.php';
?>