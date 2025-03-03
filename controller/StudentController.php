<?php
include_once __DIR__ . "/../models/Student.php";
include_once __DIR__ . "/../config/Database.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class StudentController {
    private $studentModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->studentModel = new Student($db);
    }

    public function getAllStudents() {
        return $this->studentModel->getAll();
    }

    public function createStudent($student_id, $name, $email) {
        $this->studentModel->student_id = $student_id;
        $this->studentModel->name = $name;
        $this->studentModel->email = $email;
        return $this->studentModel->create();
    }

    public function deleteStudent($student_id) {
        $this->studentModel->student_id = $student_id; 
        return $this->studentModel->delete();
    }
}

// Handle POST Requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentController = new StudentController();

    if (isset($_POST["create_student"])) {
        if ($studentController->createStudent($_POST["student_id"], $_POST["name"], $_POST["email"])) {
            header("Location: ../views/dashboard.php?success=student_added");
            exit;
        } else {
            echo "Failed to create student.";
        }
    } elseif (isset($_POST["delete_student"])) {
        if ($studentController->deleteStudent($_POST["delete_student_id"])) { 
            header("Location: ../views/dashboard.php?success=student_deleted");
            exit;
        } else {
            echo "Failed to delete student.";
        }
    }
}
?>
