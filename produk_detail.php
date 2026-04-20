<?php include 'head-new.php'; ?>
<style>
.product-img img {
    width: 100%;
    border-radius: 10px;
}

.produk-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: flex-start;
    /* Biar di PC rata kiri */
}

.produk-item {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    flex: 1 1 100%;
    /* Default: di HP 1 card per baris */
    max-width: 100%;
    box-sizing: border-box;
}

.produk-item img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.text-orange {
    color: #ffa500;
}

.btn-orange {
    background-color: orange;
    color: white;
}


@media (min-width: 576px) {
    .produk-item {
        flex: 1 1 calc(50% - 15px);
        /* Tablet kecil: 2 kolom */
        max-width: calc(50% - 15px);
    }
}

@media (min-width: 992px) {
    .produk-item {
        flex: 1 1 calc(25% - 15px);
        /* Laptop/PC: 4 kolom */
        max-width: calc(25% - 15px);
    }
}
</style>
</head>

<body>
    <?php include 'header-new.php'; ?>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index.php">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="produk.php">Produk</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <div class="container mt-4">

        <?php 
$id_produk = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi,"SELECT * FROM produk, kategori WHERE kategori_id = produk_kategori AND produk_id = '$id_produk'");
while($d = mysqli_fetch_array($data)){
?>

        <div class="row">
            <div class="col-md-6">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="gambar/produk/<?php echo $d['produk_foto1'] ?: 'sistem/produk.png'; ?>"
                                class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="gambar/produk/<?php echo $d['produk_foto2'] ?: 'sistem/produk.png'; ?>"
                                class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="gambar/produk/<?php echo $d['produk_foto3'] ?: 'sistem/produk.png'; ?>"
                                class="d-block w-100">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <h2 class="text-orange mb-2"><?php echo $d['produk_nama']; ?></h2>
                <h4>Rp. <?php echo number_format($d['produk_harga']); ?></h4>

                <p><strong>Kategori:</strong> <?php echo $d['kategori_nama']; ?></p>
                <p><strong>Berat:</strong> <?php echo $d['produk_berat']; ?> gram</p>
                <p><strong>Jumlah Stok:</strong>
                    <?php echo ($d['produk_jumlah'] > 0) ? $d['produk_jumlah'] : '<span style="color:red;">Kosong</span>'; ?>
                </p>
                <a href="keranjang_masukkan.php?id=<?php echo $d['produk_id']; ?>&redirect=detail"
                    class="btn btn-orange mt-4">Masukkan Keranjang</a>
            </div>
        </div>
        <div class="mt-4">
            <h3>Deskripsi Produk</h3>
            <p><?php echo $d['produk_keterangan']; ?></p>
        </div>
        <?php } ?>

        <?php
        $produk_id = $_GET['id'];
        $api_url = "http://localhost:5000/rekomendasi?produk_id=" . $produk_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $rekomendasi = json_decode($response, true);
        ?>

        <h3 class="mt-5">Rekomendasi Produk</h3>
        <div class="produk-list mb-3">
            <?php if (!isset($rekomendasi['error'])): ?>
            <?php foreach ($rekomendasi['rekomendasi'] as $produk): ?>
            <div class="produk-item">
                <img src="gambar/produk/<?= $produk['produk_foto1'] ?>" alt="<?= $produk['produk_nama'] ?>">
                <p><?= $produk['produk_nama'] ?></p>
                <p>Rp <?= number_format($produk['produk_harga'], 0, ',', '.') ?></p>
                <a href="produk_detail.php?id=<?= $produk['produk_id'] ?>" class="btn btn-sm btn-orange">Lihat
                    Detail</a>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Tidak ada rekomendasi tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer-new.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>