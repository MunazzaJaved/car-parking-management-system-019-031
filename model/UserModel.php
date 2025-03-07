<?php
class UserModel
{
    private $pdo;

    // Constructor to initialize the PDO connection
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Method to insert user data into the database
    public function register($name, $email, $password, $contact)
    {
        // Hash password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert data into the database
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, contact) VALUES (?, ?, ?, ?)");

        // Execute the query
        return $stmt->execute([$name, $email, $hashedPassword, $contact]);
    }

    public function emailExists($email)
    {
        // Prepare SQL query to check if there's already a user with the given email
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);

        // Fetch the result; if count > 0, the email exists
        $count = $stmt->fetchColumn();

        return $count > 0;  // If count is greater than 0, email exists
    }

    //login
    public function login($email, $password)
    {
        // Prepare SQL query to fetch the user by email
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user found, verify the password
        if ($user && password_verify($password, $user['password'])) {
            return $user;  // Return user data if login is successful
        }

        return false;  // Return false if credentials are invalid
    }

    // Get user by ID
    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user profile
    public function updateUser($userId, $name, $email, $contact)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, contact = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $contact, $userId]);
    }
}
