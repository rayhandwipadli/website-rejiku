<?php
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "key: " // Ganti dengan API Key baru
    ],
]);
$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

echo "<label>Kota Asal</label><br>";
echo "<select name='asal' id='asal'>";
echo "<option value=''>Pilih Kota Asal</option>";

if (!empty($data['rajaongkir']['results'])) {
    foreach ($data['rajaongkir']['results'] as $city) {
        echo "<option value='" . $city['city_id'] . "'>" . $city['type'] . " " . $city['city_name'] . "</option>";
    }
} else {
    echo "<option value=''>Data Kota tidak ditemukan</option>";
}
echo "</select><br><br><br>";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "key: " // Ganti dengan API Key baru
    ],
]);
$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

echo "<label>Provinsi Tujuan</label><br>";
echo "<select name='provinsi' id='provinsi'>";
echo "<option value=''>Pilih Provinsi Tujuan</option>";

if (!empty($data['rajaongkir']['results'])) {
    foreach ($data['rajaongkir']['results'] as $province) {
        echo "<option value='" . $province['province_id'] . "'>" . $province['province'] . "</option>";
    }
} else {
    echo "<option value=''>Data Provinsi tidak ditemukan</option>";
}
echo "</select><br><br>";
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <label>Kabupaten Tujuan</label><br>
    <select id="kabupaten" name="kabupaten"></select><br><br>

    <label>Kurir</label><br>
    <select id="kurir" name="kurir">
        <option value="jne">JNE</option>
        <option value="tiki">TIKI</option>
        <option value="pos">POS INDONESIA</option>
    </select><br><br>

    <label>Berat (gram)</label><br>
    <input id="berat" type="text" name="berat" value="500" /><br><br>

    <input id="cek" type="submit" value="Cek" />
    <div id="ongkir"></div>
</body>

</html>

<script type="text/javascript">
$(document).ready(function() {
    $('#provinsi').change(function() {
        var prov = $('#provinsi').val();
        if (!prov) {
            $("#kabupaten").html('<option value="">Pilih Provinsi Terlebih Dahulu</option>');
            return;
        }
        $.ajax({
            type: 'GET',
            url: 'cek_kabupaten.php',
            data: {
                prov_id: prov
            },
            success: function(data) {
                $("#kabupaten").html(data);
            },
            error: function(xhr, status, error) {
                $("#kabupaten").html('<option value="">Gagal memuat data: ' + error +
                    '</option>');
            }
        });
    });

    $("#cek").click(function() {
        var asal = $('#asal').val();
        var kab = $('#kabupaten').val();
        var kurir = $('#kurir').val();
        var berat = $('#berat').val();

        if (!asal || !kab || !kurir || !berat) {
            alert("Lengkapi semua field!");
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'cek_ongkir.php',
            data: {
                asal: asal,
                kab_id: kab,
                kurir: kurir,
                berat: berat
            },
            success: function(data) {
                $("#ongkir").html(data);
            },
            error: function() {
                $("#ongkir").html("Gagal memuat data ongkir");
            }
        });
    });
});
</script>
