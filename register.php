<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'patient'; 

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "
        <link rel='stylesheet' href='style.css'>
        <header><h1>Registration Failed</h1></header>
        <div class='container'>
          <p style='color:red;'>Email already registered. <a href='login.html'>Login here</a></p>
        </div>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $pass, $role);

    if ($stmt->execute()) {
        echo "
        <link rel='stylesheet' href='style.css'>
        <header><h1>mediVault</h1></header>
        <div class='container'>
          <h2>Registration Successful!</h2>
          <p>You can now <a href='login.html'><strong>Login here</strong></a>.</p>
        </div>";
    } else {
        echo "
        <link rel='stylesheet' href='style.css'>
        <header><h1>Error</h1></header>
        <div class='container'>
          <p style='color:red;'>Something went wrong. Please try again.</p>
        </div>";
    }
}
?>