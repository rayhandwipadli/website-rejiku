<!-- head  -->
<?php include 'head-new.php'; ?>

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

    <div class="section">
        <div class="container">
            <div class="row">

                <?php 
			include 'customer_sidebar.php'; 
			?>

                <div id="main" class="col-md-9">

                    <h4>GANTI PASSWORD</h4>

                    <div id="store">
                        <div class="row">

                            <div class="col-lg-12">
                                <?php 
							if(isset($_GET['alert'])){
								if($_GET['alert'] == "sukses"){
									echo "<div class='alert alert-success'>Password anda berhasil diganti!</div>";
								}
							}
							?>

                                <form action="customer_password_act.php" method="post">
                                    <div class="form-group">
                                        <label for="">Masukkan Password Baru</label> <br>
                                        <input type="password" class="input form-control" required="required"
                                            name="password" placeholder="Masukkan password .." min="5">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="primary-btn btn btn-primary" value="Ganti Password">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->

    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>
</body>

</html>