<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $role;

            if ($role === 'patient') {
                header("Location: patient_dashboard.php");
            } else {
                header("Location: doctor_dashboard.php");
            }
            exit;
        } else {
            echo "<p>Incorrect password. <a href='login.html'>Try again</a></p>";
        }
    } else {
        echo "<p>No account found. <a href='register.html'>Register</a></p>";
    }
}
?>