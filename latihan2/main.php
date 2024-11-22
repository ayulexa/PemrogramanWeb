<?php

header("Content-Type: application/json; charset-UTF-8");

include "app/Routes/ProductRoutes.php";

use app\Routes\ProductRoutes;

// Menangkap request method
$method = $_SERVER['REQUEST_METHOD'];
// Menangkap Request Path
$path = parse_url($_SERVER['REQUEST_URL'], PHP_URL_PATH);

// Panggil Routes
$productRoutes = new ProductRoutes();
$productRoutes->handle($method, $path);