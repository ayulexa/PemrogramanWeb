<?php
// index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'traits/NumberTraits.php';
require_once 'controllers/NumberController.php';

use Controllers\NumberController;

// Misalkan kita ingin mencetak bilangan hingga 25
$n = 25;

// Membuat instance dari NumberController
$controller = new NumberController();
$controller->tampilkanBilangan($n);
