<?php


// Konfigurasi database
$host = 'sql106.infinityfree.com';
$username = 'if0_38561592';
$password = 'Djati0931';
$database = 'if0_38561592_pinus';

try {
    // Koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Set charset ke UTF-8
    $pdo->exec("SET NAMES utf8");
    
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk mendapatkan koneksi database
function getDBConnection() {
    global $pdo;
    return $pdo;
}

// Konfigurasi upload gambar
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/jpg']);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png']);

// Fungsi untuk membuat direktori upload jika belum ada
function createUploadDir() {
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
}
?>