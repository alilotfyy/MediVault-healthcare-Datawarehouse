<?php
session_start();
include 'db.php';
$doc_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $notes = $_POST['notes'];
    $filename = null;

    if ($_FILES['report_file']['name']) {
        $filename = basename($_FILES['report_file']['name']);
        $target = "uploads/" . $filename;
        move_uploaded_file($_FILES['report_file']['tmp_name'], $target);
    }

    $sql = "INSERT INTO medical_reports (appointment_id, doctor_notes, report_file)
            VALUES ($appointment_id, '$notes', '$filename')";
    $conn->query($sql);
    echo "<p>Report saved.</p><a href='doctor_dashboard.php'>Back</a>";
    exit;
}

$res = $conn->query("SELECT a.id, u.full_name, a.appointment_date
                     FROM appointments a
                     JOIN users u ON a.patient_id = u.id
                     WHERE a.doctor_id = $doc_id AND a.status = 'approved'
                     AND a.id NOT IN (SELECT appointment_id FROM medical_reports)");
?>
<link rel="stylesheet" href="style.css">
<header><h1>Write Medical Report</h1></header>
<div class="container">
<form method="POST" enctype="multipart/form-data">
  <label>Appointment:</label>
  <select name="appointment_id" required>
    <?php while($row = $res->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>">
        <?= $row['full_name'] ?> - <?= $row['appointment_date'] ?>
      </option>
    <?php endwhile; ?>
  </select><br>

  <label>Doctor Notes:</label>
  <textarea name="notes" required></textarea><br>

  <label>Attach PDF Report:</label>
  <input type="file" name="report_file" accept="application/pdf"><br>

  <button type="submit">Submit Report</button>
</form>
<a href="doctor_dashboard.php">Back</a>
</div>