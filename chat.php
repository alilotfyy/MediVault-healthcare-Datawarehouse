<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit;
}

$sender_id = $_SESSION['user_id'];
$doctor_id = 1; // 📝 hardcoded for now — can be dynamically assigned later

// Send message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = trim($_POST['message']);
    if (!empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $sender_id, $doctor_id, $msg);
        $stmt->execute();
    }
}

// Retrieve messages between patient & doctor
$stmt = $conn->prepare("
  SELECT m.*, u.full_name AS sender_name
  FROM messages m
  JOIN users u ON u.id = m.sender_id
  WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
  ORDER BY sent_at ASC
");
$stmt->bind_param("iiii", $sender_id, $doctor_id, $doctor_id, $sender_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Chat with Doctor - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: sans-serif; background: #f2f2f2; padding: 40px; }
    .container { max-width: 700px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { color: #006d77; margin-bottom: 20px; }
    .chat-box {
      border: 1px solid #ddd;
      padding: 15px;
      max-height: 300px;
      overflow-y: scroll;
      margin-bottom: 20px;
      background: #f9f9f9;
      border-radius: 8px;
    }
    .msg {
      margin: 10px 0;
      padding: 10px;
      border-radius: 8px;
      max-width: 80%;
    }
    .sent { background: #d0f0e0; align-self: flex-end; }
    .received { background: #e9e9e9; align-self: flex-start; }
    form textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      resize: vertical;
    }
    form button {
      margin-top: 10px;
      padding: 10px 20px;
      background: #006d77;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .meta {
      font-size: 11px;
      color: #777;
      margin-top: 3px;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Message Your Doctor</h2>

  <div class="chat-box">
    <?php while ($msg = $result->fetch_assoc()): ?>
      <div class="msg <?= $msg['sender_id'] === $sender_id ? 'sent' : 'received' ?>">
        <strong><?= $msg['sender_name'] ?>:</strong><br>
        <?= htmlspecialchars($msg['message']) ?>
        <div class="meta"><?= date('M j, g:i a', strtotime($msg['sent_at'])) ?></div>
      </div>
    <?php endwhile; ?>
  </div>

  <form method="POST">
    <textarea name="message" rows="3" placeholder="Type your message..." required></textarea>
    <button type="submit">Send</button>
  </form>

  <br><a href="patient_dashboard.php"><button>Back to Dashboard</button></a>
</div>
</body>
</html>