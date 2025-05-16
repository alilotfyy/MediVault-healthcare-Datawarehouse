<?php
session_start();
include 'db.php';
$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $condition = $_POST['condition'];
    $date = $_POST['date_recorded'];
    $sql = "INSERT INTO medical_history (user_id, condition_summary, date_recorded) VALUES ($id, '$condition', '$date')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM medical_history WHERE user_id = $id");
?>
<link rel="stylesheet" href="style.css">
<header><h1>mediVault - Patient Portal</h1></header>
<div class="container">
<h2>Medical History</h2>
<ul>
<?php while($row = $result->fetch_assoc()): ?>
  <li><?= $row['date_recorded'] ?> - <?= $row['condition_summary'] ?></li>
<?php endwhile; ?>
</ul>

<h3>Add New</h3>
<form method="POST">
  <input type="date" name="date_recorded" required><br>
  <textarea name="condition" placeholder="Condition details" required></textarea><br>
  <button type="submit">Add</button>
</form>

<a href="patient_dashboard.php">Back</a>
</div>