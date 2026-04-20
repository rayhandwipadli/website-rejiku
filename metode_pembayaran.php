<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Customer</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        /* Vertikal */
        justify-content: center;
        /* Horizontal */
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Pesanan Anda</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>NO</th>
                        <th>No. Invoice</th>
                        <th>Tanggal</th>
                        <th>Nama Penerima</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <tr>
                        <td>51</td>
                        <td>INVOICE-0051</td>
                        <td>2024-12-25</td>
                        <td>pecahan</td>
                        <td>Rp. 398,500 ,-</td>
                        <td>Menunggu Pembayaran</td>
                        <td>
                            <!-- Tombol Konfirmasi Pembayaran -->
                            <button class="btn btn-warning btn-sm mb-2 w-100">Konfirmasi Pembayaran</button>
                            <!-- Tombol Bayar Sekarang -->
                            <a href="metode_pembayaran.php?id=<?php echo $i['invoice_id']; ?>"
                                class='btn btn-sm btn-success' data-bs-toggle="modal"
                                data-bs-target="#paymentModal">Bayar Sekarang</a>
                            <!-- Tombol Invoice -->
                            <button class="btn btn-info btn-sm w-100">Invoice</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Pilihan Pembayaran -->
    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Silakan pilih metode pembayaran:
                    <br /><br />
                    <a href="metode_pembayaran.php?metode=manual" class="btn btn-warning">Pembayaran Manual</a>
                    <a href="metode_pembayaran.php?metode=otomatis" class="btn btn-primary">Pembayaran Otomatis</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>