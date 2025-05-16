<?php
session_start();
include 'db.php';
$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider = $_POST['provider'];
    $number = $_POST['number'];
    $expiry = $_POST['expiry'];

    $exists = $conn->query("SELECT * FROM insurance_info WHERE user_id = $id");
    if ($exists->num_rows > 0) {
        $sql = "UPDATE insurance_info SET provider_name='$provider', insurance_number='$number', expiry_date='$expiry' WHERE user_id=$id";
    } else {
        $sql = "INSERT INTO insurance_info (user_id, provider_name, insurance_number, expiry_date) VALUES ($id, '$provider', '$number', '$expiry')";
    }
    $conn->query($sql);
}

$res = $conn->query("SELECT * FROM insurance_info WHERE user_id = $id");
$row = $res->fetch_assoc();
?>
<link rel="stylesheet" href="style.css">
<header><h1>mediVault - Patient Portal</h1></header>
<div class="container">
<h2>Insurance Details</h2>
<form method="POST">
  <input type="text" name="provider" placeholder="Provider Name" value="<?= $row['provider_name'] ?? '' ?>"><br>
  <input type="text" name="number" placeholder="Policy Number" value="<?= $row['insurance_number'] ?? '' ?>"><br>
  <input type="date" name="expiry" value="<?= $row['expiry_date'] ?? '' ?>"><br>
  <button type="submit">Save</button>
</form>

<a href="patient_dashboard.php">Back</a>
</div>