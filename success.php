<?php
session_start();
$message = $_GET['msg'] ?? 'Operation completed.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>mediVault - Status</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>mediVault</h1></header>
<div class="container">
  <div class="success-msg">
    <?= htmlspecialchars($message) ?>
  </div>
  <br>
  <a href="login.html"><button>Go to Login</button></a>
</div>
</body>
</html>