<?php
session_start();
if ($_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit;
}
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>mediVault - Patient Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #006d77;
      padding: 15px 30px;
      color: white;
    }

    .topbar h1 {
      margin: 0;
      font-size: 22px;
    }

    .account {
      position: relative;
      display: inline-block;
    }

    .account .fa-user-circle {
      font-size: 24px;
      cursor: pointer;
    }

    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 40px;
      background-color: white;
      min-width: 150px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      border-radius: 6px;
      z-index: 1;
    }

    .dropdown a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {
      background-color: #f1f1f1;
    }

    .dashboard {
      max-width: 1100px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    .dashboard h2 {
      margin-bottom: 30px;
      color: #006d77;
      text-align: center;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 20px;
    }

    .card {
      background: #eafaf1;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      transition: 0.3s;
    }

    .card:hover {
      background: #dff2ea;
    }

    .card h3 {
      margin-top: 0;
      color: #006d77;
    }

    .card ul {
      padding-left: 20px;
      font-size: 15px;
    }

    .card a {
      display: inline-block;
      margin-top: 10px;
      color: #006d77;
      text-decoration: underline;
      font-weight: bold;
    }

    .card a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="topbar">
  <h1>mediVault - Patient Dashboard</h1>
  <div class="account" onclick="toggleDropdown()">
    <i class="fas fa-user-circle"></i>
    <div class="dropdown" id="accountDropdown">
      <a href="#">Welcome, <?= htmlspecialchars($name) ?></a>
      <a href="update_info.php">Update Info</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<div class="dashboard">
  <h2>Hello, <?= htmlspecialchars($name) ?> 👋</h2>

  <div class="grid">

    <div class="card">
      <h3>Appointments</h3>
      <ul>
        <li>Book an appointment</li>
        <br>
        <br>
        <br>
      </ul>
      <a href="appointments.php">View Appointments</a>
    </div>

    <div class="card">
      <h3>Medical history</h3>
      <ul>
        <li>Update all medical history</li>
        <br>
        <br>
        <br>
      </ul>
      <a href="medical_history.php">Access Records</a>
    </div>

    <div class="card">
      <h3>Medications</h3>
      <ul>
        <li>Active prescriptions</li>
        <li>Refill reminders</li>
        <li>Interaction warnings</li>
      </ul>
      <a href="medications.php">View Medications</a>
    </div>

    <div class="card">
      <h3>Health Tracking & Analytics</h3>
      <ul>
        <li>Blood pressure, glucose</li>
        <li>Wearable integration</li>
        <li>Progress charts</li>
      </ul>
      <a href="tracking.php">View Progress</a>
    </div>
    

    <div class="card">
      <h3>Insurance</h3>
      <ul>
        <li>Invoices & receipts</li>
        <li>Insurance claims</li>
        <li>Coverage details</li>
      </ul>
      <a href="insurance.php">Add details</a>
    </div>

    <div class="card">
      <h3>Support & Chat</h3>
      <ul>
        <li>Talk with your doctor</li>
        <li>Ask health-related questions</li>
        <li>Private and secure</li>
      </ul>
      <a href="chat.php">Message Support</a>
    </div>

  </div>
</div>

<script>
  function toggleDropdown() {
    const dropdown = document.getElementById("accountDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }

  window.onclick = function(event) {
    const dropdown = document.getElementById("accountDropdown");
    if (!event.target.closest('.account')) {
      dropdown.style.display = "none";
    }
  };
</script>

</body>
</html>