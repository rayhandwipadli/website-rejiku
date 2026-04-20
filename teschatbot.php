<?php
$produk_id = isset($_GET['produk_id']) ? intval($_GET['produk_id']) : 0;

if ($produk_id > 0) {
    $api_url = "http://127.0.0.1:5000/rekomendasi?produk_id=" . $produk_id;
    
    $response = file_get_contents($api_url);
    if ($response === FALSE) {
        die("Gagal mengambil data dari API");
    }

    $data = json_decode($response, true);
    
    echo "<pre>";
    print_r($data); // Cek hasil response API
    echo "</pre>";
}
?>