<?php
$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : null;

if (!$city_id) {
    echo "<option value=''>Pilih kabupaten terlebih dahulu</option>";
    exit;
}

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/district/" . urlencode($city_id),
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
    echo "<option value=''>Error: $err</option>";
    exit;
}

$data = json_decode($response, true);

if (!isset($data['data']) || !is_array($data['data'])) {
    echo "<option value=''>Data kecamatan tidak tersedia</option>";
    exit;
}

echo "<option value=''>-- Pilih Kecamatan --</option>";
foreach ($data['data'] as $district) {
    echo "<option value='{$district['id']}'>{$district['name']}</option>";
}
?>