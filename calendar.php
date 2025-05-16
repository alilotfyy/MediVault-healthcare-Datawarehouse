<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$appointments = $conn->query("
    SELECT a.id, a.appointment_date, u.full_name AS patient
    FROM appointments a
    JOIN users u ON u.id = a.patient_id
    WHERE a.doctor_id = $doctor_id
");

$events = [];
while ($row = $appointments->fetch_assoc()) {
    $events[] = [
        'title' => $row['patient'],
        'start' => $row['appointment_date'],
        'url' => 'patient_profile.php?id=' . $row['id']
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Appointment Calendar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>My Appointment Calendar</h2>
    <div id='calendar'></div>
    <br><a href="doctor_dashboard.php"><button>Back to Dashboard</button></a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        events: <?= json_encode($events) ?>
      });
      calendar.render();
    });
  </script>
</body>
</html>