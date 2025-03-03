<?php
class User {
    private $conn;
    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        // Check if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        if (!$checkStmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $checkStmt->bind_param("s", $this->email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            return "email_exists"; // Email already registered
        }

        // Insert new user with hashed password
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("sss", $this->username, $this->email, $hashedPassword);
        
        if ($stmt->execute()) {
            return "success";
        } else {
            return "error";
        }
    }

    public function login() {
        $query = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($this->id, $this->username, $hashedPassword);
            $stmt->fetch();
            
            if (password_verify($this->password, $hashedPassword)) {
                return "success"; // Login successful
            } else {
                return "invalid_password"; // Incorrect password
            }
        }
        return "invalid_email"; // Email not found
    }
}
?>
