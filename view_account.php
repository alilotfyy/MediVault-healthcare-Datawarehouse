<?php
session_start();
include 'db.php';

// Redirect if not logged in or not a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}

$id = $_SESSION['user_id'];

// Handle update if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $id);
    $stmt->execute();
}

// Fetch updated user info
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Account - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .account-view {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .account-view h2 {
      color: #006d77;
      margin-bottom: 20px;
    }

    .account-view label {
      font-weight: bold;
      margin-bottom: 6px;
      display: block;
    }

    .account-view input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .account-view button {
      padding: 10px 20px;
      font-weight: bold;
      background: #006d77;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .account-view button:hover {
      background: #004e5a;
    }

    .back-btn {
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="account-view">
  <h2>Your Account Details</h2>
  <form method="POST">
    <label>Full Name:</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
    <p><strong>Joined:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>

    <button type="submit">Save Changes</button>
  </form>

  <div class="back-btn">
    <a href="doctor_dashboard.php"><button>Back to Dashboard</button></a>
  </div>
</div>

</body>
</html>