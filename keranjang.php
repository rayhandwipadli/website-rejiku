<?php
// Pastikan Anda meng-include file koneksi database terlebih dahulu
include 'koneksi.php'; 

// head section
include 'head-new.php'; 
?>

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 0 !important;
    background-color: #000;
}

.btn {
    background: orange;
    color: white;
}

.btn:hover {
    background: orange;
    color: white;
}
</style>

<body class="js">

    <?php include 'header-new.php'; ?>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index.php">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="keranjang.php">Keranjang</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <form method="post" action="keranjang_update.php">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php 
                        if(isset($_GET['alert'])){
                            if($_GET['alert'] == "keranjang_kosong"){
                                echo "<div class='alert alert-danger text-center'>Tidak bisa checkout, karena keranjang belanja masih kosong. <br/> Silahkan belanja terlebih dulu.</div>";
                            }
                        }

                        if(isset($_SESSION['keranjang'])){

                            $jumlah_isi_keranjang = count($_SESSION['keranjang']);

                            if($jumlah_isi_keranjang != 0){
                        ?>
                        <!-- Shopping Summery -->
                        <table class="table shopping-summery">
                            <thead>
                                <tr class="main-hading">
                                    <th>GAMBAR</th>
                                    <th></th>
                                    <th class="text-center">HARGA</th>
                                    <th class="text-center">JUMLAH</th>
                                    <th class="text-center">TOTAL HARGA</th>
                                    <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jumlah_total = 0;
                                $total = 0;
                                for($a = 0; $a < $jumlah_isi_keranjang; $a++){
                                    $id_produk = $_SESSION['keranjang'][$a]['produk'];
                                    $jml = $_SESSION['keranjang'][$a]['jumlah'];

                                    // Query untuk mendapatkan data produk
                                    $isi = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
                                    $i = mysqli_fetch_assoc($isi);

                                    // Hitung total harga
                                    $total += $i['produk_harga'] * $jml;
                                    $jumlah_total += $total;
                                ?>
                                <tr>
                                    <?php if($i['produk_foto1'] == ""){ ?>
                                    <td class="image" data-title="No"><img src="gambar/sistem/produk.png" alt="#"></td>
                                    <?php } else { ?>
                                    <td class="image" data-title="No"><img
                                            src="gambar/produk/<?php echo $i['produk_foto1']; ?>" alt="#"></td>
                                    <?php } ?>
                                    <td class="product-des" data-title="Description">
                                        <p class="product-name"><a href="#"><?php echo $i['produk_nama']; ?></a></p>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <span><?php echo "Rp. ".number_format($i['produk_harga']) . " ,-"; ?></span>
                                    </td>
                                    <td class="qty" data-title="Qty">
                                        <input class="harga" id="harga_<?php echo $i['produk_id']; ?>" type="hidden"
                                            value="<?php echo $i['produk_harga']; ?>">
                                        <input name="produk[]" value="<?php echo $i['produk_id']; ?>" type="hidden">
                                        <input class="input jumlah input-number" name="jumlah[]" data-min="1"
                                            data-max="100" id="jumlah_<?php echo $i['produk_id']; ?>" type="number"
                                            value="<?php echo $_SESSION['keranjang'][$a]['jumlah']; ?>" min="1">
                                    </td>
                                    <td class="total-amount" data-title="Total">
                                        <span><?php echo "Rp. ".number_format($total) . " ,-"; ?></span>
                                    </td>
                                    <td class="action" data-title="Remove"><a
                                            href="keranjang_hapus.php?id=<?php echo $i['produk_id']; ?>&redirect=keranjang"><i
                                                class="ti-trash remove-icon"></i></a></td>
                                </tr>
                                <?php
                                    $total = 0; // Reset total untuk produk berikutnya
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            } else {
                                echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='index.php'>belanja</a> !</center></h3><br><br><br>";
                            }
                        } else {
                            echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='index.php'>belanja</a> !</center></h3><br><br><br>";
                        }
                        ?>
                    </div>
                </div>

                <?php
                if(isset($_SESSION['keranjang'])){
                    $jumlah_isi_keranjang = count($_SESSION['keranjang']);
                    if($jumlah_isi_keranjang != 0){
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="total-amount">
                            <div class="row">
                                <div class="col-lg-8 col-md-5 col-12"></div>
                                <div class="col-lg-4 col-md-7 col-12">
                                    <div class="right">
                                        <ul>
                                            <li>Total
                                                Harga<span><?php echo "Rp. ".number_format($jumlah_total) . " ,-"; ?></span>
                                            </li>
                                        </ul>
                                        <div class="button5 mb-3">
                                            <input type="submit" class="main-btn btn" value="Ubah Keranjang">
                                            <a href="checkout.php" class="btn">Beli Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
        </form>
    </div>
    <!-- End Shopping Cart -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-truck"></i>
                        <h4>Pengiriman Cepat</h4>
                        <p>Barang sampai dengan aman</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-package"></i>
                        <h4>Packing Berkualitas</h4>
                        <p>Dijamin barang sesuai kondisi awal</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-image"></i>
                        <h4>Kualitas Sesuai</h4>
                        <p>100% kualitas seperti gambar</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-money"></i>
                        <h4>Harga Terbaik</h4>
                        <p>Harga yang bersahabat</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- End Footer Area -->

    <!-- foot section -->
    <?php include 'foot-new.php'; ?>
</body>

</html>