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

.btn-sm {
    width: 80%;
    height: 100%;
    margin-bottom: 1rem;
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
                            <li class="active"><a href="customer_pesanan.php">Pesanan Saya</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <div class="section">
        <div class="container">
            <div class="row">

                <?php 
			include 'customer_sidebar.php'; 
			?>

                <div id="main" class="col-md-9">

                    <h4>PESANAN</h4>

                    <div id="store">
                        <div class="row">

                            <div class="col-lg-12">

                                <?php 
							if(isset($_GET['alert'])){
								if($_GET['alert'] == "gagal"){
									echo "<div class='alert alert-danger'>Gambar gagal diupload!</div>";
								}elseif($_GET['alert'] == "sukses"){
									echo "<div class='alert alert-success'>Pesanan berhasil dibuat, silahkan melakukan pembayaran!</div>";
								}elseif($_GET['alert'] == "upload"){
									echo "<div class='alert alert-success'>Konfirmasi pembayaran berhasil tersimpan, silahkan menunggu status dari admin!</div>";
								}
							}
							?>

                                <small class="text-muted">
                                    Semua data pesanan / invoice anda.
                                </small>

                                <br />
                                <br />


                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>No.Invoice</th>
                                                <th>Tanggal</th>
                                                <th>Nama Penerima</th>
                                                <th>Total Bayar</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">OPSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
										$id = $_SESSION['customer_id'];
										$invoice = mysqli_query($koneksi,"select * from invoice where invoice_customer='$id' order by invoice_id desc");
										while($i = mysqli_fetch_array($invoice)){
											?>
                                            <tr>
                                                <td><?php echo $i['invoice_id'] ?></td>
                                                <td>INVOICE-00<?php echo $i['invoice_id'] ?></td>
                                                <td><?php echo $i['invoice_tanggal'] ?></td>
                                                <td><?php echo $i['invoice_nama'] ?></td>
                                                <td><?php echo "Rp. ".number_format($i['invoice_total_bayar'])." ,-" ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
													if($i['invoice_status'] == 0){
														echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
													}elseif($i['invoice_status'] == 1){
														echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
													}elseif($i['invoice_status'] == 2){
														echo "<span class='label label-danger'>Ditolak</span>";
													}elseif($i['invoice_status'] == 3){
														echo "<span class='label label-primary'>Dikonfirmasi & Sedang Diproses</span>";
													}elseif($i['invoice_status'] == 4){
														echo "<span class='label label-warning'>Dikirim</span>";
													}elseif($i['invoice_status'] == 5){
														echo "<span class='label label-success'>Selesai</span>";
													}
													?>
                                                </td>
                                                <td class="text-center">

                                                    <!-- midtrans -->


                                                    <button id="pay-now" class='btn btn-sm btn-success'
                                                        data-invoice-id="<?php echo $i['invoice_id']; ?>"><i
                                                            class="fa fa-money"></i> Bayar
                                                        Sekarang</button>



                                                    <a class='btn btn-sm btn-success'
                                                        href="customer_invoice.php?id=<?php echo $i['invoice_id']; ?>"><i
                                                            class="fa fa-print"></i> Invoice</a>
                                                </td>
                                            </tr>
                                            <?php 
										}
										?>
                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->
    <!-- Di bagian bawah body atau sebelum penutupan tag </body> di halaman customer_pesanan.php -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>

    <script>
    document.getElementById('pay-now').onclick = function() {
        var invoiceId = this.getAttribute('data-invoice-id');
        console.log('Invoice ID:', invoiceId); // Tambahkan ini untuk memeriksa ID

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_snap_token.php?id=" + invoiceId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response); // Tambahkan ini untuk melihat respons dari server

                if (response.status == 'success') {
                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            alert("Pembayaran berhasil!");
                            console.log(result);
                        },
                        onPending: function(result) {
                            alert("Pembayaran tertunda.");
                            console.log(result);
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal.");
                            console.log(result);
                        }
                    });
                } else {
                    alert("Gagal mendapatkan Snap Token.");
                }
            }
        };
        xhr.send();
    };
    </script>


    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>

</body>

</html>