<?php
class Student {
    private $conn;
    public $student_id;
    public $name;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all students
    public function getAll() {
        $query = "SELECT * FROM students";
        return $this->conn->query($query);
    }

    // Create a new student
    public function create() {
        $query = "INSERT INTO students (student_id, name, email) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $this->student_id, $this->name, $this->email);
        return $stmt->execute();
    }

    // Delete a student
    public function delete() {
        $query = "DELETE FROM students WHERE student_id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("s", $this->student_id);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        return true;
    }
}
?>
