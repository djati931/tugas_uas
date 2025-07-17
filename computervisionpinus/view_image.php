<?php

require_once 'vision_module.php';

$visionModule = new VisionModule();
$imageId = $_GET['id'] ?? null;

if (!$imageId) {
    header('Location: upload_form.php');
    exit;
}

$image = $visionModule->getImageById($imageId);
if (!$image) {
    header('Location: upload_form.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Gambar - Computer Vision</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .image-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        
        .main-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .info-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .analysis-result {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-top: 15px;
        }
        
        .status-badge {
            font-size: 1em;
            padding: 8px 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        <i class="fas fa-image me-2"></i>
                        Detail Gambar Pinus
                    </h2>
                    <a href="upload_form.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                
                <div class="row">
                    <!-- Gambar -->
                    <div class="col-md-8">
                        <div class="image-container">
                            <img src="<?php echo htmlspecialchars($image['file_path']); ?>" 
                                 class="main-image" 
                                 alt="<?php echo htmlspecialchars($image['original_name']); ?>">
                            <div class="mt-3">
                                <h5><?php echo htmlspecialchars($image['original_name']); ?></h5>
                                <p class="text-muted">
                                    Diupload pada: <?php echo date('d F Y, H:i', strtotime($image['upload_date'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi -->
                    <div class="col-md-4">
                        <!-- Status -->
                        <div class="info-card">
                            <h6><i class="fas fa-info-circle me-2"></i>Status</h6>
                            <?php
                            $statusClass = [
                                'pending' => 'warning',
                                'processed' => 'success',
                                'failed' => 'danger'
                            ];
                            $statusText = [
                                'pending' => 'Menunggu Proses',
                                'processed' => 'Sudah Diproses',
                                'failed' => 'Gagal Diproses'
                            ];
                            ?>
                            <span class="badge bg-<?php echo $statusClass[$image['status']]; ?> status-badge">
                                <?php echo $statusText[$image['status']]; ?>
                            </span>
                        </div>
                        
                        <!-- Informasi File -->
                        <div class="info-card">
                            <h6><i class="fas fa-file-alt me-2"></i>Informasi File</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nama File:</strong></td>
                                    <td><?php echo htmlspecialchars($image['filename']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ukuran:</strong></td>
                                    <td><?php echo number_format($image['file_size'] / 1024, 2); ?> KB</td>
                                </tr>
                                <tr>
                                    <td><strong>Dimensi:</strong></td>
                                    <td><?php echo $image['image_width']; ?> x <?php echo $image['image_height']; ?> px</td>
                                </tr>
                                <tr>
                                    <td><strong>Tipe:</strong></td>
                                    <td><?php echo $image['mime_type']; ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Deskripsi -->
                        <?php if ($image['description']): ?>
                        <div class="info-card">
                            <h6><i class="fas fa-comment me-2"></i>Deskripsi</h6>
                            <p><?php echo nl2br(htmlspecialchars($image['description'])); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Aksi -->
                        <div class="info-card">
                            <h6><i class="fas fa-tools me-2"></i>Aksi</h6>
                            <div class="d-grid gap-2">
                                <a href="<?php echo htmlspecialchars($image['file_path']); ?>" 
                                   class="btn btn-primary btn-sm" download>
                                    <i class="fas fa-download me-2"></i>Download
                                </a>
                                <a href="delete_image.php?id=<?php echo $image['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Hapus gambar ini?')">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hasil Analisis Computer Vision -->
                <?php if ($image['analysis_result']): ?>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-brain me-2"></i>
                                Hasil Analisis Computer Vision
                            </h5>
                            <small>Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Ringkasan Hasil:</h6>
                                    <?php $analysis = json_decode($image['analysis_result'], true); ?>
                                    <ul class="list-unstyled">
                                        <?php if (isset($analysis['predicted_species'])): ?>
                                        <li><strong>Prediksi Spesies:</strong> <?php echo htmlspecialchars($analysis['predicted_species']); ?></li>
                                        <?php endif; ?>
                                        
                                        <?php if ($image['confidence_level']): ?>
                                        <li><strong>Tingkat Kepercayaan:</strong> 
                                            <span class="badge bg-<?php echo $image['confidence_level'] > 0.8 ? 'success' : ($image['confidence_level'] > 0.6 ? 'warning' : 'danger'); ?>">
                                                <?php echo round($image['confidence_level'] * 100); ?>%
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php if ($image['processing_time']): ?>
                                        <li><strong>Waktu Proses:</strong> <?php echo $image['processing_time']; ?> detik</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Objek Terdeteksi:</h6>
                                    <?php if (isset($analysis['detected_objects'])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Objek</th>
                                                    <th>Confidence</th>
                                                    <th>Posisi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($analysis['detected_objects'] as $object => $data): ?>
                                                <tr>
                                                    <td><?php echo ucfirst($object); ?></td>
                                                    <td><?php echo round($data['confidence'] * 100); ?>%</td>
                                                    <td><?php echo implode(', ', $data['bbox']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="analysis-result">
                                <h6>Data Analisis Lengkap:</h6>
                                <pre><?php echo json_encode($analysis, JSON_PRETTY_PRINT); ?></pre>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <em>Catatan: Ini adalah hasil simulasi. Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus dengan algoritma computer vision yang sesungguhnya.</em>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="mt-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Belum ada hasil analisis computer vision.</strong><br>
                        Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus.
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>