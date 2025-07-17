<?php
require_once 'config.php';

$database = new Database();
$db = $database->getConnection();
$expertSystem = new ExpertSystem($db);

$result = null;
$error = null;

if ($_POST) {
    $Lingkar_Batang_m = isset($_POST['Lingkar_Batang_m']) ? trim($_POST['Lingkar_Batang_m']) : '';
    $Tinggi_m = isset($_POST['Tinggi_m']) ? trim($_POST['Tinggi_m']) : '';

    // Validasi: pastikan kedua field terisi dan merupakan angka desimal yang valid
    if (
        $Lingkar_Batang_m !== '' && $Tinggi_m !== '' &&
        is_numeric($Lingkar_Batang_m) && is_numeric($Tinggi_m) &&
        floatval($Lingkar_Batang_m) >= 0.1 && floatval($Tinggi_m) >= 0.1
    ) {
        try {
            $result = $expertSystem->diagnose(floatval($Lingkar_Batang_m), floatval($Tinggi_m));
        } catch (Exception $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    } else {
        $error = "Mohon masukkan nilai yang valid untuk lingkar batang dan tinggi batang.";
    }
}

// Ambil data training untuk tampilan
$query = "SELECT Jenis_Pinus, COUNT(*) as count, AVG(Lingkar_Batang_m) as avg_lingkar, 
          AVG(Tinggi_m) as avg_tinggi FROM datatraining1 GROUP BY Jenis_Pinus";
$stmt = $db->prepare($query);
$stmt->execute();
$training_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Identifikasi Pohon Pinus</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px;
        }

        .input-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .input-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8em;
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

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s ease;
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        .result-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .result-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .result-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .result-card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .confidence-bar {
            background: #ecf0f1;
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }

        .confidence-fill {
            height: 100%;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            transition: width 0.8s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .method-badge {
            display: inline-block;
            padding: 5px 10px;
            background: #3498db;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0;
        }

        .error {
            background: #e74c3c;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .training-summary {
            margin-top: 30px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .training-summary h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .training-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .training-table th,
        .training-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .training-table th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }

        .training-table tr:hover {
            background: #f8f9fa;
        }

        .knn-details {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .knn-details h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .neighbor {
            background: white;
            padding: 8px 12px;
            border-radius: 5px;
            margin-bottom: 5px;
            border-left: 3px solid #3498db;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .header p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistem Pakar Identifikasi Pohon Pinus</h1>
            <p>Menggunakan Certainty Factor dan K-Nearest Neighbors</p>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="admin.php">EXPERT SYSTEM</a></li>
            </ul>
        </nav>

        <?php if ($error): ?>
            <div style="padding: 0 30px; padding-top: 20px;">
                <div class="error"><?php echo $error; ?></div>
            </div>
        <?php endif; ?>

        <div class="main-content">
            <div class="input-section">
                <h2>📏 Input Data Pohon</h2>
                <form method="POST" action="">
                    <div class="form-group row">
    <label for="Lingkar_Batang_m" class="col-4 col-form-label">Lingkar Batang (meter)</label> 
    <div class="col-8">
        <input 
            id="Lingkar_Batang_m" 
            name="Lingkar_Batang_m" 
            type="text" 
            class="form-control" 
            pattern="^\d{1,1}(\.\d{1,2})?$|^\d{1,2}(\.\d{1,2})?$" 
            maxlength="5"
            value="<?php echo isset($_POST['Lingkar_Batang_m']) ? htmlspecialchars($_POST['Lingkar_Batang_m']) : ''; ?>"
            placeholder="Contoh: 0.1, 0.11, 1.5, 2.25" 
            required
        >
        <small class="form-text text-muted">Format: 0.1, 0.11, 1.5, 2.25, dst (maksimal 2 angka di belakang titik)</small>
    </div>
</div>

<div class="form-group row">
    <label for="Tinggi_m" class="col-4 col-form-label">Tinggi Batang (meter)</label> 
    <div class="col-8">
        <input 
            id="Tinggi_m" 
            name="Tinggi_m" 
            type="text" 
            class="form-control" 
            pattern="^\d{1,2}(\.\d{1,2})?$" 
            maxlength="5"
            value="<?php echo isset($_POST['Tinggi_m']) ? htmlspecialchars($_POST['Tinggi_m']) : ''; ?>"
            placeholder="Contoh: 10.00, 1.00, 10.2, 11.11" 
            required
        >
        <small class="form-text text-muted">Format: 10.00, 1.00, 10.2, 11.11, dst (maksimal 2 angka di belakang titik)</small>
    </div>
</div>
                    
                    <button type="submit" class="btn">🔍 Identifikasi Pohon</button>
                </form>
            </div>

            <div class="result-section">
                <h2>📊 Hasil Diagnosis</h2>
                
                <?php 
               
                if ($result): 
                ?>
                    <!-- Hasil Final -->
                    <div class="result-card">
                        <h3>🏆 Hasil Final</h3>
                        <p><strong>Jenis Pohon:</strong> <?php echo isset($result['final_result']['jenis']) ? $result['final_result']['jenis'] : '-'; ?></p>
                        <div class="confidence-bar">
                            <div class="confidence-fill" style="width: <?php echo isset($result['final_result']['confidence']) ? ($result['final_result']['confidence'] * 100) : 0; ?>%">
                                <?php echo isset($result['final_result']['confidence']) ? number_format($result['final_result']['confidence'] * 100, 1) . '%' : '0%'; ?>
                            </div>
                        </div>
                        <div class="method-badge"><?php echo isset($result['final_result']['method']) ? $result['final_result']['method'] : '-'; ?></div>
                        <p><em><?php echo isset($result['final_result']['explanation']) ? $result['final_result']['explanation'] : ''; ?></em></p>
                    </div>

                    <!-- Hasil Certainty Factor -->
                    <div class="result-card">
                        <h3>🎯 Certainty Factor</h3>
                        <?php if (!empty($result['cf_results'])): ?>
                            <?php foreach ($result['cf_results'] as $cf_result): ?>
                                <div style="margin-bottom: 15px;">
                                    <p><strong><?php echo isset($cf_result['jenis']) ? $cf_result['jenis'] : '-'; ?></strong></p>
                                    <div class="confidence-bar">
                                        <div class="confidence-fill" style="width: <?php echo isset($cf_result['cf_score']) ? ($cf_result['cf_score'] * 100) : 0; ?>%">
                                            <?php echo isset($cf_result['cf_score']) ? number_format($cf_result['cf_score'] * 100, 1) . '%' : '0%'; ?>
                                        </div>
                                    </div>
                                   <p><small><?php echo isset($cf_result['deskripsi']) ? $cf_result['deskripsi'] : ''; ?></small></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada rule yang cocok dengan data input.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Hasil KNN -->
                    <div class="result-card">
                        <h3>🎯 K-Nearest Neighbors</h3>
                        <p><strong>Prediksi:</strong> <?php echo isset($result['knn_result']['predicted_class']) ? $result['knn_result']['predicted_class'] : '-'; ?></p>
                        <div class="confidence-bar">
                           <div class="confidence-fill" style="width: <?php echo isset($result['knn_result']['confidence']) ? ($result['knn_result']['confidence'] * 100) : 0; ?>%">
                                <?php echo isset($result['knn_result']['confidence']) ? number_format($result['knn_result']['confidence'] * 100, 1) . '%' : '0%'; ?>
                            </div>
                        </div>
                        
                        <div class="knn-details">
                            <h4>3 Tetangga Terdekat:</h4>
                            <?php 
                            if (isset($result['knn_result']['k_nearest']) && is_array($result['knn_result']['k_nearest'])):
                                foreach ($result['knn_result']['k_nearest'] as $neighbor): ?>
                                    <div class="neighbor">
                                        <strong><?php echo isset($neighbor['jenis']) ? $neighbor['jenis'] : '-'; ?></strong> 
                                        - Jarak: <?php echo isset($neighbor['distance']) ? number_format($neighbor['distance'], 3) : '-'; ?>
                                    </div>
                                <?php endforeach; 
                            else: ?>
                                <div class="neighbor">Tidak ada data tetangga terdekat.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Masukkan data lingkar batang dan tinggi batang untuk memulai diagnosis.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="training-summary">
            <h2>📈 Ringkasan Data Training</h2>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Jenis Pinus</th>
                        <th>Jumlah Data</th>
                        <th>Rata-rata Lingkar Batang (m)</th>
                        <th>Rata-rata Tinggi Batang (m)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($training_summary as $summary): ?>
                        <tr>
                            <td><?php echo $summary['Jenis_Pinus']; ?></td>
                            <td><?php echo $summary['count']; ?></td>
                            <td><?php echo number_format($summary['avg_lingkar'], 2); ?></td>
                            <td><?php echo number_format($summary['avg_tinggi'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Animasi untuk confidence bar
        document.addEventListener('DOMContentLoaded', function() {
            const confidenceBars = document.querySelectorAll('.confidence-fill');
            confidenceBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Validasi form
        document.querySelector('form').addEventListener('submit', function(e) {
            const lingkarBatang = parseFloat(document.getElementById('Lingkar_Batang_m').value);
            const tinggiBatang = parseFloat(document.getElementById('Tinggi_m').value);
            
            if (lingkarBatang <= 0 || tinggiBatang <= 0) {
                e.preventDefault();
                alert('Mohon masukkan nilai yang valid untuk lingkar batang dan tinggi batang.');
            }
        });
    </script>
</body>
</html>