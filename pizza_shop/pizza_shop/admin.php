<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemrograman_mobile";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Folder untuk menyimpan gambar
$target_dir = "uploads/";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_pizza'])) {
        $name = $_POST['name'];
        $size = $_POST['size'];
        $ingredients = $_POST['ingredients'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Proses upload gambar
        if (!empty($_FILES["image"]["name"])) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = basename($_FILES["image"]["name"]); // Nama file yang disimpan
                    $sql = "INSERT INTO pizzas (name, size, ingredients, price, category, image) 
                            VALUES ('$name', '$size', '$ingredients', $price, '$category', '$image')";
                    $conn->query($sql);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            echo "Please select an image to upload.";
        }
    } elseif (isset($_POST['update_pizza'])) {
        // Update pizza
        $id = $_POST['id'];
        $name = $_POST['name'];
        $size = $_POST['size'];
        $ingredients = $_POST['ingredients'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Proses gambar baru jika diunggah
        $image = $_POST['current_image']; // Default gambar lama
        if (!empty($_FILES["image"]["name"])) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = basename($_FILES["image"]["name"]); // Ganti gambar lama
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        $sql = "UPDATE pizzas 
                SET name='$name', size='$size', ingredients='$ingredients', price=$price, category='$category', image='$image'
                WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_pizza'])) {
        // Delete pizza
        $id = $_POST['id'];
        $sql = "DELETE FROM pizzas WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch all pizzas
$sql = "SELECT * FROM pizzas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pizza Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Pizza Management</h1>

    <!-- Add Pizza Form -->
    <h2>Add New Pizza</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="size" placeholder="Size (Small, Medium, Large)" required>
        <textarea name="ingredients" placeholder="Ingredients" required></textarea>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="add_pizza">Add Pizza</button>
    </form>

    <!-- Pizza List -->
    <h2>Manage Pizzas</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Size</th>
            <th>Ingredients</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <form method='POST' enctype='multipart/form-data'>
                        <td><input type='text' name='name' value='" . htmlspecialchars($row['name']) . "' required></td>
                        <td><input type='text' name='size' value='" . htmlspecialchars($row['size']) . "' required></td>
                        <td><textarea name='ingredients' required>" . htmlspecialchars($row['ingredients']) . "</textarea></td>
                        <td><input type='number' name='price' step='0.01' value='" . $row['price'] . "' required></td>
                        <td><input type='text' name='category' value='" . htmlspecialchars($row['category']) . "' required></td>
                        <td>
                            <img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Pizza Image' style='width:100px; height:auto;'><br>
                            <input type='file' name='image' accept='image/*'>
                            <input type='hidden' name='current_image' value='" . htmlspecialchars($row['image']) . "'>
                        </td>
                        <td>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <button type='submit' name='update_pizza'>Update</button>
                            <button type='submit' name='delete_pizza'>Delete</button>
                        </td>
                        </form>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No pizzas found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
