<?php
session_start();
include 'db.php';
$doc_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['appointment_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE appointments SET status = '$status' WHERE id = $id AND doctor_id = $doc_id");
}

$res = $conn->query("SELECT a.*, p.full_name AS patient 
                     FROM appointments a 
                     JOIN users p ON a.patient_id = p.id 
                     WHERE doctor_id = $doc_id 
                     ORDER BY appointment_date DESC");
?>
<link rel="stylesheet" href="style.css">
<header><h1>Manage Appointments</h1></header>
<div class="container">
<h2>Appointments</h2>
<table>
  <tr>
    <th>Patient</th><th>Date</th><th>Status</th><th>Action</th>
  </tr>
  <?php while($row = $res->fetch_assoc()): ?>
  <tr>
    <td><?= $row['patient'] ?></td>
    <td><?= $row['appointment_date'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
      <?php if ($row['status'] === 'pending'): ?>
        <form method="POST" style="display:inline;">
          <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
          <button type="submit" name="status" value="approved">Approve</button>
          <button type="submit" name="status" value="rejected">Reject</button>
        </form>
      <?php else: ?>
        —
      <?php endif; ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
<a href="doctor_dashboard.php">Back</a>
</div>