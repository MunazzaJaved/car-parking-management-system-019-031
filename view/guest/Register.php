<?php
// Include guest header for UI consistency
include('../../components/guest-header.php');

// Start session to handle error messages
session_start();
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-10 col-md-8 col-lg-6">
        <div class="card p-4 shadow-sm">
            <h2 class="text-center">Sign Up</h2>

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

            <!-- Registration Form -->
            <form action="../../controller/UserController.php?action=register" method="POST" autocomplete="off" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                    <small class="text-muted">Password must be 8+ chars, include uppercase, lowercase, number & special char.</small>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" name="contact" id="contact" class="form-control" required autocomplete="off">
                    <small class="text-muted">Pakistani format: 03XXXXXXXXX (11 digits)</small>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="submit" value="Sign Up" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to validate contact number and password
    function validateForm() {
        var contact = document.getElementById("contact").value;
        var password = document.getElementById("password").value;

        // Contact number validation (Pakistani format: 11 digits, starts with '03')
        var contactPattern = /^03\d{9}$/;
        if (!contactPattern.test(contact)) {
            alert("Invalid contact number! It must be in Pakistani format: 03XXXXXXXXX (11 digits).");
            return false;
        }

        // Password validation (min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special char)
        var passwordPattern = /^(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;
        if (!passwordPattern.test(password)) {
            alert("Invalid password! It must be at least 8 characters long and include letters, sa number, and a special character.");
            return false;
        }

        return true; // If all checks pass, form submits
    }

    // Force clear input fields on page load to remove any stored values
    window.onload = function() {
        setTimeout(function() {
            document.getElementById('name').value = ""; // Clear Name field
            document.getElementById('email').value = ""; // Clear Email field
            document.getElementById('password').value = ""; // Clear Password field
            document.getElementById('contact').value = ""; // Clear Contact field
        }, 100); // Short delay to override autofill
    };
</script>

<!-- Include footer -->
<?php include('../../components/footer.php'); ?>