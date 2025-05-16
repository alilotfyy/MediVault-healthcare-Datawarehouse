<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$msg = "";

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $notes = $_POST['notes'];

    $filename = null;
    if (!empty($_FILES['file']['name'])) {
        $filename = basename($_FILES['file']['name']);
        $target = "uploads/" . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $target);
    }

    $stmt = $conn->prepare("INSERT INTO medical_reports (appointment_id, doctor_notes, report_file) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $appointment_id, $notes, $filename);
    if ($stmt->execute()) {
        $msg = "Lab/Imaging report uploaded successfully.";
    } else {
        $msg = "Failed to upload report.";
    }
}

// Fetch appointments that are approved and don’t already have reports
$result = $conn->query("
  SELECT a.id, u.full_name, a.appointment_date
  FROM appointments a
  JOIN users u ON u.id = a.patient_id
  WHERE a.doctor_id = $doctor_id AND a.status = 'approved'
  AND a.id NOT IN (SELECT appointment_id FROM medical_reports)
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Upload Lab/Imaging Report</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 700px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    textarea { width: 100%; height: 100px; margin-bottom: 15px; padding: 10px; }
    select, input[type='file'], button { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; }
    .msg { margin-bottom: 20px; color: green; font-weight: bold; }
  </style>
</head>
<body>

<div class="container">
  <h2>Upload Lab or Imaging Report</h2>

  <?php if ($msg): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <label>Select Appointment:</label>
    <select name="appointment_id" required>
      <?php while ($row = $result->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>">
          <?= htmlspecialchars($row['full_name']) ?> - <?= $row['appointment_date'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <label>Doctor Notes:</label>
    <textarea name="notes" required placeholder="Write diagnostic notes..."></textarea>

    <label>Upload File (PDF, image):</label>
    <input type="file" name="file" accept=".pdf,.png,.jpg,.jpeg" required>

    <button type="submit">Upload Report</button>
  </form>

  <a href="doctor_dashboard.php"><button>Back to Dashboard</button></a>
</div>

</body>
</html>