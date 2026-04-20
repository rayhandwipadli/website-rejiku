<?php
include 'koneksi.php';

$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];
$ukuran = $_POST['ukuran'];

session_start();

// Loop untuk memperbarui keranjang
$jumlah_isi_keranjang = count($_SESSION['keranjang']);
for ($a = 0; $a < $jumlah_isi_keranjang; $a++) {
    // Ambil data produk dari keranjang yang akan diperbarui
    $produk_id = $_SESSION['keranjang'][$a]['produk'];

    // Mengembalikan stok produk yang sebelumnya berkurang (sebelum update)
    $query = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id = '$produk_id'");
    $data = mysqli_fetch_assoc($query);
    $stok_sebelumnya = $data['produk_jumlah'];

    // Menambahkan kembali stok yang berkurang sebelumnya
    $stok_baru = $stok_sebelumnya + $_SESSION['keranjang'][$a]['jumlah'];

    // Update stok produk di database
    mysqli_query($koneksi, "UPDATE produk SET produk_jumlah = '$stok_baru' WHERE produk_id = '$produk_id'");

    // Perbarui data di keranjang sesuai dengan input POST
    $_SESSION['keranjang'][$a] = array(
        'produk' => $produk[$a],
        'jumlah' => $jumlah[$a],
        'ukuran' => $ukuran[$a]
    );

    // Mengurangi stok berdasarkan jumlah baru yang dimasukkan ke keranjang
    $query = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id = '$produk[$a]'");
    $data = mysqli_fetch_assoc($query);
    $stok_terkini = $data['produk_jumlah'] - $jumlah[$a];

    // Perbarui stok produk di database setelah keranjang diupdate
    mysqli_query($koneksi, "UPDATE produk SET produk_jumlah = '$stok_terkini' WHERE produk_id = '$produk[$a]'");
}

header("location:keranjang.php");
?>