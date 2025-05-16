<?php
session_start();
include 'db.php';
$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor = $_POST['doctor'];
    $date = $_POST['appointment_date'];
    $conn->query("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES ($id, $doctor, '$date')");
    echo "<p>Appointment requested successfully.</p><a href='patient_dashboard.php'>Back</a>";
    exit;
}

$doctors = $conn->query("SELECT id, full_name FROM users WHERE role = 'doctor'");
?>
<link rel="stylesheet" href="style.css">
<header><h1>mediVault - Patient Portal</h1></header>
<div class="container">
<h2>Book an Appointment</h2>
<form method="POST">
  <label>Select Doctor:</label>
  <select name="doctor" required>
    <?php while($doc = $doctors->fetch_assoc()): ?>
      <option value="<?= $doc['id'] ?>"><?= $doc['full_name'] ?></option>
    <?php endwhile; ?>
  </select><br>
  <label>Date & Time:</label>
  <input type="datetime-local" name="appointment_date" required><br>
  <button type="submit">Book</button>
</form>

<a href="patient_dashboard.php">Back</a>
</div>