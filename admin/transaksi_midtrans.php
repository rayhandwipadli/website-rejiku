<?php
session_start();
require_once '../koneksi.php';

// Ambil kata kunci pencarian dari form
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Modifikasi query SQL untuk pencarian
$query = "SELECT * FROM invoice_midtrans WHERE order_id LIKE '%$search%' OR status_pembayaran LIKE '%$search%' ORDER BY payment_time DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran</title>
    <!-- Tambahkan Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Status Pembayaran Midtrans</h2>

        <!-- Form Pencarian -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                    placeholder="Cari berdasarkan Order ID atau Status Pembayaran"
                    value="<?= htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Tombol Kembali -->
        <a href="transaksi.php" class="btn btn-secondary mb-3">Kembali</a>

        <!-- Tabel Responsif -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Status Pembayaran</th>
                        <th>Waktu Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_id']); ?></td>
                        <td><?= ucfirst(htmlspecialchars($row['status_pembayaran'])); ?></td>
                        <td><?= htmlspecialchars($row['payment_time']); ?></td>
                        <td><?= strtoupper(htmlspecialchars($row['payment_type'])); ?></td>
                        <td>Rp <?= number_format($row['gross_amount'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>