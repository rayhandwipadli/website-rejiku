<html>

<body>
    <h1>Riwayat Pembayaran</h1>
    <?php
    // Kode yang Anda berikan untuk menampilkan data
    include '../koneksi.php';

    $query = "SELECT * FROM invoice_midtrans WHERE status_pembayaran IS NOT NULL ORDER BY payment_time DESC";
    $result = mysqli_query($koneksi, $query);

    echo "<table border='1'>";
    echo "<tr><th>Order ID</th><th>Status Pembayaran</th><th>Payment Type</th><th>Gross Amount</th><th>Payment Time</th></tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['order_id'] . "</td>";
        echo "<td>" . $row['status_pembayaran'] . "</td>";
        echo "<td>" . $row['payment_type'] . "</td>";
        echo "<td>" . $row['gross_amount'] . "</td>";
        echo "<td>" . $row['payment_time'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>

</html>