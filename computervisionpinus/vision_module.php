<?php

require_once 'config.php';

class VisionModule {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
        createUploadDir();
    }

    public function uploadImage($file, $description = '') {
        try {
            // Validasi file
            $validation = $this->validateFile($file);
            if (!$validation['success']) {
                return $validation;
            }
            
            // Generate nama file unik
            $filename = $this->generateUniqueFilename($file['name']);
            $filepath = UPLOAD_DIR . $filename;
            
            // Upload file
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                return ['success' => false, 'message' => 'Gagal mengupload file'];
            }
            
            // Dapatkan informasi gambar
            $imageInfo = $this->getImageInfo($filepath);
            
            // Simpan ke database
            $imageId = $this->saveToDatabase($file, $filename, $filepath, $imageInfo, $description);
            
            // Proses computer vision (bisa diganti dengan model AI asli)
            $this->processImageVision($imageId, $filepath, $filename);
            
            return [
                'success' => true, 
                'message' => 'Gambar berhasil diupload',
                'image_id' => $imageId,
                'filename' => $filename,
                'filepath' => $filepath
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    private function validateFile($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Error saat upload file'];
        }
        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
        }
        if (!in_array($file['type'], ALLOWED_TYPES)) {
            return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
        }
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_EXTENSIONS)) {
            return ['success' => false, 'message' => 'Ekstensi file tidak diizinkan'];
        }
        return ['success' => true];
    }
    
    private function generateUniqueFilename($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid('pinus_') . '_' . time() . '.' . $extension;
    }
    
    private function getImageInfo($filepath) {
        $imageInfo = getimagesize($filepath);
        return [
            'width' => $imageInfo[0] ?? 0,
            'height' => $imageInfo[1] ?? 0,
            'type' => $imageInfo[2] ?? 0,
            'mime' => $imageInfo['mime'] ?? ''
        ];
    }
    
    private function saveToDatabase($file, $filename, $filepath, $imageInfo, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO pinus_images (
                filename, original_name, file_path, file_size, mime_type, 
                image_width, image_height, description, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");
        
        $stmt->execute([
            $filename,
            $file['name'],
            $filepath,
            $file['size'],
            $file['type'],
            $imageInfo['width'],
            $imageInfo['height'],
            $description
        ]);
        
        return $this->db->lastInsertId();
    }
    
    // Perbaikan utama: proses analisis gambar harus menghasilkan hasil berbeda untuk setiap gambar
    // Simulasi: gunakan hash dari filename untuk variasi hasil
    private function processImageVision($imageId, $filepath, $filename) {
        try {
            // Simulasi proses analisis dengan hasil berbeda tiap gambar
            $analysisResult = $this->simulateVisionAnalysis($filepath, $filename);
            
            // Simpan hasil analisis ke database
            $this->saveAnalysisResult($imageId, $analysisResult);
            
            // Update status gambar
            $this->updateImageStatus($imageId, 'processed');
            
        } catch (Exception $e) {
            $this->updateImageStatus($imageId, 'failed');
            error_log("Vision processing error: " . $e->getMessage());
        }
    }
    
    // Simulasi hasil analisis yang berbeda berdasarkan nama file
    private function simulateVisionAnalysis($filepath, $filename) {
        // Buat hash dari filename untuk variasi
        $hash = crc32($filename);
        // Array spesies pinus untuk variasi
        $species = ['Douglas Fir', 'White Pine'];
        $selectedSpecies = $species[$hash % count($species)];
        // Confidence score bervariasi antara 0.7 - 0.99
        $confidence = 0.7 + (($hash % 30) / 100);
        // Processing time bervariasi
        $processingTime = 1.5 + (($hash % 10) / 10);
        // Detected objects bervariasi
        $leafConfidence = 0.8 + (($hash % 10) / 100);
        $barkConfidence = 0.7 + ((($hash >> 2) % 10) / 100);
        $leafBbox = [100 + ($hash % 20), 100 + ($hash % 20), 200 + ($hash % 20), 200 + ($hash % 20)];
        $barkBbox = [50 + ($hash % 10), 300 + ($hash % 10), 150 + ($hash % 10), 400 + ($hash % 10)];
        
        return [
            'detected_objects' => [
                'leaf' => ['confidence' => $leafConfidence, 'bbox' => $leafBbox],
                'bark' => ['confidence' => $barkConfidence, 'bbox' => $barkBbox]
            ],
            'predicted_species' => $selectedSpecies,
            'confidence_score' => $confidence,
            'processing_time' => $processingTime,
            'algorithm_used' => 'Simulasi Hash Algorithm'
        ];
    }
    
    private function saveAnalysisResult($imageId, $result) {
        $stmt = $this->db->prepare("
            INSERT INTO vision_analysis (
                image_id, analysis_type, analysis_result, confidence_level, 
                processing_time, algorithm_used, notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $imageId,
            'pinus_detection',
            json_encode($result),
            $result['confidence_score'],
            $result['processing_time'],
            $result['algorithm_used'],
            'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'
        ]);
    }
    
    private function updateImageStatus($imageId, $status) {
        $stmt = $this->db->prepare("UPDATE pinus_images SET status = ? WHERE id = ?");
        $stmt->execute([$status, $imageId]);
    }
    
    public function getAllImages() {
        $stmt = $this->db->prepare("
            SELECT pi.*, va.confidence_level, va.analysis_result 
            FROM pinus_images pi 
            LEFT JOIN vision_analysis va ON pi.id = va.image_id 
            ORDER BY pi.upload_date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getImageById($id) {
        $stmt = $this->db->prepare("
            SELECT pi.*, va.analysis_result, va.confidence_level, va.processing_time
            FROM pinus_images pi 
            LEFT JOIN vision_analysis va ON pi.id = va.image_id 
            WHERE pi.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function deleteImage($id) {
        try {
            $image = $this->getImageById($id);
            if ($image) {
                if (file_exists($image['file_path'])) {
                    unlink($image['file_path']);
                }
                $stmt = $this->db->prepare("DELETE FROM pinus_images WHERE id = ?");
                $stmt->execute([$id]);
                return ['success' => true, 'message' => 'Gambar berhasil dihapus'];
            }
            return ['success' => false, 'message' => 'Gambar tidak ditemukan'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
?>