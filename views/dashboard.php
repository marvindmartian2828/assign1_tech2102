<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

include_once __DIR__ . "/../controller/StudentController.php";
$studentController = new StudentController();
$students = $studentController->getAllStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?>!</h2>
            <a href="../controller/AuthController.php?logout=true" class="logout-btn">Logout</a>
        </div>

        <!-- Student List Section -->
        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student["student_id"]); ?></td>
                        <td><?php echo htmlspecialchars($student["name"]); ?></td>
                        <td><?php echo htmlspecialchars($student["email"]); ?></td>
                        <td>
                            <form action="../controller/StudentController.php" method="POST">
                                <input type="hidden" name="delete_student_id" value="<?php echo $student["student_id"]; ?>">
                                <button type="submit" name="delete_student" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Add Student Section -->
        <div class="add-student-section">
            <h3>Add Student</h3>
            <form action="../controller/StudentController.php" method="POST" class="add-student-form">
                <input type="text" name="student_id" placeholder="Student ID" required>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit" name="create_student" class="add-btn">Add Student</button>
            </form>
        </div>
    </div>
</body>
</html>
