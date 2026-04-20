<?php
require_once 'midtrans_config.php'; // Pastikan ini berisi konfigurasi Midtrans
require_once 'koneksi.php'; // Pastikan ini file koneksi ke database

// Ambil data JSON dari Midtrans
$json = file_get_contents('php://input');
$midtrans_data = json_decode($json, true);

if (!$midtrans_data) {
    die("Invalid request");
}

// Ambil data dari notifikasi Midtrans
$order_id = $midtrans_data['order_id'];
$status_pembayaran = $midtrans_data['transaction_status'];
$payment_time = $midtrans_data['transaction_time'];
$payment_type = $midtrans_data['payment_type'];
$gross_amount = $midtrans_data['gross_amount'];
$created_at = date('Y-m-d H:i:s');

// Simpan atau update data pembayaran ke database
$query = "INSERT INTO invoice_midtrans (order_id, status_pembayaran, payment_time, payment_type, gross_amount, created_at) 
          VALUES ('$order_id', '$status_pembayaran', '$payment_time', '$payment_type', '$gross_amount', '$created_at')
          ON DUPLICATE KEY UPDATE 
          status_pembayaran='$status_pembayaran', payment_time='$payment_time', payment_type='$payment_type', gross_amount='$gross_amount', created_at='$created_at'";

if (mysqli_query($koneksi, $query)) {
    echo "OK";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>