<?php 
// Include the guest header file for UI consistency
include('../../components/guest-header.php'); 

// Start session to handle error messages
session_start();
?>

<!-- Link external CSS file -->
<link rel="stylesheet" href="../../assets/style.css">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-10 col-md-8 col-lg-6" style="margin-top: -40px;">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center">Login</h2>

            <?php 
            // Check if an error message exists in session
            if (isset($_SESSION['error_message'])): ?>
                <script>
                    // Show alert message when the page loads
                    document.addEventListener("DOMContentLoaded", function() {
                        alert("<?php echo $_SESSION['error_message']; ?>");
                    });
                </script>
                <?php 
                // Remove the error message after displaying it
                unset($_SESSION['error_message']); 
                ?>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="../../controller/UserController.php?action=login" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                </div>
                <div class="d-flex justify-content-center">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Force clear input fields on page load to prevent autofill
    window.onload = function() {
        setTimeout(function() {
            document.getElementById('email').value = ""; // Clear email field
            document.getElementById('password').value = ""; // Clear password field
        }, 100); // Short delay to override autofill
    };
</script>

<!-- Include footer file -->
<?php include('../../components/footer.php'); ?>
