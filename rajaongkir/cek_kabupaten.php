<?php
$province_id = $_GET['province_id'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/city/$province_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "key: VSx5Ke5Y6cb00c723c98a51fhXFF8MwL"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "<option value=''>cURL Error: $err</option>";
    exit;
}

$data = json_decode($response, true);

if (!isset($data['data']) || !is_array($data['data'])) {
    echo "<option value=''>Data kabupaten tidak tersedia</option>";
    exit;
}

echo "<option value=''>-- Pilih Kabupaten/Kota --</option>";
foreach ($data['data'] as $city) {
    echo "<option value='{$city['id']}'>{$city['name']}</option>";
}
?>