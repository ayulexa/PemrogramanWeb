<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemrograman_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM orders ORDER BY order_time DESC";
$result = $conn->query($sql);

$orderHistory = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orderHistory[] = [
            'id' => $row['id'],
            'total_price' => $row['total_price'],
            'order_time' => $row['order_time'],
            'order_details' => json_decode($row['order_details'])
        ];
    }
}

echo json_encode($orderHistory);

$conn->close();
?>
