<?php
session_start();
include 'db.php';

// Only allow doctors
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit;
}

// Process search
$search = $_GET['search'] ?? '';
$results = [];

if ($search) {
    $stmt = $conn->prepare("
        SELECT u.id, u.full_name, u.email
        FROM users u
        LEFT JOIN medical_history m ON u.id = m.user_id
        WHERE u.role = 'patient' AND (u.full_name LIKE CONCAT('%', ?, '%') OR m.condition_summary LIKE CONCAT('%', ?, '%'))
        GROUP BY u.id
    ");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Patients - mediVault</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 800px; margin: 50px auto; }
    form { margin-bottom: 30px; }
    input[type="text"] {
      padding: 10px;
      width: 70%;
      margin-right: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      padding: 10px 20px;
      border: none;
      background: #006d77;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
    }
    th { background: #f0f7f7; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Search Patients</h2>
    <form method="GET">
      <input type="text" name="search" placeholder="Enter name or condition..." value="<?= htmlspecialchars($search) ?>" required>
      <button type="submit">Search</button>
    </form>

    <?php if ($search && $results->num_rows > 0): ?>
      <table>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>View</th>
        </tr>
        <?php while ($row = $results->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><a href="patient_profile.php?id=<?= $row['id'] ?>"><button>View Profile</button></a></td>
        </tr>
        <?php endwhile; ?>
      </table>
    <?php elseif ($search): ?>
      <p>No patients found.</p>
    <?php endif; ?>
  </div>
</body>
</html>