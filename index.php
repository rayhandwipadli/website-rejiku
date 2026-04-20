<!-- head  -->
<?php include 'head-new.php'; ?>

<style>
/* chatbot stop*/
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 0 !important;
    background-color: #000;
}

html {
    scroll-behavior: smooth;
}

.btn {
    background: orange;
    color: white;
}

.btn:hover {
    background: orange;
    color: white;
}

.product-img {
    position: relative;
    overflow: hidden;
}

.product-img img {
    display: block;
    width: 100%;
    transition: transform 0.3s ease;
}

.product-img::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.product-img:hover::after {
    opacity: 0.3;
    cursor: default;
}
</style>

<body class="js">


    <!-- Header -->
    <?php include 'header-new.php'; ?>
    <!--/ End Header -->

    <!-- Slider Area -->
    <div id="ImageCarouselCSS" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#ImageCarouselCSS" data-slide-to="0" class="active"></li>
            <li data-target="#ImageCarouselCSS" data-slide-to="1"></li>
            <li data-target="#ImageCarouselCSS" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="gambar/banner/banner1.jpeg" class="d-block w-100" alt="tiniest puppy">
            </div>
            <div class="carousel-item">
                <img src="gambar/banner/banner2.jpeg" class="d-block w-100" alt="tiny puppy">
            </div>
            <div class="carousel-item">
                <img src="gambar/banner/banner3.jpeg" class="d-block w-100" alt="least tiny but still tiny puppy">
            </div>
        </div>
    </div>
    <!--/ End Slider Area -->

    <!-- Start Small Banner  -->
    <section class="small-banner section">
        <div class="container-fluid">
            <div class="row">
                <!-- Single Banner  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-banner">
                        <img src="gambar/banner/banner4.jpeg" alt="banner rekomendasi outfit">
                    </div>
                </div>
                <!-- /End Single Banner  -->
                <!-- Single Banner  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-banner">
                        <img src="gambar/banner/banner5.jpeg" alt="banner rekomandasi outfit">
                    </div>
                </div>
                <!-- /End Single Banner  -->
                <!-- Single Banner  -->
                <div class="col-lg-4 col-12">
                    <div class="single-banner tab-height">
                        <img src="gambar/banner/banner6.jpeg" alt="banner rekomandasi outfit">
                        <div class="content">
                        </div>
                    </div>
                </div>
                <!-- /End Single Banner  -->
            </div>
        </div>
    </section>
    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 id="scrollspy">Produk Terbaru</h2>
                        <div class="nav-main">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="tab-content" id="myTabContent">
                            <!-- Start Single Tab -->
                            <div class="tab-pane fade show active" id="man" role="tabpanel">
                                <div class="tab-single">
                                    <div class="row">
                                        <?php
										$halaman = 12;
										$page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
										$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
										// $result = mysqli_query($koneksi, "SELECT * FROM produk");

										if(isset($_GET['urutan']) && $_GET['urutan'] == "harga"){
											if(isset($_GET['cari'])){
												$cari = $_GET['cari'];
												$result = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_harga asc");
											}else{
												$result = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_harga asc");
											}
										}else{

											if(isset($_GET['cari'])){
												$cari = $_GET['cari'];
												$result = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_id desc");
											}else{
												$result = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_id desc");
											}

										}    
										
										$total = mysqli_num_rows($result);
										$pages = ceil($total/$halaman);  
										if(isset($_GET['urutan']) && $_GET['urutan'] == "harga"){
											if(isset($_GET['cari'])){
												$cari = $_GET['cari'];
												$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_harga asc LIMIT $mulai, $halaman");
											}else{
												$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_harga asc LIMIT $mulai, $halaman");
											}
										}else{

											if(isset($_GET['cari'])){
												$cari = $_GET['cari'];
												$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_id desc LIMIT $mulai, $halaman");
											}else{
												$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_id desc LIMIT $mulai, $halaman");
											}

										}          
										$no =$mulai+1;

										while($d = mysqli_fetch_array($data)){
											?>
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                            <div class="single-product">
                                                <div class="product-img">
                                                    <a data-toggle="modal"
                                                        data-target="#exampleModal-<?php echo $d['produk_id']; ?>">
                                                        <?php if($d['produk_foto1'] == ""){ ?>
                                                        <img class="default-img"
                                                            src="https://via.placeholder.com/550x750" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <img class="hover-img" src="https://via.placeholder.com/550x750"
                                                            alt="#" style="max-height: 60vh!important;">
                                                        <?php }else{ ?>
                                                        <img class="default-img"
                                                            src="gambar/produk/<?php echo $d['produk_foto1'] ?>" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <img class="hover-img"
                                                            src="gambar/produk/<?php echo $d['produk_foto1'] ?>" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <?php } ?>
                                                    </a>
                                                    <div class="button-head">
                                                        <div class="product-action">
                                                            <!-- Modal -->
                                                            <?php 
																	$id_produk = mysqli_real_escape_string($koneksi, $d['produk_id']);
																	$dataProductDetail = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id_produk'");
																	while($dp=mysqli_fetch_array($dataProductDetail)){
																?>
                                                            <div class="modal fade"
                                                                id="exampleModal-<?php echo $dp['produk_id']; ?>"
                                                                tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    class="ti-close"
                                                                                    aria-hidden="true"></span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row no-gutters">
                                                                                <div
                                                                                    class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                                                    <!-- Product Slider -->
                                                                                    <div class="product-gallery">
                                                                                        <div
                                                                                            class="quickview-slider-active">
                                                                                            <div class="single-slider">
                                                                                                <?php if($dp['produk_foto1'] == ""){ ?>
                                                                                                <img
                                                                                                    src="gambar/sistem/produk.png">
                                                                                                <?php }else{ ?>
                                                                                                <img
                                                                                                    src="gambar/produk/<?php echo $dp['produk_foto1'] ?>">
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                            <div class="single-slider">
                                                                                                <?php if($dp['produk_foto2'] == ""){ ?>
                                                                                                <img
                                                                                                    src="gambar/sistem/produk.png">
                                                                                                <?php }else{ ?>
                                                                                                <img
                                                                                                    src="gambar/produk/<?php echo $dp['produk_foto2'] ?>">
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                            <div class="single-slider">
                                                                                                <?php if($dp['produk_foto3'] == ""){ ?>
                                                                                                <img
                                                                                                    src="gambar/sistem/produk.png">
                                                                                                <?php }else{ ?>
                                                                                                <img
                                                                                                    src="gambar/produk/<?php echo $dp['produk_foto3'] ?>">
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                            <div class="single-slider">
                                                                                                <?php if($dp['produk_foto2'] == ""){ ?>
                                                                                                <img
                                                                                                    src="gambar/sistem/produk.png">
                                                                                                <?php }else{ ?>
                                                                                                <img
                                                                                                    src="gambar/produk/<?php echo $dp['produk_foto2'] ?>">
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- End Product slider -->
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="quickview-content">
                                                                                        <h2><?php echo $dp['kategori_nama']; ?>
                                                                                        </h2>

                                                                                        <h2><?php echo $dp['produk_nama']; ?>
                                                                                        </h2>
                                                                                        <div
                                                                                            class="quickview-ratting-review">

                                                                                            <div
                                                                                                class="quickview-paragraph">
                                                                                                <span>
                                                                                                    <?php 
            if($dp['produk_jumlah'] == 0){
                echo "Kosong";
            } else {
                echo "Tersedia: " . $dp['produk_jumlah'] . " buah";
            } 
        ?>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <h3><?php echo "Rp. ".number_format($dp['produk_harga']).",-"; ?>
                                                                                            <?php if($dp['produk_jumlah'] == 0){?>
                                                                                            <del
                                                                                                class="product-old-price">Kosong</del>
                                                                                            <?php } ?>
                                                                                        </h3>
                                                                                        <div
                                                                                            class="quickview-peragraph">
                                                                                            <p>
                                                                                                <?php echo $dp['produk_keterangan']; ?>
                                                                                            </p>
                                                                                        </div>

                                                                                        <!-- ukuran tambahan -->
                                                                                        <!-- Form untuk menambah produk ke keranjang -->
                                                                                        <form method="post"
                                                                                            action="keranjang_masukan.php">
                                                                                            <input type="hidden"
                                                                                                name="produk_id"
                                                                                                value="<?php echo $dp['produk_id']; ?>">
                                                                                            <div class="size">
                                                                                                <div class="row">
                                                                                                    <div
                                                                                                        class="col-lg-6 col-12">
                                                                                                        <h5
                                                                                                            class="title">
                                                                                                            Ukuran</h5>
                                                                                                        <select
                                                                                                            name="ukuran">
                                                                                                            <option
                                                                                                                value="<?php echo $dp['produk_ukuran1']; ?>">
                                                                                                                <?php echo $dp['produk_ukuran1']; ?>
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="<?php echo $dp['produk_ukuran2']; ?>">
                                                                                                                <?php echo $dp['produk_ukuran2']; ?>
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="<?php echo $dp['produk_ukuran3']; ?>">
                                                                                                                <?php echo $dp['produk_ukuran3']; ?>
                                                                                                            </option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </form>


                                                                                        <!-- ukuran tambahan stop-->

                                                                                        <div class="add-to-cart">
                                                                                            <a href="keranjang_masukkan.php?id=<?php echo $dp['produk_id']; ?>&redirect=detail"
                                                                                                class="btn"
                                                                                                style="background: orange;color:white;">Tambah
                                                                                                Ke Keranjang</a>
                                                                                        </div>
                                                                                        <div class="default-social">
                                                                                            <h4 class="share-now">
                                                                                                Bagikan:
                                                                                            </h4>
                                                                                            <ul>
                                                                                                <li><a class="facebook"
                                                                                                        href="#"><i
                                                                                                            class="fa-brands fa-facebook"></i></a>
                                                                                                </li>
                                                                                                <li><a class="instagram"
                                                                                                        href="#"><i
                                                                                                            class="fa-brands fa-instagram"></i></a>
                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php 
																	}
																?>
                                                            <!-- Modal end -->
                                                            <!-- <a title="Quick View" href="produk_detail.php?id=<?php echo $d['produk_id'] ?>"><i class=" ti-eye"></i><span>Quick Shop</span></a> -->
                                                        </div>
                                                        <!-- <div class="product-action-2">
																<a title="Add to cart" href="keranjang_masukkan.php?id=<?php echo $d['produk_id']; ?>&redirect=index">Add to cart</a>
															</div> -->
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <h3><a data-toggle="modal"
                                                            data-target="#exampleModal-<?php echo $d['produk_id']; ?>"
                                                            title="" href="#"><?php echo $d['produk_nama'] ?></a></h3>
                                                    <div class="product-price">
                                                        <!-- <span>$29.00</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
											}
										?>

                                        <?php 
											if($total == 0){
												?>
                                        <center>
                                            <h4>Belum ada produk.</h4>
                                        </center>
                                        <?php
											}
										?>

                                    </div>
                                </div>
                            </div>

                            <!--/ End Single Tab -->
                            <!-- Start Single Tab -->
                            <div class="tab-pane fade" id="kids" role="tabpanel">
                                <div class="tab-single">
                                    <div class="row">
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
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                            <div class="single-product">
                                                <div class="product-img">
                                                    <a href="#">
                                                        <?php if($i['produk_foto1'] == ""){ ?>
                                                        <img class="default-img" src="gambar/sistem/produk.png" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <img class="hover-img" src="gambar/sistem/produk.png" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <?php }else{ ?>
                                                        <img class="default-img"
                                                            src="gambar/sistem/produk.pnggambar/produk/<?php echo $i['produk_foto1'] ?>"
                                                            alt="#" style="max-height: 31vh!important;">
                                                        <img class="hover-img"
                                                            src="gambar/produk/<?php echo $i['produk_foto1'] ?>" alt="#"
                                                            style="max-height: 31vh!important;">
                                                        <?php } ?>
                                                    </a>
                                                    <div class="button-head">
                                                        <div class="product-action">
                                                            <a data-toggle="modal" data-target="#exampleModal"
                                                                title="Quick View" href="#"><i
                                                                    class=" ti-eye"></i><span>Quick
                                                                    Shop</span></a>
                                                            <a title="Wishlist" href="#"><i
                                                                    class=" ti-heart "></i><span>Add to
                                                                    Wishlist</span></a>
                                                            <a title="Compare" href="#"><i
                                                                    class="ti-bar-chart-alt"></i><span>Add to
                                                                    Compare</span></a>
                                                        </div>
                                                        <div class="product-action-2">
                                                            <a title="Tambah Ke Keranjang" href="#">Tambah Ke
                                                                Keranjang</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <h3><a href="product-details.html">Women Hot Collection</a>
                                                    </h3>
                                                    <div class="product-price">
                                                        <!-- <span>$29.00</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

												}
											}else{
												echo "<center>Keranjang Masih Kosong.</center>";
											}
											

										}else{
											echo "<center>Keranjang Masih Kosong.</center>";
										}
										?>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Single Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->

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



    <?php include 'inc_chatbot.php'; ?>
    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    < script >
        AOS.init();
    </script>
    </script>
</body>

</html>