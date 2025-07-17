<?php
/**
 * Delete Image Handler
 * File: delete_image.php
 * Handler untuk menghapus gambar dari sistem
 */

require_once 'vision_module.php';

$visionModule = new VisionModule();
$imageId = $_GET['id'] ?? null;

if (!$imageId) {
    header('Location: upload_form.php');
    exit;
}

// Proses penghapusan
$result = $visionModule->deleteImage($imageId);

// Redirect dengan pesan
if ($result['success']) {
    header('Location: upload_form.php?message=' . urlencode($result['message']) . '&type=success');
} else {
    header('Location: upload_form.php?message=' . urlencode($result['message']) . '&type=error');
}
exit;
?>