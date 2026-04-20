<!-- head  -->
<?php include 'head-new.php'; 
ob_start();
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

    <!-- Header -->
    <?php include 'header-new.php'; ?>
    <!--/ End Header -->

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index.php">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="masuk.php">Masuk</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->


    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Login Pelanggan</h3>
                        </div>

                        <?php 
					if(isset($_GET['alert'])){
						if($_GET['alert'] == "terdaftar"){
							echo "<div class='alert alert-success text-center'>Selamat akun anda telah disimpan, silahkan login.</div>";
						}elseif($_GET['alert'] == "gagal"){
							echo "<div class='alert alert-danger text-center'>Email dan Password tidak sesuai, coba lagi.</div>";
						}elseif($_GET['alert'] == "login-dulu"){
							echo "<div class='alert alert-warning text-center'>Silahkan login terlebih dulu untuk membuat pesanan.</div>";
						}
					}
					?>


                        <div class="row mx-auto">
                            <div class="col-lg-6 mx-auto col-lg-offset-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="masuk_act.php" method="post">

                                            <div class="form-group">
                                                <label for=""><b>Email</b></label> <br>
                                                <input type="email" class="input form-control" required="required"
                                                    name="email" placeholder="Masukkan email ..">
                                            </div>

                                            <div class="form-group">
                                                <label for=""><b>Password</b></label> <br>
                                                <input type="password" class="input form-control" required="required"
                                                    name="password" placeholder="Masukkan password ..">
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" class="primary-btn btn btn-primary btn-block"
                                                    value="Login">
                                                <a href="daftar.php" class="main-btn btn-block text-center">Daftar</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
    <!-- End Product Area -->

    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>
</body>

</html>