<?php
session_start();
if ($_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>mediVault - Doctor Dashboard</title>
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
      max-width: 1000px;
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

    .features {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .feature-box {
      flex: 1 1 200px;
      background: #eafaf1;
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      transition: 0.3s;
    }

    .feature-box:hover {
      background: #d9f2eb;
    }

    .feature-box a {
      text-decoration: none;
      color: #006d77;
      font-weight: bold;
      font-size: 16px;
    }

    button {
      background: #006d77;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover {
      background: #004e5a;
    }
  </style>
</head>
<body>

<div class="topbar">
  <h1>mediVault - Doctor Dashboard</h1>
  <div class="account" onclick="toggleDropdown()">
    <i class="fas fa-user-circle"></i>
    <div class="dropdown" id="accountDropdown">
      <a href="#">Dr. <?= htmlspecialchars($name) ?></a>
      <a href="view_account.php">View Account</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<div class="dashboard">
  <h2>Welcome, Dr. <?= htmlspecialchars($name) ?></h2>

  <div class="features">
    <div class="feature-box"><a href="appointments_manage.php">🗓 Manage Appointments</a></div>
    <div class="feature-box"><a href="calendar.php">📅 View Calendar</a></div>
    <div class="feature-box"><a href="write_report.php">📝 Write Reports</a></div>
    <div class="feature-box"><a href="upload_lab.php">📤 Upload Lab/Imaging</a></div>
    <div class="feature-box"><a href="search_patients.php">🔍 Search Patients</a></div>
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