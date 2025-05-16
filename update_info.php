<?php
session_start();
include 'db.php';

$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $birth = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $check = $conn->query("SELECT * FROM patients_info WHERE user_id = $id");
    if ($check->num_rows > 0) {
        $sql = "UPDATE patients_info SET birth_date='$birth', gender='$gender', phone='$phone', address='$address' WHERE user_id=$id";
    } else {
        $sql = "INSERT INTO patients_info (user_id, birth_date, gender, phone, address) VALUES ($id, '$birth', '$gender', '$phone', '$address')";
    }

    if ($conn->query($sql)) {
        $msg = "Your information has been updated successfully.";
    } else {
        $msg = "Error: " . $conn->error;
    }
}

$res = $conn->query("SELECT * FROM patients_info WHERE user_id = $id");
$row = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Update My Info - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: sans-serif;
      background: #f5f5f5;
      padding: 40px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      color: #006d77;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    textarea {
      resize: vertical;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #006d77;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: #004e5a;
    }

    .msg {
      margin-bottom: 20px;
      color: green;
      font-weight: bold;
    }

    .back {
      margin-top: 15px;
      display: inline-block;
      color: #006d77;
      font-weight: bold;
      text-decoration: none;
    }

    .back:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Update Your Personal Info</h2>

  <?php if (isset($msg)): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <form method="POST">
    <label for="birth_date">Birthdate:</label>
    <input type="date" name="birth_date" value="<?= $row['birth_date'] ?? '' ?>">

    <label for="gender">Gender:</label>
    <select name="gender">
      <option value="male" <?= (isset($row['gender']) && $row['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
      <option value="female" <?= (isset($row['gender']) && $row['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
      <option value="other" <?= (isset($row['gender']) && $row['gender'] === 'other') ? 'selected' : '' ?>>Other</option>
    </select>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" value="<?= $row['phone'] ?? '' ?>">

    <label for="address">Address:</label>
    <textarea name="address"><?= $row['address'] ?? '' ?></textarea>

    <button type="submit">Save</button>
  </form>

  <a class="back" href="patient_dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>