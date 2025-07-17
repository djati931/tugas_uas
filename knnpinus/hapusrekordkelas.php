<!DOCTYPE html>
<html lang="en">
<head>
  <title>Hapus Data Jenis Pinus - SIM KNN Pinus V.2025</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Hapus Data Jenis Pinus</h2>
<?php
if (isset($_POST['hsubmit'])) {
    include_once('koneksi.db.php');
    $IdData=mysqli_real_escape_string($koneksi,$_POST['IdData']);
    $sql1="DELETE FROM `kelas` WHERE `IdKelas` = '".$IdData."'";
    $q1=mysqli_query($koneksi,$sql1);
    if ($q1) {
        echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href=\'input_jenis_pinus.php\';"></button>
      <strong>Success!</strong> Rekord berhasil dihapus !
    </div>';
      } else {
        echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href=\'input_jenis_pinus.php\';"></button>
      <strong>Failed!</strong> Rekord gagal dihapus !
    </div>';
      }
}
?>
</div>

</body>
</html>