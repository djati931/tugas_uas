<?php
// config.php - Konfigurasi Database
class Database {
    private $host = 'sql106.infinityfree.com';
    private $db_name = 'if0_38561592_pinus';
    private $username = 'if0_38561592';
    private $password = 'Djati0931';
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}

// Kelas untuk Certainty Factor
class CertaintyFactor {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function calculateCF($Lingkar_Batang_m, $Tinggi_m) {
        // Karena tabel rules mungkin tidak ada, kita buat rule sederhana berdasarkan data training
        $results = [];
        
        // Ambil data training untuk analisis
        $query = "SELECT Jenis_Pinus, AVG(Lingkar_Batang_m) as avg_lingkar, 
                  AVG(Tinggi_m) as avg_tinggi, COUNT(*) as count 
                  FROM datatraining1 GROUP BY Jenis_Pinus";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $datatraining1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($datatraining1 as $data) {
            $cf_score = $this->calculateCFScore($Lingkar_Batang_m, $Tinggi_m, $data);
            if ($cf_score > 0.1) { // Threshold minimum
                $results[] = [
                    'jenis' => $data['Jenis_Pinus'],
                    'cf_score' => $cf_score,
                    'deskripsi' => "Berdasarkan analisis data training untuk " . $data['Jenis_Pinus']
                ];
            }
        }
        
        // Urutkan berdasarkan CF score tertinggi
        usort($results, function($a, $b) {
            return $b['cf_score'] <=> $a['cf_score'];
        });
        
        return $results;
    }
    
    private function calculateCFScore($Lingkar_Batang_m, $Tinggi_m, $datatraining1) {
        $avg_lingkar = $datatraining1['avg_lingkar'];
        $avg_tinggi = $datatraining1['avg_tinggi'];
        
        // Hitung selisih dari rata-rata
        $lingkar_diff = abs($Lingkar_Batang_m - $avg_lingkar);
        $tinggi_diff = abs($Tinggi_m - $avg_tinggi);
        
        // Normalisasi berdasarkan rentang yang wajar
        $lingkar_score = max(0, 1 - ($lingkar_diff / 2)); // Maksimal selisih 2 meter
        $tinggi_score = max(0, 1 - ($tinggi_diff / 20)); // Maksimal selisih 20 meter
        
        // Gabungkan score
        $combined_score = ($lingkar_score + $tinggi_score) / 2;
        
        return $combined_score;
    }
}

// Kelas untuk KNN
class KNNClassifier {
    private $conn;
    private $k;
    
    public function __construct($db, $k = 3) {
        $this->conn = $db;
        $this->k = $k;
    }
    
    public function predict($Lingkar_Batang_m, $Tinggi_m) {
        // Ambil semua data training
        $query = "SELECT * FROM datatraining1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $datatraining1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($datatraining1)) {
            return [
                'predicted_class' => 'Unknown',
                'confidence' => 0,
                'k_nearest' => [],
                'votes' => []
            ];
        }
        
        // Hitung jarak euclidean untuk setiap data training
        $distances = [];
        foreach ($datatraining1 as $data) {
            $distance = $this->calculateEuclideanDistance(
                $Lingkar_Batang_m, $Tinggi_m,
                $data['Lingkar_Batang_m'], $data['Tinggi_m']
            );
            
            $distances[] = [
                'jenis' => $data['Jenis_Pinus'],
                'distance' => $distance
            ];
        }
        
        // Urutkan berdasarkan jarak terdekat
        usort($distances, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });
        
        // Ambil K tetangga terdekat
        $k_nearest = array_slice($distances, 0, $this->k);
        
        // Hitung voting untuk klasifikasi
        $votes = [];
        foreach ($k_nearest as $neighbor) {
            $jenis = $neighbor['jenis'];
            if (!isset($votes[$jenis])) {
                $votes[$jenis] = 0;
            }
            // Weighted voting berdasarkan jarak (semakin dekat, semakin tinggi bobotnya)
            $weight = 1 / ($neighbor['distance'] + 0.001); // +0.001 untuk menghindari division by zero
            $votes[$jenis] += $weight;
        }
        
        // Tentukan kelas dengan vote tertinggi
        if (!empty($votes)) {
            arsort($votes);
            $predicted_class = array_key_first($votes);
            
            // Hitung confidence berdasarkan proporsi vote
            $total_votes = array_sum($votes);
            $confidence = $votes[$predicted_class] / $total_votes;
        } else {
            $predicted_class = 'Unknown';
            $confidence = 0;
        }
        
        return [
            'predicted_class' => $predicted_class,
            'confidence' => $confidence,
            'k_nearest' => $k_nearest,
            'votes' => $votes
        ];
    }
    
    private function calculateEuclideanDistance($x1, $y1, $x2, $y2) {
        return sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));
    }
}

// Kelas untuk Expert System
class ExpertSystem {
    private $conn;
    private $cf;
    private $knn;
    
    public function __construct($db) {
        $this->conn = $db;
        $this->cf = new CertaintyFactor($db);
        $this->knn = new KNNClassifier($db);
    }
    
    public function diagnose($Lingkar_Batang_m, $Tinggi_m) {
        try {
            // Dapatkan hasil dari Certainty Factor
            $cf_results = $this->cf->calculateCF($Lingkar_Batang_m, $Tinggi_m);
            
            // Dapatkan hasil dari KNN
            $knn_result = $this->knn->predict($Lingkar_Batang_m, $Tinggi_m);
            
            // Kombinasi hasil CF dan KNN
            $final_result = $this->combineResults($cf_results, $knn_result);
            
            // Simpan hasil diagnosis ke database (opsional)
            $this->saveDiagnosis($Lingkar_Batang_m, $Tinggi_m, $cf_results, $knn_result, $final_result);
            
            return [
                'cf_results' => $cf_results,
                'knn_result' => $knn_result,
                'final_result' => $final_result
            ];
        } catch (Exception $e) {
            // Handle error gracefully
            return [
                'cf_results' => [],
                'knn_result' => [
                    'predicted_class' => 'Error',
                    'confidence' => 0,
                    'k_nearest' => [],
                    'votes' => []
                ],
                'final_result' => [
                    'jenis' => 'Error: ' . $e->getMessage(),
                    'confidence' => 0,
                    'method' => 'Error',
                    'explanation' => 'Terjadi kesalahan dalam proses diagnosis'
                ]
            ];
        }
    }
    
    private function combineResults($cf_results, $knn_result) {
        $cf_best = !empty($cf_results) ? $cf_results[0] : null;
        
        if ($cf_best && $knn_result['predicted_class'] === $cf_best['jenis']) {
            // Jika CF dan KNN memberikan hasil yang sama, tingkatkan confidence
            $combined_confidence = ($cf_best['cf_score'] + $knn_result['confidence']) / 2;
            return [
                'jenis' => $cf_best['jenis'],
                'confidence' => $combined_confidence,
                'method' => 'CF + KNN (Consensus)',
                'explanation' => 'Kedua metode memberikan hasil yang sama'
            ];
        } else {
            // Jika berbeda, pilih yang memiliki confidence lebih tinggi
            $cf_confidence = $cf_best ? $cf_best['cf_score'] : 0;
            $knn_confidence = $knn_result['confidence'];
            
            if ($cf_confidence > $knn_confidence && $cf_best) {
                return [
                    'jenis' => $cf_best['jenis'],
                    'confidence' => $cf_confidence,
                    'method' => 'Certainty Factor',
                    'explanation' => 'CF memberikan confidence lebih tinggi'
                ];
            } else {
                return [
                    'jenis' => $knn_result['predicted_class'],
                    'confidence' => $knn_confidence,
                    'method' => 'KNN',
                    'explanation' => 'KNN memberikan confidence lebih tinggi'
                ];
            }
        }
    }
    
    private function saveDiagnosis($Lingkar_Batang_m, $Tinggi_m, $cf_results, $knn_result, $final_result) {
        try {
            // Cek apakah tabel diagnosis_history ada
            $check_table = "SHOW TABLES LIKE 'diagnosis_history'";
            $stmt = $this->conn->prepare($check_table);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $cf_best = !empty($cf_results) ? $cf_results[0] : null;
                
                $query = "INSERT INTO diagnosis_history (Lingkar_Batang_m, Tinggi_m, hasil_cf, cf_score, 
                         hasil_knn, knn_confidence, hasil_final, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
                
                $stmt = $this->conn->prepare($query);
                $stmt->execute([
                    $Lingkar_Batang_m,
                    $Tinggi_m,
                    $cf_best ? $cf_best['jenis'] : null,
                    $cf_best ? $cf_best['cf_score'] : null,
                    $knn_result['predicted_class'],
                    $knn_result['confidence'],
                    $final_result['jenis']
                ]);
            }
        } catch (Exception $e) {
            // Jika gagal menyimpan, abaikan saja (tidak mengganggu proses utama)
            error_log("Failed to save diagnosis: " . $e->getMessage());
        }
    }
}
?>