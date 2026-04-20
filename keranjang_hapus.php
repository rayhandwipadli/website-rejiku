<?php 
include 'koneksi.php';
session_start();

$id_produk = mysqli_real_escape_string($koneksi, $_GET['id']);
$redirect = $_GET['redirect'];

if(isset($_SESSION['keranjang'])){
    // Loop untuk mengecek produk yang akan dihapus
    for($a = 0; $a < count($_SESSION['keranjang']); $a++){
        if($_SESSION['keranjang'][$a]['produk'] == $id_produk){
            // Dapatkan jumlah produk yang akan dikembalikan
            $jumlah_produk = $_SESSION['keranjang'][$a]['jumlah'];
            
            // Mengembalikan stok produk yang terhapus
            $query = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id = '$id_produk'");
            $data = mysqli_fetch_assoc($query);
            $stok_sebelumnya = $data['produk_jumlah'];

            // Tambahkan stok kembali
            $stok_baru = $stok_sebelumnya + $jumlah_produk;

            // Perbarui stok di database
            mysqli_query($koneksi, "UPDATE produk SET produk_jumlah = '$stok_baru' WHERE produk_id = '$id_produk'");

            // Hapus produk dari keranjang
            unset($_SESSION['keranjang'][$a]);

            // Urutkan ulang indeks array
            $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
            break; // Keluar setelah produk ditemukan dan dihapus
        }
    }
}

// Tentukan halaman redirect
if($redirect == "index"){
    $r = "index.php";
}elseif($redirect == "detail"){
    $r = "produk_detail.php?id=".$id_produk;
}elseif($redirect == "keranjang"){
    $r = "keranjang.php";
}

header("location:".$r);
?>