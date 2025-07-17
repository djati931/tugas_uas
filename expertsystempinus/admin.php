<?php
require_once 'config.php';

$database = new Database();
$db = $database->getConnection();

$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    if (isset($_POST['add_training'])) {
         // Ambil data dari form
        $Jenis_Pinus = isset($_POST['Jenis_Pinus']) ? trim($_POST['Jenis_Pinus']) : '';
        $Lingkar_Batang_m = isset($_POST['Lingkar_Batang_m']) ? trim($_POST['Lingkar_Batang_m']) : '';
        $Tinggi_m = isset($_POST['Tinggi_m']) ? trim($_POST['Tinggi_m']) : '';

        // Validasi sederhana: pastikan semua field terisi dan format angka benar
        if ($Jenis_Pinus !== '' && $Lingkar_Batang_m !== '' && $Tinggi_m !== '' 
            && is_numeric($Lingkar_Batang_m) && is_numeric($Tinggi_m)
            && floatval($Lingkar_Batang_m) > 0 && floatval($Tinggi_m) > 0) {
            $query = "INSERT INTO datatraining1 (Jenis_Pinus, Lingkar_Batang_m, Tinggi_m) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            if ($stmt->execute([$Jenis_Pinus, $Lingkar_Batang_m, $Tinggi_m])) {
                $message = "Data training berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan data training.";
            }
        } else {
            $error = "Mohon lengkapi semua field dengan benar.";
        }
    }
    
    if (isset($_POST['delete_training'])) {
        $id = intval($_POST['delete_id']);
        $query = "DELETE FROM datatraining1 WHERE id = ?";
        $stmt = $db->prepare($query);
        if ($stmt->execute([$id])) {
            $message = "Data training berhasil dihapus!";
        } else {
            $error = "Gagal menghapus data training.";
        }
    }
}

// Get all training data
$query = "SELECT * FROM datatraining1 ORDER BY Jenis_Pinus, id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$datatraining1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get diagnosis history
$query = "SELECT * FROM diagnosis_history ORDER BY created_at DESC LIMIT 20";
$stmt = $db->prepare($query);
$stmt->execute();
$diagnosis_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get accuracy statistics
$query = "SELECT 
    COUNT(*) as total_diagnosis,
    COUNT(CASE WHEN hasil_cf = hasil_knn THEN 1 END) as consensus_count,
    AVG(cf_score) as avg_cf_score,
    AVG(knn_confidence) as avg_knn_confidence
FROM diagnosis_history WHERE hasil_cf IS NOT NULL";
$stmt = $db->prepare($query);
$stmt->execute();
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sistem Pakar Pohon Pinus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .nav {
            background: #34495e;
            padding: 0;
        }

        .nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        .nav li {
            margin: 0;
        }

        .nav a {
            display: block;
            padding: 15px 30px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .nav a:hover {
            background: #2c3e50;
        }

        .main-content {
            padding: 30px;
        }

        .message {
            background: #27ae60;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #e74c3c;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
        }

        .section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #495057;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .btn-danger:hover {
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }

        .table tr:hover {
            background: #f8f9fa;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
        }

        .stat-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .stat-card p {
            color: #7f8c8d;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .badge-success {
            background: #27ae60;
        }

        .badge-warning {
            background: #f39c12;
        }

        .badge-info {
            background: #3498db;
        }

        @media (max-width: 768px) {
            .nav ul {
                flex-direction: column;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EXPERT SYSTEM</h1>
            <p>Sistem Pakar Identifikasi Pohon Pinus</p>
        </div>

        <nav class="nav">
            <ul>
                <li><a href="index.php">🏠 Kembali ke Sistem</a></li>
                <li><a href="#training">📚 Data Training</a></li>
                <li><a href="#history">📊 History Diagnosis</a></li>
                <li><a href="#stats">📈 Statistik</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="section" id="stats">
                <h2>📈 Statistik Sistem</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3><?php echo count($datatraining1); ?></h3>
                        <p>Total Data Training</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $stats['total_diagnosis']; ?></h3>
                        <p>Total Diagnosis</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo $stats['consensus_count']; ?></h3>
                        <p>CF & KNN Consensus</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo number_format(($stats['avg_cf_score'] ?? 0) * 100, 1); ?>%</h3>
                        <p>Rata-rata CF Score</p>
                    </div>
                    <div class="stat-card">
                        <h3><?php echo number_format(($stats['avg_knn_confidence'] ?? 0) * 100, 1); ?>%</h3>
                        <p>Rata-rata KNN Confidence</p>
                    </div>
                </div>
            </div>

            <!-- Add Training Data -->
            <div class="section" id="training">
                <h2>📚 Tambah Data Training</h2>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Jenis_Pinus">Jenis Pinus:</label>
                            <select id="Jenis_Pinus" name="Jenis_Pinus" required>
                                <option value="">Pilih Jenis Pinus</option>
                                <option value="Douglas Fir">Douglas Fir</option>
                                <option value="White Pine">White Pine</option>
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="Lingkar_Batang_m">Lingkar Batang (m):</label>
                            <input type="text" id="Lingkar_Batang_m" name="Lingkar_Batang_m"
                                   pattern="^\d{1,2}\.\d{1,2}$"
                                   placeholder="cth: 0.3 atau 0.30"
                                   min="0.3" max="0.63"
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            <small class="form-text text-muted">Masukkan angka desimal dengan koma, contoh: 0,30 s/d 0,63</small>
                        </div>
                        <div class="form-group">
                            <label for="Tinggi_m">Tinggi Batang (m):</label>
                            <input type="text" id="Tinggi_m" name="Tinggi_m"
                                   pattern="^\d{1,2}\.\d{1,2}$"
                                   placeholder="cth: 2.7 atau 2.67"
                                   min="2.7" max="32.51"
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            <small class="form-text text-muted">Masukkan angka desimal dengan koma, contoh: 2,67 s/d 32,51</small>
                        </div>
                    </div>
                    <button type="submit" name="add_training" class="btn">➕ Tambah Data</button>
                </form>
            </div>

            <!-- Training Data Table -->
            <div class="section">
                <h2>📊 Data Training</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis Pinus</th>
                                <th>Lingkar Batang (m)</th>
                                <th>Tinggi Batang (m)</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datatraining1 as $data): ?>
                                <tr>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['Jenis_Pinus']; ?></td>
                                    <td><?php echo $data['Lingkar_Batang_m']; ?></td>
                                    <td><?php echo $data['Tinggi_m']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($data['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" action="" style="display: inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $data['id']; ?>">
                                            <button type="submit" name="delete_training" class="btn btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Diagnosis History -->
            <div class="section" id="history">
                <h2>📋 History Diagnosis (20 Terakhir)</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Lingkar Batang (m)</th>
                                <th>Tinggi Batang (m)</th>
                                <th>Hasil CF</th>
                                <th>CF Score</th>
                                <th>Hasil KNN</th>
                                <th>KNN Confidence</th>
                                <th>Hasil Final</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($diagnosis_history as $history): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($history['created_at'])); ?></td>
                                    <td><?php echo $history['Lingkar_Batang_m']; ?></td>
                                    <td><?php echo $history['Tinggi_m']; ?></td>
                                    <td><?php echo $history['hasil_cf'] ?? '-'; ?></td>
                                    <td><?php echo $history['cf_score'] ? number_format($history['cf_score'] * 100, 1) . '%' : '-'; ?></td>
                                    <td><?php echo $history['hasil_knn']; ?></td>
                                    <td><?php echo number_format($history['knn_confidence'] * 100, 1); ?>%</td>
                                    <td><?php echo $history['hasil_final']; ?></td>
                                    <td>
                                        <?php if ($history['hasil_cf'] === $history['hasil_knn']): ?>
                                            <span class="badge badge-success">Consensus</span>
                                        <?php elseif ($history['hasil_final'] === $history['hasil_cf']): ?>
                                            <span class="badge badge-warning">CF Win</span>
                                        <?php else: ?>
                                            <span class="badge badge-info">KNN Win</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>