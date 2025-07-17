<!DOCTYPE html>
<html lang="en">
<head>
  <title>Input Data Training Pinus - SIM KNN Pinus V.2025</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Input Data Training Jenis Pinus</h2>
  <form method="post">
  <div class="form-group row">
    <label for="Lingkar_Batang_m" class="col-4 col-form-label">Lingkar_Batang(m)</label> 
    <div class="col-8">
      <input id="Lingkar_Batang_m" name="Lingkar_Batang_m" type="text" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="Tinggi_m" class="col-4 col-form-label">Tinggi(m)</label> 
    <div class="col-8">
      <input id="Tinggi_m" name="Tinggi_m" type="text" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="Jenis_Pinus" class="col-4 col-form-label">Jenis_Pinus</label> 
    <div class="col-8">
      <!--input id="Jenis_Pinus" name="Jenis_Pinus" type="text" class="form-control" required="required"-->
      <select class="form-select" id="Jenis_Pinus" name="Jenis_Pinus" required>
        <option value="">Pilih...</option>
       <?php 
       
       include_once('koneksi.db.php');
       $sqlpil="select * from kelas";
       $qpil=mysqli_query($koneksi,$sqlpil);
       while($rpil=mysqli_fetch_array($qpil)) { ?> 
       <option value="<?php echo $rpil['IdKelas'];?>"><?php echo $rpil['Jenis_Pinus'];?></option>
       <?php } ?>
    </select>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">💾 Simpan Rekord Baru</button>
      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal"> 🔎 Cari Rekord Training </button>
    </div>
  </div>
</form>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cari Rekord Data Training</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post">
  <div class="form-group row">
    <label for="Kecerahan" class="col-4 col-form-label">Id. Data</label> 
    <div class="col-8">
      <input id="IdData" name="IdData" type="text" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="ksubmit" type="submit" class="btn btn-primary" formaction="koreksirekordtraining.php"> 🛠️ Koreksi</button>
      <button name="hsubmit" type="submit" class="btn btn-danger" formaction="hapusrekordtraining.php" onclick="return confirm('Apakah yakin akan menghapusnya ?')"> 🗑️ Hapus</button>
      </div>
    </div>
   </form>
   </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<?php
// Proses simpan data
include_once('koneksi.db.php');
if (isset($_POST['submit'])) {
  $Lingkar_Batang_m=mysqli_real_escape_string($koneksi,$_POST['Lingkar_Batang_m']);
  $Tinggi_m=mysqli_real_escape_string($koneksi,$_POST['Tinggi_m']);
  $Jenis_Pinus=mysqli_real_escape_string($koneksi,$_POST['Jenis_Pinus']);
  // Pastikan Jenis_Pinus tidak kosong
  if($Jenis_Pinus == "" || $Jenis_Pinus == "Pilih...") {
    echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Error!</strong> Jenis Pinus harus dipilih!
    </div>';
  } else {
    $sql="INSERT INTO `datatraining`(`Lingkar_Batang_m`, `Tinggi_m`, `Jenis_Pinus`) VALUES ('".$Lingkar_Batang_m."','".$Tinggi_m."','".$Jenis_Pinus."')";
    $q=mysqli_query($koneksi,$sql);
    if ($q) {
      echo '<div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Success!</strong> Rekord berhasil disimpan !
  </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Error!</strong> Rekord gagal disimpan !
  </div>';
    }
  }
}
include('tabel_daftar_training.php'); 
?>
</div>
</body>
</html>
