<?php
/**
 * Upload Form Interface
 * File: upload_form.php
 * Interface untuk upload gambar dengan computer vision
 */

require_once 'vision_module.php';

$visionModule = new VisionModule();
$message = '';
$uploadedImage = null;

// Proses upload jika ada file yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $description = $_POST['description'] ?? '';
    $result = $visionModule->uploadImage($_FILES['image'], $description);
    
    if ($result['success']) {
        $uploadedImage = $visionModule->getImageById($result['image_id']);
        $message = '<div class="alert alert-success">' . $result['message'] . '</div>';
    } else {
        $message = '<div class="alert alert-danger">' . $result['message'] . '</div>';
    }
}

// Dapatkan semua gambar yang sudah diupload
$allImages = $visionModule->getAllImages();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Vision - Upload Gambar Pinus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .preview-container {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        
        .preview-container:hover {
            border-color: #007bff;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .image-card {
            transition: transform 0.3s;
        }
        
        .image-card:hover {
            transform: translateY(-5px);
        }
        
        .status-badge {
            font-size: 0.8em;
        }
        
        .upload-zone {
            border: 3px dashed #ccc;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        
        .upload-zone:hover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }
        
        .upload-zone.dragover {
            border-color: #28a745;
            background-color: #d4edda;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-leaf me-2"></i>
                            Computer Vision - Upload Gambar Pinus
                        </h3>
                        <small>Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus</small>
                    </div>
                    <div class="card-body">
                        <?php echo $message; ?>
                        
                        <!-- Form Upload -->
                        <form method="POST" enctype="multipart/form-data" id="uploadForm">
                            <div class="upload-zone mb-3" id="uploadZone">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <h5>Drag & Drop gambar di sini atau klik untuk memilih</h5>
                                <p class="text-muted">Format yang didukung: JPG, JPEG, PNG (Max: 5MB)</p>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="d-none" required>
                            </div>
                            
                            <div class="preview-container" id="previewContainer" style="display: none;">
                                <img id="previewImage" class="preview-image" alt="Preview">
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="removePreview()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                <textarea name="description" id="description" class="form-control" rows="3" 
                                          placeholder="Masukkan deskripsi gambar daun/batang pinus..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload & Analisis
                            </button>
                        </form>
                        
                        <!-- Hasil Upload Terbaru -->
                        <?php if ($uploadedImage): ?>
                        <div class="mt-4">
                            <h5>Hasil Upload Terbaru:</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="<?php echo htmlspecialchars($uploadedImage['file_path']); ?>" 
                                                 class="img-fluid rounded" alt="Uploaded Image">
                                        </div>
                                        <div class="col-md-8">
                                            <h6>Informasi Gambar:</h6>
                                            <ul class="list-unstyled">
                                                <li><strong>Nama File:</strong> <?php echo htmlspecialchars($uploadedImage['filename']); ?></li>
                                                <li><strong>Ukuran:</strong> <?php echo number_format($uploadedImage['file_size'] / 1024, 2); ?> KB</li>
                                                <li><strong>Dimensi:</strong> <?php echo $uploadedImage['image_width']; ?> x <?php echo $uploadedImage['image_height']; ?> px</li>
                                                <li><strong>Status:</strong> 
                                                    <?php
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'processed' => 'success',
                                                        'failed' => 'danger'
                                                    ];
                                                    ?>
                                                    <span class="badge bg-<?php echo $statusClass[$uploadedImage['status']]; ?>">
                                                        <?php echo ucfirst($uploadedImage['status']); ?>
                                                    </span>
                                                </li>
                                                <?php if ($uploadedImage['confidence_level']): ?>
                                                <li><strong>Confidence Score:</strong> <?php echo ($uploadedImage['confidence_level'] * 100); ?>%</li>
                                                <?php endif; ?>
                                            </ul>
                                            
                                            <?php if ($uploadedImage['analysis_result']): ?>
                                            <div class="mt-3">
                                                <h6>Hasil Analisis Computer Vision:</h6>
                                                <div class="alert alert-info">
                                                    <small><em>Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus</em></small>
                                                    <pre class="mt-2"><?php echo json_encode(json_decode($uploadedImage['analysis_result']), JSON_PRETTY_PRINT); ?></pre>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Galeri Gambar -->
                <?php if (!empty($allImages)): ?>
                <div class="card shadow mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-images me-2"></i>
                            Galeri Gambar Pinus
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($allImages as $image): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card image-card">
                                    <img src="<?php echo htmlspecialchars($image['file_path']); ?>" 
                                         class="card-img-top" style="height: 200px; object-fit: cover;" 
                                         alt="<?php echo htmlspecialchars($image['original_name']); ?>">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo htmlspecialchars($image['original_name']); ?></h6>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Upload: <?php echo date('d/m/Y H:i', strtotime($image['upload_date'])); ?>
                                            </small>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-<?php echo $statusClass[$image['status']]; ?> status-badge">
                                                <?php echo ucfirst($image['status']); ?>
                                            </span>
                                            <?php if ($image['confidence_level']): ?>
                                            <small class="text-muted">
                                                Confidence: <?php echo round($image['confidence_level'] * 100); ?>%
                                            </small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <a href="view_image.php?id=<?php echo $image['id']; ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="delete_image.php?id=<?php echo $image['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Hapus gambar ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Drag & Drop functionality
        const uploadZone = document.getElementById('uploadZone');
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        
        // Click to select file
        uploadZone.addEventListener('click', () => {
            imageInput.click();
        });
        
        // File input change
        imageInput.addEventListener('change', handleFileSelect);
        
        // Drag events
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });
        
        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });
        
        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                handleFileSelect();
            }
        });
        
        function handleFileSelect() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removePreview() {
            previewContainer.style.display = 'none';
            imageInput.value = '';
        }
    </script>
</body>
</html>