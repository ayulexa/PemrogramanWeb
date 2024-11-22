<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemrograman_mobile";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Handle API requests
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Endpoint Logic
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Fetch a single pizza by ID
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM pizzas WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $pizza = $result->fetch_assoc();
                echo json_encode(["status" => "success", "data" => $pizza]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Pizza not found"]);
            }
        } else {
            // Fetch all pizzas
            $sql = "SELECT * FROM pizzas";
            $result = $conn->query($sql);

            $pizzas = [];
            while ($row = $result->fetch_assoc()) {
                $pizzas[] = $row;
            }

            echo json_encode(["status" => "success", "data" => $pizzas]);
        }
        break;

    case 'POST':
        // Add a new pizza
        if (
            isset($input['name'], $input['size'], $input['ingredients'], $input['price'], $input['category'], $input['image'])
        ) {
            $name = $input['name'];
            $size = $input['size'];
            $ingredients = $input['ingredients'];
            $price = $input['price'];
            $category = $input['category'];
            $image = $input['image'];

            $sql = "INSERT INTO pizzas (name, size, ingredients, price, category, image) 
                    VALUES ('$name', '$size', '$ingredients', $price, '$category', '$image')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Pizza added successfully"]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
        }
        break;

    case 'PUT':
        // Update an existing pizza
        if (
            isset($_GET['id'], $input['name'], $input['size'], $input['ingredients'], $input['price'], $input['category'], $input['image'])
        ) {
            $id = intval($_GET['id']);
            $name = $input['name'];
            $size = $input['size'];
            $ingredients = $input['ingredients'];
            $price = $input['price'];
            $category = $input['category'];
            $image = $input['image'];

            $sql = "UPDATE pizzas 
                    SET name='$name', size='$size', ingredients='$ingredients', price=$price, category='$category', image='$image' 
                    WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Pizza updated successfully"]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
        }
        break;

    case 'DELETE':
        // Delete a pizza
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "DELETE FROM pizzas WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Pizza deleted successfully"]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

$conn->close();
?>
