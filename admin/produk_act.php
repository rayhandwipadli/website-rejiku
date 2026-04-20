<?php 
include '../koneksi.php';

$nama  = $_POST['nama'];
$kategori = $_POST['kategori'];
$harga = $_POST['harga'];
$keterangan = $_POST['keterangan'];
$berat = $_POST['berat'];
$jumlah = $_POST['jumlah'];
$ukuran1 = $_POST['ukuran1'];
$ukuran2 = $_POST['ukuran2'];
$ukuran3 = $_POST['ukuran3'];

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');

// Upload Foto 1
$filename1 = $_FILES['foto1']['name'];
if($filename1 != ""){
    $ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
    if(in_array($ext1, $allowed)) {
        move_uploaded_file($_FILES['foto1']['tmp_name'], '../gambar/produk/'.$rand.'_'.$filename1);
        $foto1 = $rand.'_'.$filename1;
    }
}

// Upload Foto 2
$filename2 = $_FILES['foto2']['name'];
if($filename2 != ""){
    $ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
    if(in_array($ext2, $allowed)) {
        move_uploaded_file($_FILES['foto2']['tmp_name'], '../gambar/produk/'.$rand.'_'.$filename2);
        $foto2 = $rand.'_'.$filename2;
    }
}

// Upload Foto 3
$filename3 = $_FILES['foto3']['name'];
if($filename3 != ""){
    $ext3 = pathinfo($filename3, PATHINFO_EXTENSION);
    if(in_array($ext3, $allowed)) {
        move_uploaded_file($_FILES['foto3']['tmp_name'], '../gambar/produk/'.$rand.'_'.$filename3);
        $foto3 = $rand.'_'.$filename3;
    }
}

// Query untuk menyimpan data produk ke database
mysqli_query($koneksi, "INSERT INTO produk (produk_nama, produk_kategori, produk_harga, produk_keterangan, produk_berat, produk_jumlah, produk_ukuran1, produk_ukuran2, produk_ukuran3, produk_foto1, produk_foto2, produk_foto3) VALUES ('$nama', '$kategori', '$harga', '$keterangan', '$berat', '$jumlah', '$ukuran1', '$ukuran2', '$ukuran3', '$foto1', '$foto2', '$foto3')");

header("location:produk.php");
?>