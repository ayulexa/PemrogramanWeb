<?php
require_once __DIR__ . '/traits/CanPay.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Customer.php';

use Models\Customer;

// Membuat objek Customer
$customer = new Customer("Lexa", "lexa@gmail.com", "Gold");

// Output menggunakan magic method __toString()
echo $customer . PHP_EOL;
echo $customer->pay(150000);
