<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
include_once('koneksi.db.php');
include_once('knn.php');
//ambil rekord training jadi array
$data = array();
$sqlt="SELECT * FROM datatraining";
$qt=mysqli_query($koneksi,$sqlt);
$rt=mysqli_fetch_assoc($qt);
do {
    $data[]=[(float)$rt['Lingkar_Batang_m'],(float)$rt['Tinggi_m'],(string)$rt['Jenis_Pinus']];
}while($rt=mysqli_fetch_assoc($qt));

//ambil rekord uji terpilih
if (isset($_GET['IdData'])) {
    $IdData=mysqli_real_escape_string($koneksi,$_GET['IdData']);
    $sqlu="SELECT * FROM datauji WHERE IdData=".$IdData;
    $qu=mysqli_query($koneksi,$sqlu);
    $ru=mysqli_fetch_assoc($qu);
    $input=[(float)$ru['Lingkar_Batang_m'],(float)$ru['Tinggi_m']];
    $k=(int)$ru['K'];
    $hasilprediksi=knnPredict($data,$input,$k);
    //simpan hasil prediksi kembali ke tabel datauji :
    $sqlsu="UPDATE datauji SET Jenis_Pinus='".$hasilprediksi."' WHERE IdData='".$IdData."'";
    $qsu=mysqli_query($koneksi,$sqlsu);
    //tampilkan hasilnya 
    echo '<div class="alert alert-success alert-dismissible">
  <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href=\'input_data_uji.php\'"></button>
  <strong>Success!</strong> Hasil Prediksi dari Lingkar_Batang_m : '.$ru['Lingkar_Batang_m'].' dan Tinggi_m : '.$ru['Tinggi_m'].' adalah : '.$hasilprediksi.'</div>';
}