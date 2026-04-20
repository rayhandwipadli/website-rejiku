<?php
session_start();
require_once 'midtrans_config.php';  // Pastikan ini sudah di-include
include 'koneksi.php';

// Ambil ID invoice yang dikirimkan dari AJAX
$id_invoice = $_GET['id'];
$id = $_SESSION['customer_id'];

// Ambil data invoice dari database
$invoice = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_customer='$id' AND invoice_id='$id_invoice' ORDER BY invoice_id DESC");
$data = mysqli_fetch_array($invoice);

$customer = mysqli_query($koneksi, "select * from customer where customer_id='$id'");

// Cek apakah data invoice ada
if ($data) {
    $nama_pelanggan = $data['invoice_nama'];
    $telepon = $data['invoice_hp'];
    $total_harga = $data['invoice_total_bayar'];

    // Menyiapkan data transaksi untuk Midtrans
    $transaction_details = array(
        'order_id' => 'ORDER_' . uniqid(),
        'gross_amount' => $total_harga,
    );

    $item_details = array();
    $produk_dibeli = []; // Ambil produk yang dibeli
    $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi, produk WHERE transaksi_produk=produk_id AND transaksi_invoice='$id_invoice'");
    while ($d = mysqli_fetch_array($transaksi)) {
        $produk_dibeli[] = $d['produk_nama'];
    }
    foreach ($produk_dibeli as $produk) {
        $item_details[] = array(
            'id' => uniqid(),
            'price' => $total_harga / count($produk_dibeli),
            'quantity' => 1,
            'name' => $produk,
        );
    }

    // Ambil email pelanggan dari database (kolom 'customer_email')
    while ($i = mysqli_fetch_array($customer)) {
        $email = $i['customer_email'];  // Ambil email dari kolom 'customer_email'
    }

    // Menyiapkan data pelanggan untuk transaksi Midtrans
    $customer_details = array(
        'first_name' => $nama_pelanggan,
        'email' => $email,  // Gunakan email yang diambil dari database
        'phone' => $telepon,
    );

    $transaction = array(
        'payment_type' => 'credit_card',
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    );

    try {
        // Mendapatkan Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        echo json_encode(['status' => 'success', 'snap_token' => $snapToken]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invoice tidak ditemukan']);
}
?>