<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemrograman_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$totalPrice = $data['totalPrice'];
$orderDetails = json_encode($data['cart']);
$orderTime = date('Y-m-d H:i:s');  // Use the current date and time

$sql = "INSERT INTO orders (total_price, order_details, order_time) VALUES ('$totalPrice', '$orderDetails', '$orderTime')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
?>
