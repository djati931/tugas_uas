<!DOCTYPE html>
<html lang="en">
<head>
  <title>SIM AI PINUS V.2025</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="./">
        <img src="./gambar/pinuslogo.png" alt="Logo" height="90">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="input_jenis_pinus.php" target="mainframe">Input Jenis Pinus</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="input_data_training.php" target="mainframe">Input Data Training</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="input_data_uji.php" target="mainframe">Input Data Uji</a>
        </li>
      </ul>
       <form class="d-flex" method="post">
        <input class="form-control me-2 search-box" type="text" placeholder="Search ...">
        <button class="btn btn-primary" type="submit">🔍</button>
      </form>
    </div>
  </div>
</nav>

<div class="container-fluid mt-3">
  <!--h3>Navbar Forms</h3>
  <p>You can also include forms inside the navigation bar.</p-->
  <iframe src="beranda.php" name="mainframe" width="100%" height="1600px"></iframe>
</div>

<div class="mt-5 p-4 bg-dark text-white text-center">
<h3>Tugas UAS Semester 4 Mata Kuliah Kecerdasan Buatan</h3>
    <p>Djati Lumayung</p>
    <p>2355201037</p>
</div>

</body>
</html>