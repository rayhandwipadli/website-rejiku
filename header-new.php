<?php
include 'koneksi.php';

session_start();

$file = basename($_SERVER['PHP_SELF']);

if(!isset($_SESSION['customer_status'])){

	// halaman yg dilindungi jika customer belum login
	$lindungi = array('customer.php','customer_logout.php');

	// periksa halaman, jika belum login ke halaman di atas, maka alihkan halaman
	if(in_array($file, $lindungi)){
		header("location:index.php");
	}

	if($file == "checkout.php"){
		header("location:masuk.php?alert=login-dulu");
	}

}else{

	// halaman yg tidak boleh diakses jika customer sudah login
	$lindungi = array('masuk.php','daftar.php');

	// periksa halaman, jika sudah dan mengakses halaman di atas, maka alihkan halaman
	if(in_array($file, $lindungi)){
		header("location:customer.php");
	}

}



if($file == "checkout.php"){


	if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0){

		header("location:keranjang.php?alert=keranjang_kosong");

	}
}

?>
<style>
html {
    scroll-behavior: smooth;
}
</style>

<header class="header shop">
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php"><img src="frontend/img/logorejikuhead.png" alt="logo"
                                style="max-width: 70%;"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <!-- <select>
									<option selected="selected">All Category</option>
									<option>watch</option>
									<option>mobile</option>
									<option>kid’s item</option>
								</select> -->
                            <form action="produk.php" method="get">
                                <input name="cari" placeholder="Masukan Pencarian ..." type="cari">
                                <button type="submit" class="btnn"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->

                        <?php 
							if(isset($_SESSION['customer_status'])){
								$id_customer = $_SESSION['customer_id'];
								$customer = mysqli_query($koneksi,"select * from customer where customer_id='$id_customer'");
								$c = mysqli_fetch_assoc($customer);
							?>
                        <div class="sinlge-bar">
                            <a href="customer.php" class="single-icon"><i class="fa fa-user-circle-o"
                                    aria-hidden="true"></i></a>
                        </div>
                        <?php
								}
							?>
                        <div class="sinlge-bar shopping">
                            <?php 
							if(isset($_SESSION['keranjang'])){
								$jumlah_isi_keranjang = count($_SESSION['keranjang']);
							}else{
								$jumlah_isi_keranjang = 0;
							}
							?>

                            <a href="#" class="single-icon"><i class="ti-shopping-cart"></i> <span
                                    class="total-count"><?php echo $jumlah_isi_keranjang; ?></span></a>
                            <!-- Shopping Item -->
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span><?php echo $jumlah_isi_keranjang; ?> Barang</span>
                                    <a href="keranjang.php">Lihat Keranjang</a>
                                </div>
                                <ul class="shopping-list">
                                    <?php 
										$total_berat = 0;
										if(isset($_SESSION['keranjang'])){

											$jumlah_isi_keranjang = count($_SESSION['keranjang']);

											if($jumlah_isi_keranjang != 0){
												// cek apakah produk sudah ada dalam keranjang
												for($a = 0; $a < $jumlah_isi_keranjang; $a++){
													$id_produk = $_SESSION['keranjang'][$a]['produk'];
													$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
													$i = mysqli_fetch_assoc($isi);

													$total_berat += $i['produk_berat'];
													?>
                                    <li>
                                        <a href="keranjang_hapus.php?id=<?php echo $i['produk_id']; ?>&redirect=keranjang"
                                            class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                        <?php if($i['produk_foto1'] == ""){ ?>
                                        <img src="gambar/sistem/produk.png">
                                        <a class="cart-img" href="#"><img src="gambar/sistem/produk.png" alt="#"></a>
                                        <?php }else{ ?>
                                        <a class="cart-img" href="#"><img
                                                src="gambar/produk/<?php echo $i['produk_foto1'] ?>" alt="#"></a>
                                        <?php } ?>
                                        <h4><a href="#<?php echo $i['produk_id'] ?>"><?php echo $i['produk_nama'] ?></a>
                                        </h4>
                                        <p class="quantity"><span
                                                class="amount"><?php echo "Rp. ".number_format($i['produk_harga']) . " ,-"; ?></span>
                                        </p>
                                    </li>

                                    <?php

												}
											}else{
												echo "<center>Keranjang Masih Kosong.</center>";
											}
											

										}else{
											echo "<center>Keranjang Masih Kosong.</center>";
										}
										?>
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <?php 
										$total = 0;
										if(isset($_SESSION['keranjang'])){
											$jumlah_isi_keranjang = count($_SESSION['keranjang']);
											for($a = 0; $a < $jumlah_isi_keranjang; $a++){
												$id_produk = $_SESSION['keranjang'][$a]['produk'];
												$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
												$i = mysqli_fetch_assoc($isi);
												$total += $i['produk_harga'];
											}
										}
										?>
                                        <span>Total</span>
                                        <span
                                            class="total-amount"><?php echo "Rp. ".number_format($total)." ,-"; ?></span>
                                    </div>
                                    <a href="checkout.php" class="btn animate">Checkout</a>
                                </div>
                            </div>
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="all-category category-nav show-on-click">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <!-- dropdown -->
                                            <li>
                                                <h3 class="cat-heading"><i class="fa fa-bars"></i>KATEGORI</h3></a>
                                                <ul class="dropdown main-category category-list">
                                                    <?php 
                                                    $data = mysqli_query($koneksi,"SELECT * FROM kategori");
                                                    while($d = mysqli_fetch_array($data)){
                                                        ?>
                                                    <li><a
                                                            href="produk_kategori.php?id=<?php echo $d['kategori_id']; ?>"><?php echo $d['kategori_nama']; ?></a>
                                                    </li>
                                                    <?php 
                                                        }
                                                        ?>
                                                    <li><a href="index.php"
                                                            style="color: white; background: #333333">Tampilkan
                                                            Semua</a></li>
                                                </ul>
                                            </li>
                                            <!--dropdown stop-->
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li><a href="index.php">Beranda</a></li>
                                            <li><a href="produk.php">Produk</a></li>
                                            <li><a href="about.php">Tentang Kami</a></li>
                                            <li><a href="keranjang.php">Keranjang</a></li>
                                            <li><a href="#">Masuk<i class="ti-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><a href="masuk.php">Masuk</a></li>
                                                    <li><a href="daftar.php">Daftar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>