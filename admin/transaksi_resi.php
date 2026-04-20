<?php
include '../koneksi.php';

if(isset($_POST['invoice_id']) && isset($_POST['invoice_resi'])){
    $invoice_id = $_POST['invoice_id'];
    $invoice_resi = $_POST['invoice_resi'];

    $query = "UPDATE invoice SET invoice_resi='$invoice_resi' WHERE invoice_id='$invoice_id'";
    mysqli_query($koneksi, $query);

    header("Location: transaksi.php");
}
?>