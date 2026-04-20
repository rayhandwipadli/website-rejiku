<?php
// Memasukkan Autoloader Midtrans
require_once 'midtrans-php-master/midtrans-php-master/Midtrans.php';

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = '';  // Ganti dengan server key kamu
\Midtrans\Config::$clientKey = '';  // Ganti dengan client key kamu
\Midtrans\Config::$isProduction = false;  // Set true jika sudah di mode live
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>
