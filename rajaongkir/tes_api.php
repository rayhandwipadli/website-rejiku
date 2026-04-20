<?php
// File untuk test koneksi ke RajaOngkir API
echo "<h3>Test Koneksi RajaOngkir API Starter</h3>";

$api_key = "12d2892c4854fb288ace09aac00fe536kontol"; // Ganti dengan API Key Anda

// Test 1: Cek Provinsi
echo "<h4>1. Test Ambil Data Provinsi:</h4>";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "key: $api_key"
    ],
]);

$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

echo "HTTP Status: $http_status<br>";
if ($err) {
    echo "CURL Error: $err<br>";
} else {
    echo "Response: " . substr($response, 0, 200) . "...<br><br>";
}

// Test 2: Cek Kota dari Provinsi ID 6 (DKI Jakarta)
echo "<h4>2. Test Ambil Data Kota (Provinsi DKI Jakarta):</h4>";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=6",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "key: $api_key"
    ],
]);

$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

echo "HTTP Status: $http_status<br>";
if ($err) {
    echo "CURL Error: $err<br>";
} else {
    echo "Response: " . substr($response, 0, 200) . "...<br><br>";
}

// Test 3: Cek Ongkir
echo "<h4>3. Test Cek Ongkir (Jakarta ke Bandung, JNE):</h4>";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "origin=151&destination=22&weight=1000&courier=jne",
    CURLOPT_HTTPHEADER => [
        "content-type: application/x-www-form-urlencoded",
        "key: $api_key"
    ],
]);

$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

echo "HTTP Status: $http_status<br>";
if ($err) {
    echo "CURL Error: $err<br>";
} else {
    if ($http_status == 200) {
        $data = json_decode($response, true);
        if (isset($data['rajaongkir']['status'])) {
            echo "API Status: " . $data['rajaongkir']['status']['code'] . " - " . $data['rajaongkir']['status']['description'] . "<br>";
        }
    }
    echo "Response: " . substr($response, 0, 300) . "...<br>";
}

echo "<hr>";
echo "<p><strong>Instruksi:</strong></p>";
echo "<ul>";
echo "<li>Jika semua test menunjukkan HTTP Status 200, API Key Anda valid</li>";
echo "<li>Jika ada HTTP Status 401, API Key tidak valid atau expired</li>";
echo "<li>Jika ada HTTP Status 404, endpoint salah</li>";
echo "<li>Jika ada CURL Error, masalah koneksi internet</li>";
echo "</ul>";
?>