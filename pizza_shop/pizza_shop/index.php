<?php
$servername = "localhost";
$username = "root"; // Ubah jika diperlukan
$password = ""; // Ubah jika diperlukan
$dbname = "pemrograman_mobile";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Filter kategori
$category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Mengambil kategori untuk sidebar
$categorySql = "SELECT DISTINCT category FROM pizzas";
$categoryResult = $conn->query($categorySql);

// Mengambil daftar pizza berdasarkan kategori
if ($category === 'All') {
    $pizzaSql = "SELECT * FROM pizzas";
} else {
    $pizzaSql = "SELECT * FROM pizzas WHERE category = '$category'";
}
$pizzaResult = $conn->query($pizzaSql);

// Mengambil riwayat pesanan
$orderHistorySql = "SELECT * FROM orders ORDER BY order_time DESC";
$orderHistoryResult = $conn->query($orderHistorySql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Shop POS System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <h1>Pizza Hut</h1>
        <a href="admin.php" style="float: right;">Admin</a>
    </nav>

    <div class="container">
        <div class="categories">
            <h2>Categories</h2>
            <ul>
                <li>
                    <a href="index.php?category=All" <?php echo ($category == 'All') ? 'class="active"' : ''; ?>>
                        All
                    </a>
                </li>
                <?php
                if ($categoryResult->num_rows > 0) {
                    while ($catRow = $categoryResult->fetch_assoc()) {
                        $catName = $catRow['category'];
                        echo '<li><a href="index.php?category=' . urlencode($catName) . '" ' . 
                             ($category == $catName ? 'class="active"' : '') . '>' . 
                             htmlspecialchars($catName) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="menu">
            <h2><?php echo htmlspecialchars($category); ?> Pizza Menu</h2>
            <div class="pizza-grid">
                <?php
                if ($pizzaResult->num_rows > 0) {
                    while ($row = $pizzaResult->fetch_assoc()) {
                        $imagePath = "uploads/" . htmlspecialchars($row["image"]);
                        
                        // Cek apakah gambar tersedia
                        if (!file_exists($imagePath) || empty($row["image"])) {
                            $imagePath = "uploads/default.jpg"; // Gambar default
                        }

                        echo '<div class="pizza-card" onclick="addToCart(\'' . htmlspecialchars($row["name"]) . '\', ' . $row["price"] . ')">';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row["name"]) . '" style="width: 100%; height: auto;">';
                        echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                        echo '<p>Size: ' . htmlspecialchars($row["size"]) . '</p>';
                        echo '<p>Ingredients: ' . htmlspecialchars($row["ingredients"]) . '</p>';
                        echo '<p>Price: $' . number_format($row["price"], 2) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No pizzas available in this category.</p>";
                }
                ?>
            </div>
        </div>

        <div class="cart">
            <h2>Cart</h2>
            <ul id="cart-items"></ul>
            <h3>Total: $<span id="total-cost">0.00</span></h3>
            <button id="clear-cart" onclick="clearCart()" style="float: right;">Clear</button>
            <h3>Enter Cash:</h3>
            <input type="text" id="cash-input" readonly style="text-align: center; font-size: 1.2em; margin-bottom: 10px;" />
            <div class="keypad">
                <button onclick="appendToCash(1)">1</button>
                <button onclick="appendToCash(2)">2</button>
                <button onclick="appendToCash(3)">3</button>
                <button onclick="appendToCash(4)">4</button>
                <button onclick="appendToCash(5)">5</button>
                <button onclick="appendToCash(6)">6</button>
                <button onclick="appendToCash(7)">7</button>
                <button onclick="appendToCash(8)">8</button>
                <button onclick="appendToCash(9)">9</button>
                <button onclick="appendToCash(0)">0</button>
                <button onclick="appendToCash('.')">.</button>
                <button onclick="clearCash()">C</button>
            </div>
            <h3>Balance: $<span id="balance">0.00</span></h3>
            <button onclick="printInvoice()">Order</button>
        </div>

        <!-- Riwayat Pesanan -->
        <button id="history-button" onclick="showOrderHistory()">View Order History</button>
        <div id="order-history-section" style="display:none;">
            <h2>Order History</h2>
            <ul id="order-history-list">
                <!-- Riwayat akan dimuat di sini -->
            </ul>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>

<?php
$conn->close();
?>
