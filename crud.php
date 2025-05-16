<?php
include 'db.php';
$action = $_GET['action'];

if ($action === 'read') {
    $result = $conn->query("SELECT * FROM customers");
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($action === 'create') {
    $data = json_decode(file_get_contents("php://input"));
    $stmt = $conn->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $data->name, $data->email);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
}
?>