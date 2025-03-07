<?php
// Include required model and configuration files
include_once '../model/UserModel.php';
include_once '../config.php';

class UserController
{
    private $userModel;

    // Constructor to initialize the UserModel and start the session
    public function __construct($pdo)
    {
        $this->userModel = new UserModel($pdo);
        session_start();  // Start session to manage user authentication and messages
    }

    // User Registration Method
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize user inputs
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $contact = trim($_POST['contact']);

            // Check if any required field is empty
            if (empty($name) || empty($email) || empty($password) || empty($contact)) {
                $_SESSION['error_message'] = "Please fill in all fields";
                header('Location: ../view/guest/register.php');
                exit;
            }

            // Check if the email is already registered
            if ($this->userModel->emailExists($email)) {
                $_SESSION['error_message'] = "This email is already registered";
                header('Location: ../view/guest/register.php');
                exit;
            }

            // Attempt user registration
            if ($this->userModel->register($name, $email, $password, $contact)) {
                $_SESSION['success_message'] = "Registration successful. Please login.";
                header('Location: ../view/guest/login.php');
                exit;
            } else {
                $_SESSION['error_message'] = "Error registering user. Please try again.";
                header('Location: ../view/guest/register.php');
                exit;
            }
        }
    }

    // User Login Method
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize user inputs
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Check if any required field is empty
            if (empty($email) || empty($password)) {
                $_SESSION['error_message'] = "Please fill in all fields";
                header('Location: ../view/guest/login.php');
                exit;
            }

            // Check if the email exists in the database
            if (!$this->userModel->emailExists($email)) {
                $_SESSION['error_message'] = "Email not found. Please register first.";
                header('Location: ../view/guest/login.php');
                exit;
            }

            // Verify user credentials
            $user = $this->userModel->login($email, $password);

            if ($user) {
                // Store user session data after successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    header('Location: ../view/admin/admin-dashboard.php');
                } else {
                    header('Location: ../view/customer/customer-dashboard.php');
                }
                exit;
            } else {
                $_SESSION['error_message'] = "Invalid email or password.";
                header('Location: ../view/guest/login.php');
                exit;
            }
        }
    }
}

// Handle different user actions from GET request
$action = $_GET['action'] ?? '';
$userController = new UserController($pdo);

switch ($action) {
    case 'register':
        $userController->register();
        break;
    case 'login':
        $userController->login();
        break;
    default:
        // Redirect to login page if no valid action is provided
        header('Location: ../view/guest/login.php');
        exit;
}
