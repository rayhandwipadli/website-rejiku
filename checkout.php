<!-- head  -->
<?php include 'head-new.php'; ?>

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 0 !important;
    background-color: #000;
}

.btn {
    background: orange;
    color: white;
}

.btn:hover {
    background: orange;
    color: white;
}
</style>


<body class="js">




    <!-- Header -->
    <?php include 'header-new.php'; ?>
    <!--/ End Header -->

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index.php">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="checkout.php">Beli Sekarang</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Buat Pesanan</h3>
                        </div>

                        <form method="post" action="checkout_act.php">
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="row">
                                        <div class="col-lg-12">

                                            <br>


                                            <h4 class="text-center">INFORMASI PEMBELI / PENERIMA BARANG</h4>
                                            <br>

                                            <!-- <div class="form-group">
                                                <label class="text-bold">Nama</label> <br>
                                                <input type="text" class="input form-control" name="nama"
                                                    placeholder="Masukkan nama pemesan .." required="required">
                                            </div> -->


                                            <div class="form-group">
                                                <label class="text-bold">Nama</label> <br>
                                                <input type="text" class="input form-control" name="nama"
                                                    placeholder="Masukan Nama ..." required="required">
                                            </div>

                                            <div class="form-group">
                                                <label class="text-bold">Nomor HP</label> <br>
                                                <input type="tel" class="input form-control" name="hp"
                                                    placeholder="Masukkan no.hp aktif .." required="required"
                                                    pattern="^\d{1,13}$" maxlength="13">
                                            </div>

                                            <div class="form-group">
                                                <label class="text-bold">Alamat Lengkap</label> <br>
                                                <textarea name="alamat" class="form-control" style="resize: none;"
                                                    rows="6" placeholder="Masukkan alamat lengkap ..."
                                                    required="required"></textarea>
                                            </div>

                                            <?php 
										$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array(
    "key: VSx5Ke5Y6cb00c723c98a51fhXFF8MwL" // Ganti dengan API Key dari Komerce
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
$data_provinsi = json_decode($response, true);

										?>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label>Provinsi Tujuan</label> <br>
                                                    <select name='provinsi' id='provinsi' class="input form-control"
                                                        required="required">
                                                        <option required="required">Pilih Provinsi Tujuan</option>
                                                        <?php
foreach ($data_provinsi['data'] as $prov) {
  echo "<option value='" . $prov['id'] . "'>" . $prov['name'] . "</option>";
}
?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <label>Kabupaten</label> <br>
                                                    <select id="kabupaten" name="kabupaten">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <label>Kecamatan</label> <br>
                                                    <select id="kecamatan" name="kecamatan" required="required">
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" id="ongkir2" value="0">
                                            <input type="hidden" id="total_produk" value="<?php echo $jumlah_total; ?>">
                                            <input type="hidden" name="total_bayar" id="total_bayar"
                                                value="<?php echo $jumlah_total; ?>">



                                            <div id="ongkir"></div>

                                            <br>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <a class="main-btn btn btn-primary" href="keranjang.php">Kembali Ke
                                                    Keranjang</a>
                                            </div>

                                            <div class="pull-right">
                                                <input type="submit" class="primary-btn btn btn-primary	"
                                                    value="Buat Pesanan">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">

                                    <?php 
								if(isset($_SESSION['keranjang'])){

									$jumlah_isi_keranjang = count($_SESSION['keranjang']);

									if($jumlah_isi_keranjang != 0){

										?>


                                    <table class="shopping-cart-table table">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
											// cek apakah produk sudah ada dalam keranjang
												$jumlah_total = 0;
												$total = 0;
												for($a = 0; $a < $jumlah_isi_keranjang; $a++){
													$id_produk = $_SESSION['keranjang'][$a]['produk'];
													$jml = $_SESSION['keranjang'][$a]['jumlah'];

													$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
													$i = mysqli_fetch_assoc($isi);

													$total += $i['produk_harga']*$jml;
													$jumlah_total += $total;
													?>

                                            <tr>
                                                <td>
                                                    <a
                                                        href="#<?php echo $i['produk_id'] ?>"><?php echo $i['produk_nama'] ?></a>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo "Rp. ".number_format($i['produk_harga']) . " ,-"; ?>
                                                </td>
                                                <td class="qty text-center">
                                                    <?php echo $_SESSION['keranjang'][$a]['jumlah']; ?>
                                                </td>
                                                <td class="text-center"><strong class="primary-color total_harga"
                                                        id="total_<?php echo $i['produk_id'] ?>"><?php echo "Rp. ".number_format($total) . " ,-"; ?></strong>
                                                </td>
                                            </tr>

                                            <?php
													$total = 0;

												}

												?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="empty" colspan="2"></th>
                                                <th>TOTAL BERAT</th>
                                                <th class="text-center"><?php echo $total_berat; ?> Gram</th>
                                            </tr>
                                            <tr>
                                                <th class="empty" colspan="2"></th>
                                                <th>ONGKIR</th>
                                                <th class="text-center"><span
                                                        id="tampil_ongkir"><?php echo "Rp. 0 ,-"; ?></span></th>
                                            </tr>
                                            <tr>
                                                <th class="empty" colspan="2"></th>
                                                <th>TOTAL BAYAR</th>
                                                <th class="text-center"><span
                                                        id="tampil_total"><?php echo "Rp. ".number_format($jumlah_total) . " ,-"; ?></span>
                                                </th>
                                                <input type="hidden" id="total_produk"
                                                    value="<?php echo $jumlah_total; ?>">

                                            </tr>
                                        </tfoot>
                                    </table>

                                    <input name="berat" id="berat2" value="<?php echo $total_berat ?>" type="hidden">

                                    <input type="hidden" name="total_bayar" id="total_bayar"
                                        value="<?php echo $jumlah_total; ?>">

                                    <?php
									}else{

										echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='index.php'>belanja</a> !</center></h3><br><br><br>";
									}


								}else{
									echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='index.php'>belanja</a> !</center></h3><br><br><br>";
								}
								?>

                                </div>


                            </div>
                        </form>






                    </div>

                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // $(document).ready(function() {
    //     $('#provinsi').change(function() {
    //         var prov = $(this).val();
    //         var provinsiText = $("#provinsi option:selected").text();

    //         $.ajax({
    //             type: 'GET',
    //             url: 'rajaongkir/cek_kabupaten.php',
    //             data: {
    //                 province_id: prov
    //             }, // Ganti dari 'prov_id=' ke object agar aman
    //             success: function(data) {
    //                 $('#kabupaten').html(data)
    //                     .show(); // langsung munculin dropdown kabupaten
    //                 $('#provinsi2').val(provinsiText);
    //             },
    //             error: function() {
    //                 alert("Gagal mengambil data kabupaten.");
    //             }
    //         });
    //     });
    // });


    // $('#provinsi').on('change', function() {
    //     let provinsi_id = $(this).val();

    //     $.ajax({
    //         url: 'rajaongkir/cek_kabupaten.php',
    //         type: 'POST',
    //         data: {
    //             province_id: province_id
    //         },
    //         success: function(data) {
    //             $('#kabupaten').html(data);
    //         },
    //         error: function() {
    //             alert('Gagal mengambil data kabupaten');
    //         }
    //     });
    // });


    // $(document).on("change", "#pilih_ongkir", function() {
    //     let val = $(this).val().split("|");
    //     let biaya = val[0];
    //     let kurir = val[1];
    //     let layanan = val[2];

    //     $("#ongkir2").val(biaya);
    //     $("#kurir").val(kurir);
    //     $("#service").val(layanan);
    // });



    // $(document).on("change", "#kabupaten", function() {
    //     var asal = 152; // ID kota asal
    //     var kab = $('#kabupaten').val(); // ID tujuan
    //     var berat = $('#berat2').val(); // berat (dalam gram)
    //     var kabupaten = $("#kabupaten :selected").text();

    //     if (kab && berat > 0) {
    //         $.ajax({
    //             type: 'POST',
    //             url: 'rajaongkir/cek_ongkir.php',
    //             data: {
    //                 origin: asal,
    //                 destination: kab,
    //                 berat: berat
    //             },
    //             success: function(data) {
    //                 $("#ongkir").html(data);
    //                 $("#kabupaten2").val(kabupaten);
    //             },
    //             error: function() {
    //                 alert("Gagal menghitung ongkir");
    //             }
    //         });
    //     } else {
    //         alert("Kabupaten atau berat belum valid");
    //     }
    // });



    // });

    // function format_angka(x) {
    //     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // }

    // $(document).on("change", '.pilih-kurir', function(event) {
    //     // alert("new link clicked!");
    //     var kurir = $(this).attr("kurir");
    //     var service = $(this).attr("service");
    //     var ongkir = $(this).attr("harga");
    //     var total_bayar = $("#total_bayar").val();

    //     $("#kurir").val(kurir);
    //     $("#service").val(service);
    //     $("#ongkir2").val(ongkir);
    //     var total = parseInt(total_bayar) + parseInt(ongkir);
    //     $("#tampil_ongkir").text("Rp. " + format_angka(ongkir) + " ,-");
    //     $("#tampil_total").text("Rp. " + format_angka(total) + " ,-");
    // });


    // $(".pilih-kurir").on("change",function(){

    // 	alert('sd');
    // var asal = 152;
    // var kab = $('#kabupaten').val();
    // var kurir = "a";
    // var berat = $('#berat2').val();

    // $.ajax({
    // 	type : 'POST',
    // 	url : 'rajaongkir/cek_ongkir.php',
    // 	data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
    // 	success: function (data) {
    // 		$("#ongkir").html(data);
    // 		// alert(data);

    // 	}
    // });
    // });



    // ----- JQUERY BARU ----- //
    // $(document).ready(function() {
    //     // Event handler untuk perubahan provinsi (sudah ada dan bekerja)
    //     $('#provinsi').change(function() {
    //         var prov = $(this).val();
    //         var provinsiText = $("#provinsi option:selected").text();

    //         $.ajax({
    //             type: 'GET',
    //             url: 'rajaongkir/cek_kabupaten.php',
    //             data: {
    //                 province_id: prov
    //             },
    //             success: function(data) {
    //                 $('#kabupaten').html(data).show();
    //                 $('#provinsi2').val(provinsiText);

    //                 // Reset data ongkir saat provinsi berubah
    //                 $("#ongkir").html('');
    //                 $("#kurir").val('');
    //                 $("#service").val('');
    //                 $("#ongkir2").val('');
    //                 $("#tampil_ongkir").text('Rp. 0');
    //                 updateTotal();
    //             },
    //             error: function() {
    //                 alert("Gagal mengambil data kabupaten.");
    //             }
    //         });
    //     });

    //     // Event handler untuk perubahan kabupaten (diperbaiki)
    //     $(document).on("change", "#kabupaten", function() {
    //         var asal = 152; // ID kota asal
    //         var kab = $('#kabupaten').val(); // ID tujuan
    //         var berat = parseInt($('#berat2').val()); // berat (dalam gram)
    //         var kabupaten = $("#kabupaten :selected").text();

    //         console.log("Origin ID:", asal);
    //         console.log("Destination ID:", kab);
    //         console.log("Berat:", berat);

    //         if (!kab || kab === '') {
    //             alert("Silakan pilih kabupaten");
    //             return;
    //         }

    //         if (isNaN(berat) || berat <= 0) {
    //             alert("Berat barang harus diisi dan lebih dari 0 gram");
    //             return;
    //         }

    //         $("#ongkir").html(
    //             '<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Sedang mengecek ongkir...</div>'
    //         );

    //         $.ajax({
    //             type: 'POST',
    //             url: 'rajaongkir/cek_ongkir.php',
    //             data: {
    //                 origin: asal,
    //                 destination: kab,
    //                 berat: berat
    //             },
    //             success: function(data) {
    //                 console.log("Response ongkir:", data);
    //                 $("#ongkir").html(data);
    //                 $("#kabupaten2").val(kabupaten);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.log("Error:", error);
    //                 console.log("Status:", status);
    //                 console.log("Response:", xhr.responseText);
    //                 alert("Gagal menghitung ongkir: " + error);
    //                 $("#ongkir").html(
    //                     '<div class="alert alert-danger">Gagal menghitung ongkir</div>'
    //                 );
    //             }
    //         });
    //     });
    //     // Event handler untuk pilihan kurir (sesuai dengan sistem lama Anda)
    //     $(document).on("change", '.pilih-kurir', function() {
    //         var kurir = $(this).attr("kurir");
    //         var service = $(this).attr("service");
    //         var ongkir = $(this).attr("harga");
    //         var total_bayar = $("#total_bayar").val() || 0;

    //         console.log("Kurir dipilih:", kurir, service, ongkir); // Debug

    //         $("#kurir").val(kurir);
    //         $("#service").val(service);
    //         $("#ongkir2").val(ongkir);

    //         var total = parseInt(total_bayar) + parseInt(ongkir);
    //         $("#tampil_ongkir").text("Rp. " + format_angka(ongkir) + " ,-");
    //         $("#tampil_total").text("Rp. " + format_angka(total) + " ,-");
    //     });

    //     // Event handler untuk pilih_ongkir jika masih digunakan
    //     $(document).on("change", "#pilih_ongkir", function() {
    //         let val = $(this).val().split("|");
    //         let biaya = val[0];
    //         let kurir = val[1];
    //         let layanan = val[2];

    //         $("#ongkir2").val(biaya);
    //         $("#kurir").val(kurir);
    //         $("#service").val(layanan);

    //         updateTotal();
    //     });

    //     // Fungsi untuk format angka
    //     function format_angka(x) {
    //         return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //     }

    //     // Fungsi untuk update total
    //     function updateTotal() {
    //         var total_bayar = parseInt($("#total_bayar").val()) || 0;
    //         var ongkir = parseInt($("#ongkir2").val()) || 0;
    //         var total = total_bayar + ongkir;

    //         if ($("#tampil_total").length) {
    //             $("#tampil_total").text("Rp. " + format_angka(total) + " ,-");
    //         }
    //     }
    // });

    // // Ketika kecamatan berubah, hitung ongkir
    // $("#kecamatan").on("change", function() {
    // var asal = 3855; // ID kecamatan asal (Diwek, ganti sesuai kebutuhan)
    // var kec = $(this).val(); // ID kecamatan tujuan
    // var berat = parseInt($('#kabberat').html()); // Berat (dalam gram)
    // var kecamatan = $("#kecamatan :selected").text();

    // console.log("Origin ID:", asal);
    // console.log("Destination ID:", kec);
    // console.log("Berat:", berat);

    // if (!kec || kec === '') {
    //     alert("Silakan pilih kecamatan");
    //     return;
    // }

    // if (isNaN(berat) || berat <= 0) {
    //     alert("Berat barang harus diisi dan lebih dari 0 gram");
    //     return;
    // }

    // $("#ongkir").html(
    //     '<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Sedang mengecek ongkir...</div>'
    // );

    // $.ajax({
    //     type: 'POST',
    //     url: 'rajaongkir/cek_ongkir.php',
    //     data: {
    //         origin: asal,
    //         destination: kec,
    //         berat: berat
    //     },
    //     success: function(data) {
    //         console.log("Response ongkir:", data);
    //         $("#ongkir").html(data);
    //         $("#kecamatan2").val(kecamatan);
    //     },
    //     error: function(xhr, status, error) {
    //         console.log("Error:", error);
    //         console.log("Status:", status);
    //         console.log("Response:", xhr.responseText);
    //         alert("Gagal menghitung ongkir: " + error);
    //         $("#ongkir").html(
    //             '<div class="alert alert-danger">Gagal menghitung ongkir</div>'
    //         );
    //     }
    // });
    // });



    // PALING BARU//
    $(document).ready(function() {
        // Format angka
        function format_angka(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Reset tampilan ongkir & kurir
        function resetOngkir() {
            $("#ongkir").html('');
            $("#kurir").val('');
            $("#service").val('');
            $("#ongkir2").val('');
            $("#tampil_ongkir").text('Rp. 0');
            updateTotal();
        }

        // Hitung ulang total
        function updateTotal() {
            var total_bayar = parseInt($("#total_bayar").val()) || 0;
            var ongkir = parseInt($("#ongkir2").val()) || 0;
            var total = total_bayar + ongkir;
            $("#tampil_total").text("Rp. " + format_angka(total) + " ,-");
        }

        // Saat provinsi dipilih
        $('#provinsi').change(function() {
            var prov = $(this).val();
            var provinsiText = $("#provinsi option:selected").text();

            if (!prov) {
                $('#kabupaten').html("<option value=''>-- Pilih Kabupaten/Kota --</option>");
                $('#kecamatan').html("<option value=''>-- Pilih Kecamatan --</option>");
                resetOngkir();
                return;
            }

            $.ajax({
                type: 'GET',
                url: 'rajaongkir/cek_kabupaten.php',
                data: {
                    province_id: prov
                },
                success: function(data) {
                    $('#kabupaten').html(data).show();
                    $('#kecamatan').html("<option value=''>-- Pilih Kecamatan --</option>");
                    $('#provinsi2').val(provinsiText);
                    resetOngkir();
                },
                error: function() {
                    alert("Gagal mengambil data kabupaten.");
                }
            });
        });

        // Saat kabupaten dipilih
        $(document).on("change", "#kabupaten", function() {
            var kab = $(this).val();
            var kabupatenText = $("#kabupaten :selected").text();

            if (!kab) {
                $('#kecamatan').html("<option value=''>-- Pilih Kecamatan --</option>");
                resetOngkir();
                return;
            }

            $.ajax({
                type: 'GET',
                url: 'rajaongkir/cek_kecamatan.php',
                data: {
                    city_id: kab
                },
                success: function(data) {
                    $('#kecamatan').html(data).show();
                    $('#kabupaten2').val(kabupatenText);
                    resetOngkir();
                },
                error: function() {
                    alert("Gagal mengambil data kecamatan.");
                }
            });
        });

        // Saat kecamatan dipilih (tidak kirim ke cek_ongkir.php)
        $("#kecamatan").on("change", function() {
            var kecamatanText = $("#kecamatan :selected").text();
            $('#kecamatan2').val(kecamatanText);
            resetOngkir(); // Hanya reset ongkir tanpa proses apa-apa
        });
    });
    </script>

    <!-- js table -->
    <script>
    $(document).ready(function() {
        $('#kecamatan').on('change', function() {
            var kecamatan = $(this).val();
            if (kecamatan) {
                tampilkanOngkir(kecamatan);
            } else {
                $('#ongkir').html('');
                $('#tampil_ongkir').text('Rp. 0 ,-');
                $('#tampil_total').text('Rp. ' + parseInt($('#total_produk').val()).toLocaleString() +
                    ' ,-');
            }
        });
    });

    function tampilkanOngkir(kecamatan) {
        const kurirList = [{
                nama: 'JNE',
                layanan: ['REG', 'YES', 'OKE']
            },
            {
                nama: 'TIKI',
                layanan: ['ECO', 'REG', 'ONS']
            },
            {
                nama: 'POS',
                layanan: ['Kilat Khusus', 'Express Next Day', 'Biasa']
            },
            {
                nama: 'SiCepat',
                layanan: ['Best', 'Reguler']
            },
            {
                nama: 'J&T',
                layanan: ['EZ', 'Economy']
            }
        ];

        let html = `
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>Kurir</th>
                    <th>Layanan</th>
                    <th>Ongkir</th>
                    <th>Estimasi</th>
                </tr>
            </thead>
            <tbody>
    `;

        kurirList.forEach(kurir => {
            kurir.layanan.forEach(layanan => {
                let harga = 8000 + Math.floor(Math.random() * 10000) + kecamatan.length * 100;
                let estimasi =
                    `${2 + Math.floor(Math.random() * 3)}-${4 + Math.floor(Math.random() * 3)} hari`;

                html += `
                <tr>
                    <td>
                        <input type="radio" name="pilih_ongkir"
                            data-kurir="${kurir.nama}"
                            data-harga="${harga}"
                            data-layanan="${layanan}">
                    </td>
                    <td>${kurir.nama}</td>
                    <td>${layanan}</td>
                    <td>Rp ${harga.toLocaleString()}</td>
                    <td>${estimasi}</td>
                </tr>
            `;
            });
        });

        html += `</tbody></table>`;
        $('#ongkir').html(html);

        // Event saat user pilih kurir
        $('input[name="pilih_ongkir"]').on('change', function() {
            const kurir = $(this).data('kurir');
            const harga = $(this).data('harga');
            const layanan = $(this).data('layanan');

            $('#kurir').val(kurir);
            $('#ongkir2').val(harga);
            $('#service').val(layanan);

            // Tampilkan ongkir
            $('#tampil_ongkir').text(`Rp. ${harga.toLocaleString()},-`);

            // Hitung total
            const produk = parseInt($('#total_produk').val()) || 0;
            const total = produk + harga;
            $('#tampil_total').text(`Rp. ${total.toLocaleString()} ,-`);

            $('#total_bayar').val(total);
        });
    }
    </script>






    <!-- Start Footer Area -->
    <?php include 'footer-new.php'; ?>
    <!-- /End Footer Area -->

    <!-- foot  -->
    <?php include 'foot-new.php'; ?>

</body>

</html>