<?php 

$koneksi = mysqli_init();
mysqli_options($koneksi, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);

mysqli_real_connect(
    $koneksi,
    "roundhouse.proxy.rlwy.net",
    "root",
    "PaptTJoTonKOvtKDsWlAriuVAYyrPbfF",
    "railway",
    46308
);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>