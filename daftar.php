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

.text-bold {
    font-weight: 700;
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
                            <li class="active"><a href="daftar.php">Daftar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Pendaftaran Pelanggan Baru</h3>
                        </div>

                        <?php 
                            if(isset($_GET['alert'])){
                                if($_GET['alert'] == "duplikat"){
                                    echo "<div class='alert alert-danger text-center'>Maaf email ini sudah digunakan, silahkan gunakan email yang lain.</div>";
                                }
                            }
                        ?>

                        <div class="row">
                            <div class="col-lg-6 mx-auto col-lg-offset-3">

                                <form action="daftar_act.php" method="post" onsubmit="return validateForm()">
                                    <div class="form-group">
                                        <label class="text-bold" for="">Nama Lengkap</label>
                                        <br>
                                        <input type="text" class="input form-control" required="required" name="nama"
                                            placeholder="Masukkan nama lengkap ..">
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold" for="">Email</label>
                                        <br>
                                        <input type="email" class="input form-control" required="required" name="email"
                                            placeholder="Masukkan email ..">
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold" for="">Nomor HP / Whatsapp</label>
                                        <br>
                                        <input type="tel" class="input form-control" required="required" name="hp"
                                            placeholder="Masukkan nomor HP/Whatsapp .." id="hp" pattern="^\d{1,13}$"
                                            maxlength="13">
                                        <small class="text-muted">Nomor HP Maksimal 13 Angka</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold" for="">Alamat Lengkap</label>
                                        <br>
                                        <input type="text" class="input form-control" required="required" name="alamat"
                                            placeholder="Masukkan alamat lengkap ..">
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold" for="">Password</label>
                                        <br>
                                        <input type="password" class="input form-control" required="required"
                                            name="password" placeholder="Masukkan password ..">
                                        <small class="text-muted">Password ini digunakan untuk login ke akun
                                            anda.</small>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="primary-btn btn-block btn btn-primary"
                                            value="Daftar">
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- End Product Area -->

    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>

    <!-- JavaScript Validation -->
    <script>
    function validateForm() {
        var phoneInput = document.getElementById('hp').value;
        if (phoneInput.length > 13) {
            alert('Nomor telepon tidak boleh lebih dari 13 angka.');
            return false;
        }
        return true;
    }

    // Validasi email
    if (!emailInput.includes('@gmail.com')) {
        alert('Email harus mengandung "@gmail.com".');
        return false;
    }

    return true;
    }
    </script>
</body>

</html>