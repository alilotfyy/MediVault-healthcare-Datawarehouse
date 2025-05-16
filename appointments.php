<?php
session_start();
include 'db.php';
$id = $_SESSION['user_id'];

$sql = "SELECT a.*, d.full_name AS doctor, r.doctor_notes, r.report_file
        FROM appointments a
        JOIN users d ON a.doctor_id = d.id
        LEFT JOIN medical_reports r ON a.id = r.appointment_id
        WHERE a.patient_id = $id
        ORDER BY a.appointment_date DESC";

$res = $conn->query($sql);
?>
<link rel="stylesheet" href="style.css">
<header><h1>mediVault - Patient Portal</h1></header>
<div class="container">
<h2>Your Appointments</h2>
<table>
  <tr>
    <th>Doctor</th><th>Date</th><th>Status</th><th>Report</th>
  </tr>
  <?php while($row = $res->fetch_assoc()): ?>
    <tr>
      <td><?= $row['doctor'] ?></td>
      <td><?= $row['appointment_date'] ?></td>
      <td><?= ucfirst($row['status']) ?></td>
      <td>
        <?php if ($row['doctor_notes']): ?>
          <?= $row['doctor_notes'] ?><br>
          <?php if ($row['report_file']): ?>
            <a href="uploads/<?= $row['report_file'] ?>" target="_blank">Download Report</a>
          <?php endif; ?>
        <?php else: ?>
          <em>Pending</em>
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<a href="patient_dashboard.php">Back</a>
</div>