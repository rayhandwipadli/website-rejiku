<?php include 'header.php'; ?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Pelanggan
            <small>Data Pelanggan</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Data Pelanggan</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <section class="col-lg-10 col-lg-offset-1">
                <div class="box box-dark">

                    <div class="box-header">
                        <h3 class="box-title">Pelanggan</h3>

                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-datatable">
                                <thead>
                                    <tr>
                                        <th width="1%">NO</th>
                                        <th>NAMA</th>
                                        <th>EMAIL</th>
                                        <th>HP</th>
                                        <th>ALAMAT</th>
                                        <th>OPSI</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                  include '../koneksi.php';
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM customer");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $d['customer_nama']; ?></td>
                                        <td><?php echo $d['customer_email']; ?></td>
                                        <td><?php echo $d['customer_hp']; ?></td>
                                        <td><?php echo $d['customer_alamat']; ?></td>

                                        <td>
                                            <a class="btn btn-danger btn-sm"
                                                href="customer_hapus_konfir.php?id=<?php echo $d['customer_id']; ?>"><i
                                                    class="fa fa-trash"></i></a>
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
            </section>
        </div>
    </section>

</div>
<?php include 'footer.php'; ?>