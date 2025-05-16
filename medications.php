<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM medications WHERE user_id = $user_id ORDER BY start_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Medications - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: sans-serif; background: #f7f7f7; padding: 40px; }
    .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    h2 { color: #006d77; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 12px; text-align: center; }
    th { background-color: #eafaf1; }
  </style>
</head>
<body>
<div class="container">
  <h2>My Medications</h2>
  <?php if ($result->num_rows > 0): ?>
  <table>
    <tr>
      <th>Name</th>
      <th>Dosage</th>
      <th>Frequency</th>
      <th>Start</th>
      <th>End</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['dosage']) ?></td>
        <td><?= htmlspecialchars($row['frequency']) ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['end_date'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
  <?php else: ?>
    <p>No medications found.</p>
  <?php endif; ?>
  <br><a href="patient_dashboard.php"><button>Back</button></a>
</div>
</body>
</html>