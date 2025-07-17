-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql106.infinityfree.com
-- Waktu pembuatan: 17 Jul 2025 pada 00.10
-- Versi server: 11.4.7-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38561592_pinus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `datatraining`
--

CREATE TABLE `datatraining` (
  `IdData` int(11) NOT NULL,
  `Lingkar_Batang_m` double(5,2) DEFAULT NULL,
  `Tinggi_m` double(5,2) DEFAULT NULL,
  `Jenis_Pinus` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `datatraining`
--

INSERT INTO `datatraining` (`IdData`, `Lingkar_Batang_m`, `Tinggi_m`, `Jenis_Pinus`) VALUES
(1, 0.30, 7.21, 'Douglas Fir'),
(2, 0.18, 5.12, 'Douglas Fir'),
(3, 0.46, 8.83, 'Douglas Fir'),
(4, 0.63, 12.08, 'Douglas Fir'),
(5, 0.23, 5.81, 'Douglas Fir'),
(6, 0.56, 13.50, 'Douglas Fir'),
(7, 0.39, 10.90, 'Douglas Fir'),
(8, 0.41, 6.79, 'Douglas Fir'),
(9, 0.62, 10.66, 'Douglas Fir'),
(10, 0.43, 10.50, 'Douglas Fir'),
(11, 0.15, 2.67, 'Douglas Fir'),
(12, 0.19, 20.34, 'White Pine'),
(13, 0.17, 19.72, 'White Pine'),
(14, 0.17, 19.80, 'White Pine'),
(15, 0.22, 23.70, 'White Pine'),
(16, 0.45, 32.51, 'White Pine'),
(17, 0.39, 26.23, 'White Pine'),
(18, 0.42, 32.51, 'White Pine'),
(19, 0.38, 29.18, 'White Pine'),
(20, 0.30, 26.10, 'White Pine'),
(21, 0.18, 21.51, 'White Pine');

-- --------------------------------------------------------

--
-- Struktur dari tabel `datatraining1`
--

CREATE TABLE `datatraining1` (
  `id` int(11) NOT NULL,
  `Jenis_Pinus` varchar(50) NOT NULL,
  `Lingkar_Batang_m` decimal(5,2) NOT NULL,
  `Tinggi_m` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `datatraining1`
--

INSERT INTO `datatraining1` (`id`, `Jenis_Pinus`, `Lingkar_Batang_m`, `Tinggi_m`, `created_at`) VALUES
(21, 'White Pine', '0.18', '21.51', '2025-07-15 14:43:25'),
(20, 'White Pine', '0.30', '26.10', '2025-07-15 14:43:25'),
(19, 'White Pine', '0.38', '29.18', '2025-07-15 14:43:25'),
(18, 'White Pine', '0.42', '32.51', '2025-07-15 14:43:25'),
(17, 'White Pine', '0.39', '26.23', '2025-07-15 14:43:25'),
(16, 'White Pine', '0.45', '32.51', '2025-07-15 14:43:25'),
(15, 'White Pine', '0.22', '23.70', '2025-07-15 14:43:25'),
(14, 'White Pine', '0.17', '19.80', '2025-07-15 14:43:25'),
(13, 'White Pine', '0.17', '19.72', '2025-07-15 14:43:25'),
(12, 'White Pine', '0.19', '20.34', '2025-07-15 14:43:25'),
(11, 'Douglas Fir', '0.15', '2.67', '2025-07-15 14:43:25'),
(10, 'Douglas Fir', '0.43', '10.50', '2025-07-15 14:43:25'),
(9, 'Douglas Fir', '0.62', '10.66', '2025-07-15 14:43:25'),
(8, 'Douglas Fir', '0.41', '6.79', '2025-07-15 14:43:25'),
(7, 'Douglas Fir', '0.39', '10.90', '2025-07-15 14:43:25'),
(6, 'Douglas Fir', '0.56', '13.50', '2025-07-15 14:43:25'),
(5, 'Douglas Fir', '0.23', '5.81', '2025-07-15 14:43:25'),
(4, 'Douglas Fir', '0.63', '12.08', '2025-07-15 14:43:25'),
(3, 'Douglas Fir', '0.46', '8.83', '2025-07-15 14:43:25'),
(2, 'Douglas Fir', '0.18', '5.12', '2025-07-15 14:43:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `datauji`
--

CREATE TABLE `datauji` (
  `IdData` int(11) NOT NULL,
  `Lingkar_Batang_m` double(5,2) DEFAULT NULL,
  `Tinggi_m` double(5,2) DEFAULT NULL,
  `Jenis_Pinus` varchar(15) DEFAULT NULL,
  `K` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `datauji`
--

INSERT INTO `datauji` (`IdData`, `Lingkar_Batang_m`, `Tinggi_m`, `Jenis_Pinus`, `K`) VALUES
(1, 0.50, 9.98, 'Douglas Fir', 13),
(2, 0.60, 11.50, 'Douglas Fir', 13),
(3, 0.30, 13.50, 'Douglas Fir', 13),
(4, 0.45, 32.51, 'White Pine', 13),
(5, 0.25, 34.09, 'White Pine', 13),
(6, 0.56, 40.51, 'White Pine', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosis_history`
--

CREATE TABLE `diagnosis_history` (
  `id` int(11) NOT NULL,
  `Lingkar_Batang_m` decimal(5,2) NOT NULL,
  `Tinggi_m` decimal(5,2) NOT NULL,
  `hasil_cf` varchar(50) DEFAULT NULL,
  `cf_score` decimal(3,2) DEFAULT NULL,
  `hasil_knn` varchar(50) DEFAULT NULL,
  `knn_confidence` decimal(3,2) DEFAULT NULL,
  `hasil_final` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `diagnosis_history`
--

INSERT INTO `diagnosis_history` (`id`, `Lingkar_Batang_m`, `Tinggi_m`, `hasil_cf`, `cf_score`, `hasil_knn`, `knn_confidence`, `hasil_final`, `created_at`) VALUES
(1, '0.50', '9.98', 'Douglas Fir', '0.98', 'Douglas Fir', '1.00', 'Douglas Fir', '2025-07-15 14:26:40'),
(2, '0.50', '9.98', 'Douglas Fir', '0.98', 'Douglas Fir', '1.00', 'Douglas Fir', '2025-07-15 14:27:15'),
(3, '0.18', '21.51', 'Douglas Fir', '0.65', 'Douglas Fir', '1.00', 'Douglas Fir', '2025-07-15 14:27:55'),
(4, '0.40', '19.01', 'White Pine', '0.81', 'White Pine', '0.52', 'White Pine', '2025-07-15 14:31:18'),
(5, '0.50', '15.17', 'Douglas Fir', '0.81', 'Douglas Fir', '1.00', 'Douglas Fir', '2025-07-15 14:46:12'),
(6, '0.15', '30.60', 'White Pine', '0.83', 'White Pine', '1.00', 'White Pine', '2025-07-15 14:50:29'),
(7, '0.20', '30.41', 'White Pine', '0.85', 'White Pine', '1.00', 'White Pine', '2025-07-15 15:13:36'),
(8, '0.18', '21.51', 'White Pine', '0.88', 'White Pine', '1.00', 'White Pine', '2025-07-16 00:37:30'),
(9, '0.20', '21.00', 'White Pine', '0.87', 'White Pine', '1.00', 'White Pine', '2025-07-16 13:54:15'),
(10, '0.30', '5.12', 'Douglas Fir', '0.88', 'Douglas Fir', '1.00', 'Douglas Fir', '2025-07-17 02:51:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `IdData` int(2) NOT NULL,
  `Jarak` double(5,2) DEFAULT NULL,
  `Jenis_Pinus` varchar(15) DEFAULT NULL,
  `Jumlah` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `IdKelas` int(11) NOT NULL,
  `Jenis_Pinus` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`IdKelas`, `Jenis_Pinus`) VALUES
(2, 'White Pine'),
(3, 'Douglas Fir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perhitungan`
--

CREATE TABLE `perhitungan` (
  `IdData` int(2) NOT NULL,
  `Lingkar_Batang_m` double(5,2) DEFAULT NULL,
  `Tinggi_m` double(5,2) DEFAULT NULL,
  `Jarak` double(5,2) DEFAULT NULL,
  `Jenis_Pinus` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinus_categories`
--

CREATE TABLE `pinus_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `characteristics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `pinus_categories`
--

INSERT INTO `pinus_categories` (`id`, `category_name`, `description`, `characteristics`, `created_at`) VALUES
(1, 'Douglas Fir', 'Douglas Fir bukanlah \"fir\" sejati (bukan dari genus Abies), namun merupakan salah satu jenis pohon konifer terbesar dan paling penting secara komersial di Amerika Utara. Pohon ini dapat tumbuh sangat tinggi (hingga 100 meter dalam kondisi alami) dan biasa digunakan sebagai bahan konstruksi dan kertas.', '{\"leaf_shape\": \"jarum\", \"bark_texture\": \"kasar\", \"cone_size\": \"besar\"}', '2025-07-16 05:50:06'),
(2, 'White Pine', 'White Pine adalah salah satu spesies pinus tertinggi di Amerika Utara bagian timur, dikenal karena kayunya yang ringan dan lurus. Daunnya terdiri dari lima jarum per gugus, yang menjadi ciri khasnya. Kayunya banyak digunakan untuk konstruksi ringan, perabot, dan paneling.', '{\"leaf_shape\": \"jarum_pendek\", \"bark_texture\": \"halus saat muda, menjadi kasar seiring usia\", \"cone_size\": \"medium\"}', '2025-07-16 05:50:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinus_images`
--

CREATE TABLE `pinus_images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `status` enum('pending','processed','failed') DEFAULT 'pending',
  `detected_objects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `pinus_images`
--

INSERT INTO `pinus_images` (`id`, `filename`, `original_name`, `file_path`, `file_size`, `mime_type`, `image_width`, `image_height`, `upload_date`, `description`, `status`, `detected_objects`, `confidence_score`, `processing_notes`, `created_at`, `updated_at`) VALUES
(14, 'pinus_687759a031baa_1752652192.jpg', 'pino-silvestre-pinus-sylvestris.jpg', 'uploads/pinus_687759a031baa_1752652192.jpg', 1813200, 'image/jpeg', 1000, 1000, '2025-07-16 07:49:52', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:49:52', '2025-07-16 07:49:52'),
(11, 'pinus_6877564000b8b_1752651328.jpeg', 'images.jpeg', 'uploads/pinus_6877564000b8b_1752651328.jpeg', 13837, 'image/jpeg', 259, 194, '2025-07-16 07:35:28', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:35:28', '2025-07-16 07:35:28'),
(12, 'pinus_687757b9cb4e7_1752651705.jpg', 'pino_silvestre.jpg', 'uploads/pinus_687757b9cb4e7_1752651705.jpg', 176857, 'image/jpeg', 768, 512, '2025-07-16 07:41:45', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:41:45', '2025-07-16 07:41:45'),
(10, 'pinus_6877561f58fdb_1752651295.jpg', 'pinus_687741e3b2627_1752646115.jpg', 'uploads/pinus_6877561f58fdb_1752651295.jpg', 305292, 'image/jpeg', 1600, 900, '2025-07-16 07:34:55', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:34:55', '2025-07-16 07:34:55'),
(13, 'pinus_6877595d0d6de_1752652125.jpeg', '3lz6vg63c90bqup.jpeg', 'uploads/pinus_6877595d0d6de_1752652125.jpeg', 87539, 'image/jpeg', 534, 800, '2025-07-16 07:48:45', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:48:45', '2025-07-16 07:48:45'),
(9, 'pinus_687756034c9bd_1752651267.jpg', 'pino-silvestre-pinus-sylvestris.jpg', 'uploads/pinus_687756034c9bd_1752651267.jpg', 1813200, 'image/jpeg', 1000, 1000, '2025-07-16 07:34:27', '', 'processed', NULL, NULL, NULL, '2025-07-16 07:34:27', '2025-07-16 07:34:27'),
(15, 'pinus_6877c5f7c6887_1752679927.jpg', 'foto pinus(1).jpg', 'uploads/pinus_6877c5f7c6887_1752679927.jpg', 17953, 'image/jpeg', 194, 259, '2025-07-16 15:32:07', '', 'processed', NULL, NULL, NULL, '2025-07-16 15:32:07', '2025-07-16 15:32:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rules`
--

CREATE TABLE `rules` (
  `id` int(11) NOT NULL,
  `Jenis_Pinus` varchar(50) NOT NULL,
  `kondisi` text NOT NULL,
  `cf_value` decimal(3,2) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `vision_analysis`
--

CREATE TABLE `vision_analysis` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `analysis_type` varchar(100) NOT NULL,
  `analysis_result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `vision_analysis`
--

INSERT INTO `vision_analysis` (`id`, `image_id`, `analysis_type`, `analysis_result`, `confidence_level`, `processing_time`, `algorithm_used`, `analysis_date`, `notes`) VALUES
(1, 1, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 05:15:23', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(2, 2, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 05:57:05', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(3, 3, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 05:57:18', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(4, 4, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 05:59:53', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(5, 5, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 06:08:35', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(6, 6, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Pinus Merkusii\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 06:23:16', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(7, 7, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.84999999999999997779553950749686919152736663818359375,\"bbox\":[100,100,200,200]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[50,300,150,400]}},\"predicted_species\":\"Douglas Fir\",\"confidence_score\":0.7800000000000000266453525910037569701671600341796875,\"processing_time\":2.5,\"algorithm_used\":\"Placeholder Algorithm\"}', '0.78', '2.500', 'Placeholder Algorithm', '2025-07-16 07:20:38', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(8, 8, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.8400000000000000799360577730112709105014801025390625,\"bbox\":[114,114,214,214]},\"bark\":{\"confidence\":0.729999999999999982236431605997495353221893310546875,\"bbox\":[54,304,154,404]}},\"predicted_species\":\"Pinus Strobus\",\"confidence_score\":0.83999999999999996891375531049561686813831329345703125,\"processing_time\":1.899999999999999911182158029987476766109466552734375,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.84', '1.900', 'Simulasi Hash Algorithm', '2025-07-16 07:31:54', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(9, 9, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.88000000000000000444089209850062616169452667236328125,\"bbox\":[118,118,218,218]},\"bark\":{\"confidence\":0.7399999999999999911182158029987476766109466552734375,\"bbox\":[58,308,158,408]}},\"predicted_species\":\"Douglas Fir\",\"confidence_score\":0.87999999999999989341858963598497211933135986328125,\"processing_time\":2.29999999999999982236431605997495353221893310546875,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.88', '2.300', 'Simulasi Hash Algorithm', '2025-07-16 07:34:27', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(10, 10, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.850000000000000088817841970012523233890533447265625,\"bbox\":[115,115,215,215]},\"bark\":{\"confidence\":0.77999999999999991562305012848810292780399322509765625,\"bbox\":[55,305,155,405]}},\"predicted_species\":\"White Pine\",\"confidence_score\":0.75,\"processing_time\":2,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.75', '2.000', 'Simulasi Hash Algorithm', '2025-07-16 07:34:55', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(11, 11, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.87000000000000010658141036401502788066864013671875,\"bbox\":[117,117,217,217]},\"bark\":{\"confidence\":0.78999999999999992450483432548935525119304656982421875,\"bbox\":[57,307,157,407]}},\"predicted_species\":\"White Pine\",\"confidence_score\":0.86999999999999999555910790149937383830547332763671875,\"processing_time\":2.20000000000000017763568394002504646778106689453125,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.87', '2.200', 'Simulasi Hash Algorithm', '2025-07-16 07:35:28', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(12, 12, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.8300000000000000710542735760100185871124267578125,\"bbox\":[103,103,203,203]},\"bark\":{\"confidence\":0.75,\"bbox\":[53,303,153,403]}},\"predicted_species\":\"White Pine\",\"confidence_score\":0.82999999999999996003197111349436454474925994873046875,\"processing_time\":1.8000000000000000444089209850062616169452667236328125,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.83', '1.800', 'Simulasi Hash Algorithm', '2025-07-16 07:41:45', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(13, 13, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.810000000000000053290705182007513940334320068359375,\"bbox\":[111,111,211,211]},\"bark\":{\"confidence\":0.7199999999999999733546474089962430298328399658203125,\"bbox\":[51,301,151,401]}},\"predicted_species\":\"White Pine\",\"confidence_score\":0.9099999999999999200639422269887290894985198974609375,\"processing_time\":1.600000000000000088817841970012523233890533447265625,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.91', '1.600', 'Simulasi Hash Algorithm', '2025-07-16 07:48:45', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(14, 14, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.8400000000000000799360577730112709105014801025390625,\"bbox\":[104,104,204,204]},\"bark\":{\"confidence\":0.7600000000000000088817841970012523233890533447265625,\"bbox\":[54,304,154,404]}},\"predicted_species\":\"Douglas Fir\",\"confidence_score\":0.7399999999999999911182158029987476766109466552734375,\"processing_time\":1.899999999999999911182158029987476766109466552734375,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.74', '1.900', 'Simulasi Hash Algorithm', '2025-07-16 07:49:52', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus'),
(15, 15, 'pinus_detection', '{\"detected_objects\":{\"leaf\":{\"confidence\":0.88000000000000000444089209850062616169452667236328125,\"bbox\":[118,118,218,218]},\"bark\":{\"confidence\":0.7399999999999999911182158029987476766109466552734375,\"bbox\":[58,308,158,408]}},\"predicted_species\":\"Douglas Fir\",\"confidence_score\":0.979999999999999982236431605997495353221893310546875,\"processing_time\":2.29999999999999982236431605997495353221893310546875,\"algorithm_used\":\"Simulasi Hash Algorithm\"}', '0.98', '2.300', 'Simulasi Hash Algorithm', '2025-07-16 15:32:07', 'Modul ini nantinya digunakan untuk proses pengenalan daun pohon pinus');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `datatraining`
--
ALTER TABLE `datatraining`
  ADD PRIMARY KEY (`IdData`);

--
-- Indeks untuk tabel `datatraining1`
--
ALTER TABLE `datatraining1`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `datauji`
--
ALTER TABLE `datauji`
  ADD PRIMARY KEY (`IdData`);

--
-- Indeks untuk tabel `diagnosis_history`
--
ALTER TABLE `diagnosis_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`IdKelas`);

--
-- Indeks untuk tabel `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `datatraining`
--
ALTER TABLE `datatraining`
  MODIFY `IdData` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `datatraining1`
--
ALTER TABLE `datatraining1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `datauji`
--
ALTER TABLE `datauji`
  MODIFY `IdData` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `diagnosis_history`
--
ALTER TABLE `diagnosis_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `IdKelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pinus_categories`
--
ALTER TABLE `pinus_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pinus_images`
--
ALTER TABLE `pinus_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `vision_analysis`
--
ALTER TABLE `vision_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
