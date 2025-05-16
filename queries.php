<?php
include 'db.php';
$query = $_GET['query'];

if ($query === "top_customers") {
    $sql = "SELECT customers.name, COUNT(orders.id) AS order_count, SUM(orders.amount) AS total_amount
            FROM customers
            JOIN orders ON customers.id = orders.customer_id
            GROUP BY customers.id
            ORDER BY total_amount DESC
            LIMIT 5";
} elseif ($query === "expensive_categories") {
    $threshold = (float)$_GET['threshold'];
    $sql = "SELECT category, AVG(price) as avg_price
            FROM products
            GROUP BY category
            HAVING avg_price > $threshold";
} else {
    die(json_encode(["error" => "Invalid query"]));
}

$result = $conn->query($sql);
$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>