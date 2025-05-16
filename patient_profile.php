<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}

$patient_id = $_GET['id'] ?? null;

if (!$patient_id) {
    echo "Patient ID not specified.";
    exit;
}

// Get patient info
$patient = $conn->query("SELECT * FROM users WHERE id = $patient_id AND role = 'patient'")->fetch_assoc();
if (!$patient) {
    echo "Patient not found.";
    exit;
}

// Medical history
$history = $conn->query("SELECT * FROM medical_history WHERE user_id = $patient_id ORDER BY date_recorded DESC");

// Reports
$reports = $conn->query("
  SELECT r.*, a.appointment_date, d.full_name AS doctor_name
  FROM medical_reports r
  JOIN appointments a ON r.appointment_id = a.id
  JOIN users d ON a.doctor_id = d.id
  WHERE a.patient_id = $patient_id
  ORDER BY a.appointment_date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Patient Profile - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 800px; margin: 50px auto; }
    h2 { color: #006d77; margin-bottom: 20px; }
    section { margin-bottom: 40px; }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
    }
    th { background: #f0f7f7; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Patient Profile</h2>

    <section>
      <h3>Basic Info</h3>
      <p><strong>Name:</strong> <?= htmlspecialchars($patient['full_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($patient['email']) ?></p>
      <p><strong>Joined:</strong> <?= date('F j, Y', strtotime($patient['created_at'])) ?></p>
    </section>

    <section>
      <h3>Medical History</h3>
      <?php if ($history->num_rows > 0): ?>
      <table>
        <tr><th>Date</th><th>Condition</th></tr>
        <?php while ($row = $history->fetch_assoc()): ?>
          <tr>
            <td><?= $row['date_recorded'] ?></td>
            <td><?= htmlspecialchars($row['condition_summary']) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No history available.</p>
      <?php endif; ?>
    </section>

    <section>
      <h3>Lab / Imaging Reports</h3>
      <?php if ($reports->num_rows > 0): ?>
      <table>
        <tr>
          <th>Date</th><th>Doctor</th><th>Notes</th><th>File</th>
        </tr>
        <?php while ($rep = $reports->fetch_assoc()): ?>
        <tr>
          <td><?= $rep['appointment_date'] ?></td>
          <td><?= htmlspecialchars($rep['doctor_name']) ?></td>
          <td><?= htmlspecialchars($rep['doctor_notes']) ?></td>
          <td>
            <?php if ($rep['report_file']): ?>
              <a href="uploads/<?= $rep['report_file'] ?>" target="_blank">Download</a>
            <?php else: ?>
              <em>No file</em>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No reports uploaded yet.</p>
      <?php endif; ?>
    </section>

    <a href="search_patients.php"><button>Back to Search</button></a>
  </div>
</body>
</html>