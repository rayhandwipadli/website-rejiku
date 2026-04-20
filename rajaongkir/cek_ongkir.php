<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: text/html");

    $origin      = $_POST['origin'] ?? null;
    $destination = $_POST['destination'] ?? null;
    $weight      = $_POST['berat'] ?? null;

    if (!$origin || !$destination || !$weight) {
        echo "<div class='alert alert-danger'>Data asal, tujuan, atau berat belum lengkap.</div>";
        exit;
    }

    $weight = (int)$weight;
    if ($weight <= 0) {
        echo "<div class='alert alert-danger'>Berat harus lebih dari 0 gram.</div>";
        exit;
    }

    function get_all_couriers() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/couriers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "key: VSx5Ke5Y6cb00c723c98a51fhXFF8MwL"
            ],
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err || $httpCode != 200) return [];

        $data = json_decode($response, true);
        return $data['data'] ?? [];
    }

    function get_ongkir($origin, $destination, $weight, $courier) {
        $curl = curl_init();
        $body = json_encode([
            "origin" => (int)$origin,
            "destination" => (int)$destination,
            "weight" => $weight,
            "courier" => $courier
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json",
                "key: VSx5Ke5Y6cb00c723c98a51fhXFF8MwL"
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err || $httpCode != 200) return null;

        return json_decode($response, true);
    }

    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kurir</th>
                    <th>Layanan</th>
                    <th>Ongkir</th>
                    <th>Estimasi</th>
                    <th>Pilih</th>
                </tr>
            </thead>
            <tbody>';

    $hasResults = false;
    $couriers = get_all_couriers();

    if (empty($couriers)) {
        echo "<tr><td colspan='5' class='text-center'>Gagal mengambil daftar kurir. Silakan coba lagi nanti.</td></tr>";
    } else {
        foreach ($couriers as $courier) {
            $kodeKurir = $courier['code'] ?? '';
            $namaKurir = strtoupper($courier['name'] ?? $kodeKurir);
            if (!$kodeKurir) continue;

            $result = get_ongkir($origin, $destination, $weight, $kodeKurir);
            if (!$result || empty($result['data'][0]['costs'])) {
                echo "<tr><td colspan='5' class='text-center'>Data ongkir {$namaKurir} tidak tersedia.</td></tr>";
                continue;
            }

            foreach ($result['data'][0]['costs'] as $layanan) {
                $service = $layanan['service'] ?? 'Unknown';
                $description = $layanan['description'] ?? '';
                $harga = $layanan['cost'][0]['value'] ?? 0;
                $etd = $layanan['cost'][0]['etd'] ?? 'N/A';

                echo "<tr>
                        <td>{$namaKurir}</td>
                        <td>{$service}" . ($description ? " - {$description}" : "") . "</td>
                        <td>Rp. " . number_format($harga, 0, ',', '.') . "</td>
                        <td>" . ($etd ? "{$etd} hari" : 'N/A') . "</td>
                        <td class='text-center'>
                            <input type='radio' name='kurirx' class='pilih-kurir'
                                kurir='{$namaKurir}' service='{$service}' harga='{$harga}' required>
                        </td>
                    </tr>";
                $hasResults = true;
            }
        }

        if (!$hasResults) {
            echo "<tr><td colspan='5' class='text-center'>Tidak ada layanan kurir yang tersedia untuk rute ini.</td></tr>";
        }
    }

    echo '</tbody></table>';
} else {
    echo "<div class='alert alert-danger'>Metode tidak diizinkan.</div>";
}
?>