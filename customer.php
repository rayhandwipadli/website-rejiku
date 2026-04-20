<!-- head  -->
<?php include 'head-new.php'; ?>

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 0!important;
    background-color: #000;
}
.btn{
	background: orange;
	color: white;
}
.btn:hover{
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
				
				<h4>DASHBOARD</h4>
				<hr>

				<div id="store">

					<div class="row">

						<div class="col-lg-12">
							
							<label><b>Halo, Selamat Datang!</b> </label>

							<table class="table table-bordered">
								<tbody>
									<?php 
									$id = $_SESSION['customer_id'];
									$customer = mysqli_query($koneksi,"select * from customer where customer_id='$id'");
									while($i = mysqli_fetch_array($customer)){
										?>
										<tr>
											<th width="20%">Nama</th>	
											<td><?php echo $i['customer_nama'] ?></td>
										</tr>
										<tr>
											<th width="20%">Email</th>	
											<td><?php echo $i['customer_email'] ?></td>
										</tr>
										<tr>
											<th>HP</th>	
											<td><?php echo $i['customer_hp'] ?></td>
										</tr>
										<tr>
											<th>Alamat</th>	
											<td><?php echo $i['customer_alamat'] ?></td>
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
	<!-- End Product Area -->
	
	<!-- Start Footer Area -->
	<?php include 'footer-new.php'; ?>
	<!-- /End Footer Area -->
 
	<!-- foot  -->
	<?php include 'foot-new.php'; ?>
</body>
</html>