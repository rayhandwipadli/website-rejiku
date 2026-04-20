<?php 
include 'koneksi.php';

$id_produk = $_GET['id'];
$redirect = $_GET['redirect'];

$data = mysqli_query($koneksi,"SELECT * FROM produk, kategori WHERE kategori_id = produk_kategori AND produk_id = '$id_produk'");
$d = mysqli_fetch_assoc($data);

session_start();

// Cek stok produk
if ($d['produk_jumlah'] > 0) {
    // Kurangi stok produk di database (mengurangi 1 karena produk baru dimasukkan ke keranjang)
    $stok_baru = $d['produk_jumlah'] - 1;
    mysqli_query($koneksi, "UPDATE produk SET produk_jumlah = '$stok_baru' WHERE produk_id = '$id_produk'");

    // Jika keranjang sudah ada
    if (isset($_SESSION['keranjang'])) {
        $jumlah_isi_keranjang = count($_SESSION['keranjang']);
        $sudah_ada = 0;

        // Cek apakah produk sudah ada dalam keranjang
        for ($a = 0; $a < $jumlah_isi_keranjang; $a++) {
            if ($_SESSION['keranjang'][$a]['produk'] == $id_produk) {
                $sudah_ada = 1;
            }
        }

        // Jika produk belum ada dalam keranjang, masukkan produk ke keranjang
        if ($sudah_ada == 0) {
            $_SESSION['keranjang'][$jumlah_isi_keranjang] = array(
                'produk' => $id_produk,
                'jumlah' => 1
            );
        }
    } else {
        // Jika keranjang belum ada, buat array baru dan masukkan produk
        $_SESSION['keranjang'][0] = array(
            'produk' => $id_produk,
            'jumlah' => 1
        );
    }

    // Tentukan redirect setelah produk ditambahkan
    if ($redirect == "index") {
        $r = "index.php";
    } elseif ($redirect == "detail") {
        $r = "index.php";  // Anda bisa menyesuaikan halaman detail produk jika perlu
    } elseif ($redirect == "keranjang") {
        $r = "keranjang.php";
    }

    // Redirect ke halaman yang sesuai
    header("location:".$r);
} else {
    // Jika stok produk tidak cukup, tampilkan pesan error atau redirect ke halaman lain
    echo "<script>alert('Stok tidak cukup!'); window.history.back();</script>";
}
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menampilkan notifikasi
    function showNotif(message) {
        var notif = document.createElement('div');
        notif.classList.add('notif-stok-kosong');
        notif.innerHTML =
            '<div class="notif-content"><span class="notif-icon">⚠️</span><span class="notif-message">' +
            message + '</span><button class="notif-close">&times;</button></div>';
        document.body.appendChild(notif);

        // Menampilkan notifikasi
        notif.style.display = 'block';

        // Menutup notifikasi setelah 5 detik
        setTimeout(function() {
            notif.style.display = 'none';
        }, 5000);

        // Menutup notifikasi jika tombol close diklik
        document.querySelector('.notif-close').addEventListener('click', function() {
            notif.style.display = 'none';
        });
    }

    // Menampilkan notifikasi jika stok tidak cukup
    if (window.location.href.indexOf("stok_tidak_cukup") !== -1) {
        showNotif("Stok tidak cukup!");
    }
});
</script>