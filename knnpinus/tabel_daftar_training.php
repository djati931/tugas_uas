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

<div class="container mt-3">
  <h2>Daftar Data Training Pohon Pinus</h2>
  <p>Berikut ini daftar data training yang telah tersimpan :</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Id.Data</th>
        <th>Lingkar Batang (m)</th>
        <th>Tinggi (m)</th>
        <th>Jenis Pinus</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Koreksi: Pastikan variabel $koneksi sudah terdefinisi dan terkoneksi ke database sebelum query ini dijalankan.
      $sql = "SELECT * FROM `datatraining`";
      $q = mysqli_query($koneksi, $sql);

      // Koreksi: Gunakan while loop biasa, bukan do-while, agar tidak error jika data kosong.
      if ($q && mysqli_num_rows($q) > 0) {
        while ($r = mysqli_fetch_array($q)) {
      ?>
      <tr>
        <td><?php echo $r['IdData']; ?></td>
        <td><?php echo $r['Lingkar_Batang_m']; ?></td>
        <td><?php echo $r['Tinggi_m']; ?></td>
        <td><?php echo $r['Jenis_Pinus']; ?></td>
      </tr>
      <?php
        }
      } else {
      ?>
      <tr>
        <td colspan="4" class="text-center">Data tidak ditemukan.</td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>