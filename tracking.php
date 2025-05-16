<?php
session_start();
if ($_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Health Tracking - mediVault</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: sans-serif; background: #f2f2f2; padding: 40px; }
    .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    h2 { color: #006d77; }
    canvas { margin-top: 30px; }
  </style>
</head>
<body>
<div class="container">
  <h2>Health Tracking & Analytics</h2>

  <p>Blood Pressure Over Time</p>
  <canvas id="bpChart" height="120"></canvas>

  <p>Glucose Levels</p>
  <canvas id="glucoseChart" height="120"></canvas>

  <br><a href="patient_dashboard.php"><button>Back</button></a>
</div>

<script>
const bpCtx = document.getElementById('bpChart').getContext('2d');
const bpChart = new Chart(bpCtx, {
  type: 'line',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [{
      label: 'Systolic',
      data: [120, 125, 118, 122, 117],
      borderColor: '#ff6384',
      fill: false
    }, {
      label: 'Diastolic',
      data: [80, 82, 78, 79, 77],
      borderColor: '#36a2eb',
      fill: false
    }]
  }
});

const glucoseCtx = document.getElementById('glucoseChart').getContext('2d');
const glucoseChart = new Chart(glucoseCtx, {
  type: 'line',
  data: {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
    datasets: [{
      label: 'Glucose (mg/dL)',
      data: [95, 105, 98, 110, 102],
      borderColor: '#4bc0c0',
      fill: true,
      backgroundColor: 'rgba(75,192,192,0.2)'
    }]
  }
});
</script>
</body>
</html>