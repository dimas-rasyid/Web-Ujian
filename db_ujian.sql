-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2026 pada 11.10
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ujian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `jurusan_id`, `nama`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 4, 'Pak Budi', 'admin', '$2y$12$hXVJjCPJrXfpNg2FPyAQ1un3Nd1Prjy409l12SITMZzxl5hgL6ISK', '2026-10-12 21:05:48', '2026-10-12 21:05:48'),
(2, 1, 'Dimas Habib', 'admin', '$2y$12$68CcTnylJa1NOInkq7hsw.8B30jHALGo6xN53.7FrCRf39YC/mzoW', '2026-10-12 21:07:26', '2026-10-12 21:07:26'),
(3, 1, 'Rina Wulandari', 'pengajar', '$2y$12$BSh9HpOU5uEIudyzNe1c5.OBUMG.Sc1DoHRBArX5jxJG4mFgC0B3y', '2026-10-12 21:07:26', '2026-10-12 21:07:26'),
(4, 1, 'Dedi Kurniawan', 'pengajar', '$2y$12$ZSpn5xoU/gupzusMwxJnDeJCp37LldsSadtDTm0yNAtP/kiH1BRqW', '2026-10-12 21:07:26', '2026-10-12 21:07:26'),
(5, 5, 'Fitriani Lestari', 'pengajar', '$2y$12$n3sbP5XPpBLkIkcfTmPJeOYvfzplCC6U6qgXLo1vOHXf.DAs7u5/u', '2026-10-12 21:07:27', '2026-10-12 21:07:27'),
(6, 5, 'Agus Prasetyo', 'pengajar', '$2y$12$0rPMl.SLHQKuWCFwVIpuXejPYhGIjQpOmZ.5Tc2jUkBUFoAewkt8C', '2026-10-12 21:07:27', '2026-10-12 21:07:27'),
(7, 2, 'Hendra Gunawan', 'pengajar', '$2y$12$9.MYsvQuRQF4OvcNM2XeLuRwDvkLkxOTZWHCgnMC7c1tBSXAnsTX6', '2026-10-12 21:07:27', '2026-10-12 21:07:27'),
(8, 2, 'Yuni Astuti', 'pengajar', '$2y$12$eqK2uV5.VAWynb22L4794er1ysSmWifbRp91Tuuqk/dWEM.DAkOZS', '2026-10-12 21:07:27', '2026-10-12 21:07:27'),
(9, 2, 'Eko Saputra', 'pengajar', '$2y$12$OMKDCG4dDBWEgHbVhiH9seE/Me9khIsgBWqpRcHv8BoLYVA/PFZey', '2026-10-12 21:07:28', '2026-10-12 21:07:28'),
(10, 5, 'Lina Marlina', 'pengajar', '$2y$12$3VvasktP67t6.Y8lVayIWOMhz8Ed/cxcxfUfWZwDGYyYhBpDQ39Ie', '2026-10-12 21:07:28', '2026-10-12 21:07:28'),
(11, 5, 'Wahyu Hidayat', 'pengajar', '$2y$12$sbFDWJBMt2mKygR8tjerxOHuf.pxLvm3XF0O9Y0cGAvsN3NCj2B4.', '2026-10-12 21:07:28', '2026-10-12 21:07:28'),
(12, 3, 'Sri Rahayu', 'pengajar', '$2y$12$vSSIWX0ABi7u54E5ZRxFouBbyy5AMupSsTneUgwmmeuiICqyLyK0K', '2026-10-12 21:07:28', '2026-10-12 21:07:28'),
(13, 3, 'Dwi Anggraini', 'pengajar', '$2y$12$qkg3F/hwoDGLakfvPKA7IuaC3OadPOq8yKogbCKT/BOZ/5eU/bYOq', '2026-10-12 21:07:28', '2026-10-12 21:07:28'),
(14, 3, 'Rudi Hartono', 'pengajar', '$2y$12$gCEKJkwY1c3FcrGffYJLgOB8IOT2HkGPxg77ZA6cSw002CMp6jiVC', '2026-10-12 21:07:29', '2026-10-12 21:07:29'),
(15, 3, 'Nia Kurnia', 'pengajar', '$2y$12$k7Pa6LxLRW807raTH9EqpObZREAuGTCFzi/Pr0EOTTddVpzc8IzhG', '2026-10-12 21:07:29', '2026-10-12 21:07:29'),
(16, 5, 'Teguh Wibowo', 'pengajar', '$2y$12$t/BP4pc512W07KPdzxsXDe41byoerbzG7lbxahbeocMBFKqLFuLkW', '2026-10-12 21:07:29', '2026-10-12 21:07:29'),
(17, 4, 'Siti Nurhaliza', 'pengajar', '$2y$12$LAt3HHZG24pIcbefKSlVQO9fM4p6mnj6nwFH.jQna2wLcJCxCuebq', '2026-10-12 21:07:29', '2026-10-12 21:07:29'),
(18, 4, 'Andi Firmansyah', 'pengajar', '$2y$12$cwg46AHUDtgMm4cAwwL17OvcEedQ1WTbfSbcvBltq35upTn707Pni', '2026-10-12 21:07:30', '2026-10-12 21:07:30'),
(19, 4, 'Maya Puspita', 'pengajar', '$2y$12$BMv0i2VvUMoYj4Tu1zWaRuZDFIN0Rgtlz6IEOmU6lOns6srv3nzWi', '2026-10-12 21:07:30', '2026-10-12 21:07:30'),
(20, 4, 'Joko Widodo', 'pengajar', '$2y$12$dZ6kbxKYfslTfyttCdIGl.Gh5GnxiMeDdUX684ziyyo1pR.kyRSXO', '2026-10-12 21:07:30', '2026-10-12 21:07:30'),
(21, 5, 'Lia Handayani', 'pengajar', '$2y$12$iids8X10saLOfLg.kxcHcenLpSUTlOz3E7Ktb.5j95ygOwDxrpaNm', '2026-10-12 21:07:30', '2026-10-12 21:07:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` bigint(20) UNSIGNED NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'RPL', '2026-10-12 21:05:47', '2026-10-12 21:05:47'),
(2, 'TJAT', '2026-10-12 21:05:47', '2026-10-12 21:05:47'),
(3, 'MP', '2026-10-12 21:05:47', '2026-10-12 21:05:47'),
(4, 'AKR', '2026-10-12 21:05:47', '2026-10-12 21:05:47'),
(5, 'UMUM', '2026-10-12 21:07:26', '2026-10-12 21:07:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `jurusan_id`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(2, 1, 'X RPL', '2026-10-12 21:06:23', '2026-10-12 21:06:23'),
(3, 1, 'XI RPL', '2026-10-12 21:06:30', '2026-10-12 21:06:30'),
(4, 1, 'XII RPL', '2026-10-12 21:06:36', '2026-10-12 21:06:36'),
(5, 2, 'X TJAT', '2026-10-12 21:09:10', '2026-10-12 21:09:10'),
(6, 2, 'XI TJAT', '2026-10-12 21:09:23', '2026-10-12 21:09:23'),
(7, 2, 'XII TJAT', '2026-10-12 21:09:29', '2026-10-12 21:09:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_10_12_092602_create_jurusan_table', 1),
(4, '2026_10_12_092603_create_guru_table', 1),
(5, '2026_10_12_092604_create_kelas_table', 1),
(6, '2026_10_12_092604_create_sesi_table', 1),
(7, '2026_10_12_092604_create_siswa_table', 1),
(8, '2026_10_12_092604_create_soal_table', 1),
(9, '2026_10_12_092605_create_jawaban_table', 1),
(10, '2026_10_12_092605_create_kunci_jawaban_table', 1),
(11, '2026_10_12_092605_create_nilai_table', 1),
(12, '2026_10_12_121458_create_opsi_soal_table', 1),
(13, '2026_10_12_161401_create_sesi_kelas_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` bigint(20) UNSIGNED NOT NULL,
  `sesi_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `skor` double DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'belum',
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `sesi_id`, `siswa_id`, `skor`, `status`, `started_at`, `finished_at`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 0, 'menunggu_koreksi', '2026-10-14 11:37:22', '2026-10-14 12:06:27', '2026-10-14 04:37:22', '2026-10-14 05:06:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `opsi_soal`
--

CREATE TABLE `opsi_soal` (
  `id_opsi` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `kode_opsi` varchar(255) NOT NULL,
  `teks_opsi` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `opsi_soal`
--

INSERT INTO `opsi_soal` (`id_opsi`, `soal_id`, `kode_opsi`, `teks_opsi`, `is_correct`, `created_at`, `updated_at`) VALUES
(165, 41, 'A', 'Pemrograman yang melibatkan penggunaan gambar dan video untuk menghasilkan aplikasi.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(166, 41, 'B', 'Pemrograman yang hanya menggunakan teks atau kode untuk membuat aplikasi, tanpa elemen multimedia lainnya.', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(167, 41, 'C', 'Pemrograman yang menggabungkan suara dan gambar untuk menampilkan aplikasi.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(168, 41, 'D', 'Pemrograman yang hanya digunakan untuk mengolah data berbentuk teks.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(169, 41, 'E', 'Pemrograman yang berfokus pada pembuatan aplikasi berbasis grafis.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(170, 42, 'A', 'Pustaka untuk membuat grafik 3D', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(171, 42, 'B', 'Pustaka untuk mengolah data', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(172, 42, 'C', 'Pustaka untuk membuat antarmuka grafis (GUI)', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(173, 42, 'D', 'Pustaka untuk manipulasi file', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(174, 42, 'E', 'Pustaka untuk membuat Web', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(175, 43, 'A', 'Tombol', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(176, 43, 'B', 'Kode', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(177, 43, 'C', 'Desain', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(178, 43, 'D', 'UI', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(179, 43, 'E', 'Link', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(180, 44, 'A', 'NumPy', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(181, 44, 'B', 'Matplotlib', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(182, 44, 'C', 'Rich', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(183, 44, 'D', 'Flask', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(184, 44, 'E', 'Django', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(185, 45, 'A', 'Top level container', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(186, 45, 'B', 'Intermediatecontainer', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(187, 45, 'C', 'Layoutmaanger', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(188, 45, 'D', 'Plugablelookandfeel', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(189, 45, 'E', 'InstantMessaging', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(190, 46, 'A', 'FlowLayout', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(191, 46, 'B', 'JLabel', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(192, 46, 'C', 'Jbutton', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(193, 46, 'D', 'JTextField', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(194, 46, 'E', 'JTextArea', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(195, 47, 'A', 'This', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(196, 47, 'B', 'Super', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(197, 47, 'C', 'Dinamic', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(198, 47, 'D', 'Static', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(199, 47, 'E', 'Extends', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(200, 48, 'A', 'Constructor', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(201, 48, 'B', 'Initializer', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(202, 48, 'C', 'Garbage Collector', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(203, 48, 'D', 'Inheritance', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(204, 48, 'E', 'Class', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(205, 49, 'A', 'Statement program', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(206, 49, 'B', 'Logika program', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(207, 49, 'C', 'Instruksi program', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(208, 49, 'D', 'Alur program', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(209, 49, 'E', 'Bytecode program', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(210, 50, 'A', 'java.awt', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(211, 50, 'B', 'javax.swing', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(212, 50, 'C', 'java.swing', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(213, 50, 'D', 'java.io', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(214, 50, 'E', 'java.lang', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(215, 51, 'A', 'UpperCase()', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(216, 51, 'B', 'LowerCase()', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(217, 51, 'C', 'toLowerCase()', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(218, 51, 'D', 'toUpperCase()', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(219, 52, 'A', 'Data Manipulation System', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(220, 52, 'B', 'Database Manipulation System', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(221, 52, 'C', 'Data Management System', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(222, 52, 'D', 'Database Management System', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(223, 53, 'A', 'Akses data lebih mudah dan cepat', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(224, 53, 'B', 'Dapat menangani data-data dalam jumlah besar', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(225, 53, 'C', 'Membuat pekerjaan menjadi kompleks', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(226, 53, 'D', 'Menghilangkan hasil duplikasi maupun inkonsistensi data', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(227, 54, 'A', 'Entitas', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(228, 54, 'B', 'Aktor', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(229, 54, 'C', 'Garis', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(230, 54, 'D', 'Atribut', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(231, 55, 'A', 'Satu ke banyak (one to many)', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(232, 55, 'B', 'One to Group', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(233, 55, 'C', 'Banyak kesatu ( many to one )', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(234, 55, 'D', 'Banyak ke banyak (many to many)', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(235, 56, 'A', 'GetDate', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(236, 56, 'B', 'DATEDIFF', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(237, 56, 'C', 'DATEADD', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(238, 56, 'D', 'DATENAME', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(239, 57, 'A', 'software database berbasis client-server', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(240, 57, 'B', 'proses transaksi', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(241, 57, 'C', 'koneksi ke server MySQL', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(242, 57, 'D', 'mengatur proses query', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(243, 58, 'A', 'administrator', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(244, 58, 'B', 'desainer', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(245, 58, 'C', 'system analyst', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(246, 58, 'D', 'end user', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(247, 59, 'A', 'menghapus database', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(248, 59, 'B', 'meng-copy data', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(249, 59, 'C', 'menampilkan data', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(250, 59, 'D', 'memperbarui data', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(251, 60, 'A', 'composite', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(252, 60, 'B', 'foreign', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(253, 60, 'C', 'candidate', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(254, 60, 'D', 'primary', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(255, 61, 'A', 'Kolom yang dapat berisi nilai duplikat.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(256, 61, 'B', 'Kolom yang digunakan untuk menghubungkan dua tabel yang berbeda.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(257, 61, 'C', 'Kolom yang nilainya unik untuk setiap record dan tidak boleh kosong.', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(258, 61, 'D', 'Kolom yang berfungsi untuk menyimpan data sementara.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(259, 62, 'A', 'Python', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(260, 62, 'B', 'Kotlin', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(261, 62, 'C', 'Dart', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(262, 62, 'D', 'JavaScript', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(263, 62, 'E', 'Swift', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(264, 63, 'A', 'Tidak mendukung hot reload', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(265, 63, 'B', 'Tidak mendukung animasi.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(266, 63, 'C', 'Mendukung pembuatan aplikasi hanya untuk iOS.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(267, 63, 'D', 'Memiliki performa hampir native.', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(268, 63, 'E', 'Tidak memiliki library bawaan.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(269, 64, 'A', 'StatelessWidget', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(270, 64, 'B', 'StatefulWidget', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(271, 64, 'C', 'Container', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(272, 64, 'D', 'Text', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(273, 64, 'E', 'Dart', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(274, 65, 'A', 'MaterialPageRoute', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(275, 65, 'B', 'Scaffold', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(276, 65, 'C', 'StatefulWidget', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(277, 65, 'D', 'Form', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(278, 65, 'E', 'HTML', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(279, 66, 'A', 'Sebuah framework yang digunakan untuk pengembangan aplikasi desktop', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(280, 66, 'B', 'Sebuah framework untuk pengembangan aplikasi mobile dan web menggunakan bahasa pemrograman Java', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(281, 66, 'C', 'Sebuah framework open-source yang digunakan untuk membangun aplikasi mobile, web, dan desktop dengan bahasa pemrograman Dart', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(282, 66, 'D', 'Sebuah library JavaScript untuk pengembangan aplikasi web', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(283, 66, 'E', 'Flutter bukanlah platform untuk pengembangan aplikasi hanya dengan Kotlin; Kotlin lebih terkait dengan pengembangan native Android.', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(284, 67, 'A', 'Pemrograman untuk aplikasi berbasis cloud', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(285, 67, 'B', 'Pemrograman untuk membuat aplikasi pada perangkat mobile seperti smartphone', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(286, 67, 'C', 'Pemrograman untuk perangkat desktop', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(287, 67, 'D', 'Pemrograman untuk sistem keamanan jaringan', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(288, 67, 'E', 'Pemrograman untuk alat IoT (Internet of Things)', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(289, 68, 'A', 'React Native', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(290, 68, 'B', 'Django', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(291, 68, 'C', 'Laravel', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(292, 68, 'D', 'Flask', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(293, 68, 'E', 'Spring Boot', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(294, 69, 'A', 'Native dibuat hanya untuk iOS, hybrid dibuat untuk Android', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(295, 69, 'B', 'Native dijalankan di browser, hybrid dijalankan di perangkat', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(296, 69, 'C', 'Native menggunakan bahasa bawaan platform, hybrid menggunakan teknologi web', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(297, 69, 'D', 'Native tidak memerlukan internet, hybrid memerlukan internet', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(298, 69, 'E', 'Native hanya dibuat menggunakan JavaScript', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(299, 70, 'A', 'radio button', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(300, 70, 'B', 'listbox', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(301, 70, 'C', 'checkbox', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(302, 70, 'D', 'button', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(303, 70, 'E', 'text', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(304, 71, 'A', 'image', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(305, 71, 'B', 'cover', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(306, 71, 'C', 'src', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(307, 71, 'D', 'width', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(308, 71, 'E', 'poster', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(309, 72, 'A', 'menentukan alamat halaman web yang akan memproses masukan dari form', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(310, 72, 'B', 'menentukana nama form', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(311, 72, 'C', 'menentukan metode kiriman yang dipakai', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(312, 72, 'D', 'menerima masukan berupa pilihan', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(313, 72, 'E', 'menandai atau mengatur nilai dari sebuah radio', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(314, 73, 'A', 'container', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(315, 73, 'B', 'border', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(316, 73, 'C', 'div', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(317, 73, 'D', 'margin', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(318, 73, 'E', 'padding', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(319, 74, 'A', '<style>', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(320, 74, 'B', '<link>', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(321, 74, 'C', '<script>', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(322, 74, 'D', '<css>', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(323, 74, 'E', '<stylesheet>', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(324, 75, 'A', '#class-name', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(325, 75, 'B', '.class-name', 1, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(326, 75, 'C', 'class-name', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(327, 75, 'D', '[class-name]', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(328, 75, 'E', '*class-name', 0, '2026-10-13 19:08:16', '2026-10-13 19:08:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `sesi` varchar(200) NOT NULL,
  `tgl_sesi` date NOT NULL,
  `token` varchar(255) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `durasi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sesi`
--

INSERT INTO `sesi` (`id_sesi`, `guru_id`, `judul`, `kategori`, `sesi`, `tgl_sesi`, `token`, `waktu_mulai`, `waktu_selesai`, `durasi`, `created_at`, `updated_at`) VALUES
(5, 3, 'STS', 'Konsentrasi RPL', 'Sesi 1', '2026-10-14', 'TPC6E', '11:24:00', '13:30:00', 90, '2026-10-13 17:41:57', '2026-10-13 21:24:46'),
(6, 7, 'STS', 'Konsentrasi TJAT', 'Sesi 1', '2026-10-14', '7UNJC', '08:30:00', '10:30:00', 90, '2026-10-13 17:42:49', '2026-10-13 17:42:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi_kelas`
--

CREATE TABLE `sesi_kelas` (
  `sesi_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sesi_kelas`
--

INSERT INTO `sesi_kelas` (`sesi_id`, `kelas_id`) VALUES
(5, 2),
(6, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `kelas_id`, `nisn`, `nama`, `password`, `created_at`, `updated_at`) VALUES
(1, 2, '0026923618', 'Andi Safitri Pratama', '$2y$12$bhKsqiiNRyRdkL/Ss9dXx..vyOV/hDHuLB1Jd0vHBR8fDIr3ViRTK', '2026-10-12 21:08:11', '2026-10-12 21:08:11'),
(2, 2, '0026551309', 'Andi Syahputra', '$2y$12$tEmXqaaG0Qk62pr/KriJx.JjUgTXlHNpsDZLJri8T2wHv3eaEPwPC', '2026-10-12 21:08:11', '2026-10-12 21:08:11'),
(3, 2, '0026012150', 'Bayu Wulandari', '$2y$12$8RPVjK7RNt1Xz783NH4Y0ev81sMimLgfGwPiMRAxmZc1MV4i9To2O', '2026-10-12 21:08:11', '2026-10-12 21:08:11'),
(4, 2, '0026117528', 'Dina Wijaya', '$2y$12$A/9xM0ikzdv.DYOZOEzB4eIxbBeU79Mbu0tqrplaeZmXksKWBrrnq', '2026-10-12 21:08:12', '2026-10-12 21:08:12'),
(5, 2, '0026526846', 'Eka Rahmawati', '$2y$12$Bxj6mY/2cJ7C2Ghe/5mJAO3Z6f3kO9s8OiXQ8bEyXx7GxNJEDJPEG', '2026-10-12 21:08:12', '2026-10-12 21:08:12'),
(6, 2, '0026845149', 'Fitri Wulandari Kurniawan', '$2y$12$Z7PfGQ3SpnulRGRhYLcm0OehPBiDvUtdFwMq7yb.dbwxnauUUcSPK', '2026-10-12 21:08:12', '2026-10-12 21:08:12'),
(7, 2, '0026642625', 'Hendra Aprilia Fauzi', '$2y$12$AP3FrSuZcrVdJz.ZqZhipezhlr1JbhgodsJ33iktZOHLjLGvGKlWW', '2026-10-12 21:08:12', '2026-10-12 21:08:12'),
(8, 2, '0026339006', 'Intan Setiawan', '$2y$12$IWFk7GOSoYzbOBfU6UQF.eP2p6CoxIVBxVwcN8892q6GOVR9YcFRe', '2026-10-12 21:08:13', '2026-10-12 21:08:13'),
(9, 2, '0026983239', 'Irfan Maulana', '$2y$12$Xzr42Yet3bz55RCvhEcS7.J9nroSrXvmkXDYNjvK053pkjSyN4IuC', '2026-10-12 21:08:13', '2026-10-12 21:08:13'),
(10, 2, '0026600608', 'Kevin Hakim', '$2y$12$vsjdVAeevg83ptt6WNR7Be18FwsQjSUD7YJSXDQJ6zbm.Ak6LkmfC', '2026-10-12 21:08:13', '2026-10-12 21:08:13'),
(11, 2, '0026159927', 'Kevin Utami', '$2y$12$wJZynRrttxgDQeBdKKXWPOql2II3YcrcnKwS8PljHP9.18zWBuhPa', '2026-10-12 21:08:13', '2026-10-12 21:08:13'),
(12, 2, '0026643439', 'Nadia Ningsih', '$2y$12$bqhvqfZiyBwAGt.mhvPtKeuMAhuIUac46ml31J552uMokzhDz.E0y', '2026-10-12 21:08:13', '2026-10-12 21:08:13'),
(13, 2, '0026403218', 'Nadia Setiawan', '$2y$12$dj4WhSyZM.wBM0vAGqHE9OujOL6a0/HHAoLanQHJLUdGE0UBABKLK', '2026-10-12 21:08:14', '2026-10-12 21:08:14'),
(14, 2, '0026848291', 'Naufal Rahmawati', '$2y$12$D8yOQ06xLzypqEUEF5HyjO1eEDCKv2RiyNuZVC4BK3hbeguh2wHRm', '2026-10-12 21:08:14', '2026-10-12 21:08:14'),
(15, 2, '0026726727', 'Nur Maulana Prasetyo', '$2y$12$6gBProwj33nUZt/ZJh555.9ka.W7Upwiww/ZKG3DvKBDWWAjGWVFG', '2026-10-12 21:08:14', '2026-10-12 21:08:14'),
(16, 2, '0026562837', 'Rani Hidayat', '$2y$12$rZTCHn2yPRlQBbG3MNgwwO4DPFe/av75n32518E3c1gqMCwyqh8ty', '2026-10-12 21:08:14', '2026-10-12 21:08:14'),
(17, 2, '0026483455', 'Reza Saputra', '$2y$12$z.0A1jZRL4ZZef7xXpqD2uciDjXhsbkY5uDqV97F5nEVU7b.lQ3Qa', '2026-10-12 21:08:15', '2026-10-12 21:08:15'),
(18, 2, '0026145144', 'Rina Nugroho Wijaya', '$2y$12$09FTg/8cAD.UGB12o2BUxuUEzJ/Iy4r5..p1bY6e2/YPdhNRTE8hW', '2026-10-12 21:08:15', '2026-10-12 21:08:15'),
(19, 2, '0026033269', 'Salsa Utami', '$2y$12$9GAG/p4nJ3BSHFKcjBDzM.ABLmHPReLummaAh8BvkfblM2IVJjqju', '2026-10-12 21:08:15', '2026-10-12 21:08:15'),
(20, 2, '0026715174', 'Syifa Utami', '$2y$12$3Lb/SiM4ewCLJzd.VDz5zuE8UyRHremk9EpLrDmqwRJ40OC3CWpU6', '2026-10-12 21:08:15', '2026-10-12 21:08:15'),
(21, 2, '0026493288', 'Yoga Setiawan Firmansyah', '$2y$12$UPX3u2DieYG9BrNWkUTnae2hqWuHglsFq/8BqO.OqQOioPITjbfou', '2026-10-12 21:08:16', '2026-10-12 21:08:16'),
(22, 3, '0025128947', 'Aditya Permata', '$2y$12$JHgl1xTTqw6Jc2UgwoNMuuU.LvviE13qO/X8s0DsShyd69keG3VKy', '2026-10-12 21:08:16', '2026-10-12 21:08:16'),
(23, 3, '0025209872', 'Aditya Wijaya', '$2y$12$FR8KHOwoAyobXwzma4EWoOxap/5VCirBQiqn7Rq2t45c4oqFxzT3O', '2026-10-12 21:08:16', '2026-10-12 21:08:16'),
(24, 3, '0025752727', 'Ahmad Permata', '$2y$12$3OHo3a9pD4rM3ZCQ9.Xe3u8Nayfl3VmdRAMpfrxFyKRQmQp2oLZy.', '2026-10-12 21:08:16', '2026-10-12 21:08:16'),
(25, 3, '0025716421', 'Ahmad Wijaya Prasetyo', '$2y$12$IvQ.BCw7R3LDMaSuno6GyuNQoMfukRCCpfbkv9OFoz.2AWnv7Pste', '2026-10-12 21:08:16', '2026-10-12 21:08:16'),
(26, 3, '0025731160', 'Alya Utami', '$2y$12$JSTR.XzgLL0kJ9wAlHlHROXSTDfMLJP.MsI2guMC8LVumVSPUuH.a', '2026-10-12 21:08:17', '2026-10-12 21:08:17'),
(27, 3, '0025510321', 'Anisa Santoso Hidayat', '$2y$12$WQa3fhqswdnMCQimyJDDRe7JBgm2G/aVQ..dZj0QxbYdGRe41lb7y', '2026-10-12 21:08:17', '2026-10-12 21:08:17'),
(28, 3, '0025611658', 'Arif Santoso Utami', '$2y$12$vkBievXdf0ws3P1HTy.h6uBw0zQDTMtrjMIy6uXbJDPVisy0X0HiC', '2026-10-12 21:08:17', '2026-10-12 21:08:17'),
(29, 3, '0025907738', 'Aulia Prasetyo Syahputra', '$2y$12$qr82oyNbbyd.klJp0zlKheBxJL05.AVPFSMj0j/2WWD8HyvxlVhPS', '2026-10-12 21:08:17', '2026-10-12 21:08:17'),
(30, 3, '0025511712', 'Ayu Wulandari', '$2y$12$GNj7H.SOEakztwguvnaWeuQXo.XVzGUgEgzuiTNzFVKXdhi4d7q92', '2026-10-12 21:08:18', '2026-10-12 21:08:18'),
(31, 3, '0025191837', 'Bayu Ningsih', '$2y$12$cQw8VuGeRW6YoyR4FCxw3.GD.cEefLi3RAtlwzAySgSsqWo5C7bIe', '2026-10-12 21:08:18', '2026-10-12 21:08:18'),
(32, 3, '0025305821', 'Citra Permata', '$2y$12$of48L.vyb95dTH4u15g/kOabz7bnla6stITSVXfAaYQPloTLIaNL.', '2026-10-12 21:08:18', '2026-10-12 21:08:18'),
(33, 3, '0025058538', 'Citra Santoso Syahputra', '$2y$12$aJzARMz0j/i9saBATQhGU.NqxhG2WQqsECD73hnb0AKRmizAo6yue', '2026-10-12 21:08:18', '2026-10-12 21:08:18'),
(34, 3, '0025063167', 'Eka Anggraini', '$2y$12$JM.zZBzi/kz1ctPaNHWLkeADSbY6mlhYKRwC953LY60eCkOwah/Y.', '2026-10-12 21:08:18', '2026-10-12 21:08:18'),
(35, 3, '0025033800', 'Eko Firmansyah', '$2y$12$sKIh3rU7Coy7hwKXthRva.Hlfue7cC.FmHBLfxhYBQfBPq8jX5mt6', '2026-10-12 21:08:19', '2026-10-12 21:08:19'),
(36, 3, '0025485131', 'Fajar Hakim Utami', '$2y$12$tNBZuUBR6KcwoZ9QRdRcGeLDS3HQcBYeIYg7ejlJkZk.RrJUxvNfK', '2026-10-12 21:08:19', '2026-10-12 21:08:19'),
(37, 3, '0025749239', 'Irfan Utami', '$2y$12$A56DuAFkrveAHD85qTfUUucDbncqILPX1XdSFm/CcDQzv3NUpJ7sO', '2026-10-12 21:08:19', '2026-10-12 21:08:19'),
(38, 3, '0025677442', 'Joko Hakim', '$2y$12$wAWqo9b/K6wfBVRBmLFQZOoSrsY406AbdHyfA/Ut/CGH03AtCszRW', '2026-10-12 21:08:19', '2026-10-12 21:08:19'),
(39, 3, '0025590005', 'Maya Utami Wulandari', '$2y$12$KRG1PjBKDtHYNvUBTSmTGuo0.bvxou8lYeC4AnGXhWXHsppe4ghya', '2026-10-12 21:08:20', '2026-10-12 21:08:20'),
(40, 3, '0025227230', 'Nadia Setiawan Hakim', '$2y$12$kRLDA34F4ZVKZSSCE/b0IucsNjyr6NJGEgE1CzTuGp1W2SiIxIUSy', '2026-10-12 21:08:20', '2026-10-12 21:08:20'),
(41, 3, '0025103096', 'Putri Anggraini', '$2y$12$5NG9uIVFAQwltXgaOFc7Led7Y0TpQ1DpLcXG0MVGrefxEZ6iLnYXy', '2026-10-12 21:08:20', '2026-10-12 21:08:20'),
(42, 3, '0025954177', 'Rina Ramadhan', '$2y$12$gVe8jE.bsozk5nqnShLiuu6Xxl/qxxAb4MwDlxs1WoaRZNWSvhlrm', '2026-10-12 21:08:20', '2026-10-12 21:08:20'),
(43, 3, '0025511144', 'Rizky Fauzi', '$2y$12$gcFpxi9bTiZcFRikJ1FPb.SxCf9mXcF87J9H6dgnixx0A5i7fzHbq', '2026-10-12 21:08:21', '2026-10-12 21:08:21'),
(44, 3, '0025271306', 'Rizky Kurniawan', '$2y$12$A71rKZTMiCpJpas6KdlcU.Lsx9xYR7iKm4hZsb7tFkNTCx3B2YOXa', '2026-10-12 21:08:21', '2026-10-12 21:08:21'),
(45, 3, '0025715393', 'Tika Ningsih', '$2y$12$ZkUAWymxQc9mDPf5NyLK4eeBBlUuzDpHzpc7FSJMtuSFFm1A1TtM6', '2026-10-12 21:08:21', '2026-10-12 21:08:21'),
(46, 3, '0025675244', 'Tika Putra', '$2y$12$6.t4gGEIbyb.Pj8X.b.RK.UM/zBb9u0Zvkr9Nv.LsixxF1cPjBFVa', '2026-10-12 21:08:21', '2026-10-12 21:08:21'),
(47, 3, '0025468252', 'Wahyu Fauzi', '$2y$12$JGjx9ZyPk1Z9hMOelsonh.VpQ.dSwljtIhANTbDB/XN7OJ1e4Y38S', '2026-10-12 21:08:21', '2026-10-12 21:08:21'),
(48, 3, '0025889490', 'Zahra Hakim Putra', '$2y$12$qOeZpRd0yZLR0AfyrltH1uEEEDJC27fO/twIydONzKVk6/itVCGZu', '2026-10-12 21:08:22', '2026-10-12 21:08:22'),
(49, 4, '0024631837', 'Aditya Aprilia Rahmawati', '$2y$12$Na3Zv3rl7AggrmPY9wVgo.S7O1.vQZFHRyBgh9iy9JuCLBwQu6LpS', '2026-10-12 21:08:22', '2026-10-12 21:08:22'),
(50, 4, '0024572440', 'Aditya Firmansyah Putra', '$2y$12$XBbVL1LLXsMWWL7dZ0WSDuqP3idIx2nY40qrBdcvV4pRBy5FHiSBC', '2026-10-12 21:08:22', '2026-10-12 21:08:22'),
(51, 4, '0024160324', 'Aditya Putra Ningsih', '$2y$12$ql5Q1x99rEW2UEBnAAQvveo8q53qyPBQYAwd70mgQ4G9ARc.epnkG', '2026-10-12 21:08:22', '2026-10-12 21:08:22'),
(52, 4, '0024020220', 'Alya Lestari', '$2y$12$Y1UWEJu.kPUbE3OTH8gc5.SRpXLXiqvQAVONcyjCrvZBLd0vSlq9q', '2026-10-12 21:08:23', '2026-10-12 21:08:23'),
(53, 4, '0024710615', 'Alya Maulana Saputra', '$2y$12$/5EbLqT/wmkD0pGcGqZwLudSLUpWnVrbOG1wqNfdyPB2Ak9b5oQmm', '2026-10-12 21:08:23', '2026-10-12 21:08:23'),
(54, 4, '0024212499', 'Bayu Anggraini Hidayat', '$2y$12$7y3IzJcIuJkdUh9ORdfOUux4zVvtrmYI3elTkO9mWgQHfAhIA7DsS', '2026-10-12 21:08:23', '2026-10-12 21:08:23'),
(55, 4, '0024460988', 'Budi Firmansyah', '$2y$12$S.ze.duR5j9ihqQOLpDV4u2BYggf5h2Q0yWXEUwLaXIOocu6COdgW', '2026-10-12 21:08:23', '2026-10-12 21:08:23'),
(56, 4, '0024744543', 'Citra Putra Safitri', '$2y$12$rMVef5ThKZ18nEpvSopJYOi1GD1xU9EQ/VowRkX1XC2q8tWPwyIXq', '2026-10-12 21:08:24', '2026-10-12 21:08:24'),
(57, 4, '0024778647', 'Dedi Setiawan Santoso', '$2y$12$d/7bSp3gNhtu0ewn2uQlhuKDp49S2CvMNsAIZLHH4Bpw3fUFL7igm', '2026-10-12 21:08:24', '2026-10-12 21:08:24'),
(58, 4, '0024878702', 'Dewi Anggraini', '$2y$12$oRPbVURVrxLvfUfKziFe1.UF/rw/G44tBCoHJEu1YrBXmwxnaRPg2', '2026-10-12 21:08:24', '2026-10-12 21:08:24'),
(59, 4, '0024652216', 'Dimas Firmansyah Aprilia', '$2y$12$C/Huk4oQqzmgza3JjNltyOoM66XZh8QB3CdfYg74YqM46RfSUomFm', '2026-10-12 21:08:24', '2026-10-12 21:08:24'),
(60, 4, '0024123038', 'Hendra Nugroho Hidayat', '$2y$12$r3e1F7r97Icx.zeMe3zW7etJEeNdfARpmczcGuheo3Q6cQbqYe3aG', '2026-10-12 21:08:25', '2026-10-12 21:08:25'),
(61, 4, '0024358911', 'Irfan Rahmawati', '$2y$12$ch63xy9YAIwsviDJOGluw.ROum05gbHAOPInSmaPXbdP3L7y7IZuO', '2026-10-12 21:08:25', '2026-10-12 21:08:25'),
(62, 4, '0024126396', 'Joko Hidayat', '$2y$12$fbvFXU/keFcODEa9Lzg97uvHhfgX8n5t29JTfMUOTEIqxO9vkqPuy', '2026-10-12 21:08:25', '2026-10-12 21:08:25'),
(63, 4, '0024329746', 'Maya Fauzi', '$2y$12$XbenbYNhP8/KsvPF4uHyvebSh6bDLJEtw7KkuJHkQ8.JUeMIX8xki', '2026-10-12 21:08:25', '2026-10-12 21:08:25'),
(64, 4, '0024083774', 'Naufal Lestari', '$2y$12$GBq/W/zhpBVEJuZ0wlAJGOQ.asA/DqTStkIYOqZkg1mbZ3q809mYC', '2026-10-12 21:08:25', '2026-10-12 21:08:25'),
(65, 4, '0024018186', 'Naufal Ramadhan Wijaya', '$2y$12$KeE9.fANRSY.H9T8SejjROPcq.OzUzdpO9wgknSusAiM1uWI0Ij4m', '2026-10-12 21:08:26', '2026-10-12 21:08:26'),
(66, 4, '0024899765', 'Putri Fauzi', '$2y$12$iqYYbrzDZRR/wyucoWSY.eC1MTPhNw4aoA40N25NayTeIAAdfV9Ge', '2026-10-12 21:08:26', '2026-10-12 21:08:26'),
(67, 4, '0024994985', 'Rizky Hidayat', '$2y$12$6DIUU2/5WdP8tMebMk3cduDgFfxvD4i9suxlRWsKIyeO28dgT0IH2', '2026-10-12 21:08:26', '2026-10-12 21:08:26'),
(68, 4, '0024795949', 'Salsa Firmansyah Aprilia', '$2y$12$bNgjFGZgWacA3jKaIhl/Se0oJwzjTwbExLa9a3sBs4UzJFGur9hm.', '2026-10-12 21:08:26', '2026-10-12 21:08:26'),
(69, 4, '0024878588', 'Salsa Wulandari', '$2y$12$h7Px22/CPa.i3FJ5m9xUhOeVluq9r/Oi.EmMeiLjogmXQsubcwSeS', '2026-10-12 21:08:27', '2026-10-12 21:08:27'),
(70, 4, '0024283821', 'Syifa Prasetyo', '$2y$12$dldctdM4SJ3H8eCK/pVj7.yA1kqlNrVnFjwMEuvmvDGYOYISyUgRi', '2026-10-12 21:08:27', '2026-10-12 21:08:27'),
(71, 4, '0024139358', 'Wulan Ramadhan', '$2y$12$UjseJAAazGajn6im5X97tOeCPhWdhj/UJcAgwAycBGL3vNoNnn74.', '2026-10-12 21:08:27', '2026-10-12 21:08:27'),
(72, 4, '0024595215', 'Yoga Nugroho Wijaya', '$2y$12$/SFvj5iugp6r35NDJK7ZfuMYdau9MvtOeVsb6Swgwdu3t1TUTUI1y', '2026-10-12 21:08:27', '2026-10-12 21:08:27'),
(74, 5, '0026685806', 'Ahmad Firmansyah', '$2y$12$0YUCrSXisinBq7xTy3kOMOvb7RQcg175KRD56vp3ga7PFdOgIABlG', '2026-10-12 21:10:42', '2026-10-12 21:10:42'),
(75, 5, '0026867128', 'Alya Kurniawan Saputra', '$2y$12$kEI41aS8OTntTkRt1Otie.HCT5YG4mc6wNnDROkYAPIqU9lzJc1Ry', '2026-10-12 21:10:42', '2026-10-12 21:10:42'),
(76, 5, '0026666841', 'Anisa Hakim', '$2y$12$yOZo9R/UkIf1/xAllKC.0.AZNaLM1pgocmIpPYpDyLyp5qhD0.3Ma', '2026-10-12 21:10:42', '2026-10-12 21:10:42'),
(77, 5, '0026466576', 'Budi Maulana', '$2y$12$FYDTwumNY2SKR67bpQ5mw.VidiuiSf0FIHV1/79cxUY3iuAyBIVwm', '2026-10-12 21:10:42', '2026-10-12 21:10:42'),
(78, 5, '0026547724', 'Budi Saputra Utami', '$2y$12$.kfK9InrQbFJ8DRLYhbMguvbr7U60nagX0POya4qSH8rfgCPt9XZW', '2026-10-12 21:10:43', '2026-10-12 21:10:43'),
(79, 5, '0026488628', 'Dedi Hakim Wulandari', '$2y$12$Kh6by7SjkjmkmWSJQfUGk.MzsOIDDD/Y0xAM3R6qZipIFNQQGDBzu', '2026-10-12 21:10:43', '2026-10-12 21:10:43'),
(80, 5, '0026347635', 'Dimas Anggraini Rahmawati', '$2y$12$6IEL6IrBllDtzYJ5cfc.IO4s4qwqaL6iI4Q1gLkVENt1ekGmUZWJC', '2026-10-12 21:10:43', '2026-10-12 21:10:43'),
(81, 5, '0026416150', 'Dina Rahmawati', '$2y$12$h/5LeCa9PSf8V12N3aaxcuFTNnYMbPQfSx6io4R1NIqGQyAdtZS.S', '2026-10-12 21:10:43', '2026-10-12 21:10:43'),
(82, 5, '0026197716', 'Eko Nugroho', '$2y$12$Ff5Gd6WEHcWQxQcgUzj2AOWuTsFf8gXgny5Ock0CTmbo2t1eHszLi', '2026-10-12 21:10:44', '2026-10-12 21:10:44'),
(83, 5, '0026911739', 'Fitri Santoso', '$2y$12$JBzS4afSed4z6BG8/Oy8rOtzRT/ppZx6VM/0JjeTROsOK48ZemDBu', '2026-10-12 21:10:44', '2026-10-12 21:10:44'),
(84, 5, '0026868473', 'Galih Setiawan Maulana', '$2y$12$UH1Wa/afatzqdoGy.dHQnOZ.1VwCM37xmfyVeffSC14plZUKh.6NO', '2026-10-12 21:10:44', '2026-10-12 21:10:44'),
(85, 5, '0026782434', 'Irfan Pratama Firmansyah', '$2y$12$ii624dQplcUr3xQvHxrNEeJ/dJq2zTnZcMNVRTV9Y4P85TwlI.Eya', '2026-10-12 21:10:44', '2026-10-12 21:10:44'),
(86, 5, '0026778101', 'Naufal Kurniawan', '$2y$12$nXj0/vJ3l9G6kMtVXI.eAeBfXn63VWueiDoVK7D5RxxEPOgX/56nC', '2026-10-12 21:10:45', '2026-10-12 21:10:45'),
(87, 5, '0026621369', 'Nur Hakim', '$2y$12$vPnJFWTuXi2oR6FumAGyEusaBut86WvseKzCufUxMZmeLLB8/VXQq', '2026-10-12 21:10:45', '2026-10-12 21:10:45'),
(88, 5, '0026318257', 'Rani Saputra', '$2y$12$ynIr7XwzCPwBMLizihJca.JCanM5tPBDtk90uPmt/RgNWEv/1bPV.', '2026-10-12 21:10:45', '2026-10-12 21:10:45'),
(89, 5, '0026498838', 'Reza Prasetyo Setiawan', '$2y$12$TNI/AHEAplniu9vAwPhbwuYavqgx6nCMAcWudjfFSdvwAYSBjBwdG', '2026-10-12 21:10:45', '2026-10-12 21:10:45'),
(90, 5, '0026201567', 'Reza Santoso Maulana', '$2y$12$WXx1rE8jnwCC0oQy0s0TWuJ.1wNtlWDTw76KvfsLBxPX95sORpjAC', '2026-10-12 21:10:46', '2026-10-12 21:10:46'),
(91, 5, '0026193573', 'Syifa Anggraini Lestari', '$2y$12$qhP60ZcoOE/TdDtVZx50qurCdeL2iIKPUUJvXicb1O7OTfUCQoxf2', '2026-10-12 21:10:46', '2026-10-12 21:10:46'),
(92, 5, '0026304758', 'Vina Firmansyah', '$2y$12$Km6RyVpF.TjdG0Jvi/8Yc.NnuGKLAXAQ7yB4hO/g5xl3VIJr.jZrS', '2026-10-12 21:10:46', '2026-10-12 21:10:46'),
(93, 5, '0026491165', 'Wahyu Permata', '$2y$12$w3lZ02y7IfLOCDmIAwxZ3ePwuoS3WkX7hFr6gdpj/w46kevY88SPm', '2026-10-12 21:10:46', '2026-10-12 21:10:46'),
(94, 5, '0026132050', 'Wulan Lestari Ningsih', '$2y$12$ZIvFr98.vKxJI6oE425pOOrc4PC2w7xMD/CtHT6gw9hbT2cnE7Kum', '2026-10-12 21:10:46', '2026-10-12 21:10:46'),
(95, 6, '0025468212', 'Aditya Wulandari', '$2y$12$MFKLn4xSf3gVneAQtpBnx.8R2g/LV6sLDpxZtUUMrX/..Nb87M.Gq', '2026-10-12 21:10:47', '2026-10-12 21:10:47'),
(96, 6, '0025704342', 'Alya Safitri', '$2y$12$cXXSD.AobZ2F3BUWx6/T..bPM/GsPWD0/cuPsPSbk0qqLR/XrFmFm', '2026-10-12 21:10:47', '2026-10-12 21:10:47'),
(97, 6, '0025296282', 'Alya Wulandari Fauzi', '$2y$12$vDXV5Wn9Gb45uE12ABfEQ.Sa/BJW349JQFoeoV5ko7Obu4voDuh.m', '2026-10-12 21:10:47', '2026-10-12 21:10:47'),
(98, 6, '0025895927', 'Anisa Nugroho', '$2y$12$aOi7TJ2NI2wAXz88RQfn5.HjToCzE/1qjjV/KTl6XS6X7PiAIADVe', '2026-10-12 21:10:47', '2026-10-12 21:10:47'),
(99, 6, '0025697472', 'Arif Wijaya Santoso', '$2y$12$YrBv0vb.gTa3jbDAQzFPQ.RNVbxAinhGHJHFQD.G1ORSe49RP6jYa', '2026-10-12 21:10:48', '2026-10-12 21:10:48'),
(100, 6, '0025115167', 'Ayu Firmansyah Safitri', '$2y$12$K0bRng0apopdYMhk3OJPv.JBTo08vzo3OwP5KZDXBR5ake91CZS7C', '2026-10-12 21:10:48', '2026-10-12 21:10:48'),
(101, 6, '0025248742', 'Dedi Ningsih', '$2y$12$hz7jYq9wTP/hZN5v9GrRj.azV27LL8l8a12a7XLcRMD63ESTHOUpK', '2026-10-12 21:10:48', '2026-10-12 21:10:48'),
(102, 6, '0025288585', 'Dimas Santoso', '$2y$12$y6C1AgdPuMdOzJs41OZYVeGS1UkJqM6Y.46y5NkkGICS1aJDFCbjS', '2026-10-12 21:10:48', '2026-10-12 21:10:48'),
(103, 6, '0025158518', 'Eka Hidayat Utami', '$2y$12$lDDWb2W/l3c.hVrZXYbIHeEpy/9By9illD0VZa7e8Lhdow4kvlQaG', '2026-10-12 21:10:48', '2026-10-12 21:10:48'),
(104, 6, '0025825510', 'Galih Santoso', '$2y$12$w4ALss/KdMn/hMQcfUEa4OdA0Jx4Fs/zhMVfQPZFXCLYs1sW.7F1K', '2026-10-12 21:10:49', '2026-10-12 21:10:49'),
(105, 6, '0025808654', 'Hendra Ningsih Lestari', '$2y$12$9Ddyy5BKbEu4btDRVZny.u/YnwdED3tHbGDgiBDVYxhnxc8N0jvdG', '2026-10-12 21:10:49', '2026-10-12 21:10:49'),
(106, 6, '0025342674', 'Kevin Ningsih Anggraini', '$2y$12$bgvHsK80wsh9Up7B8YVkPuS21re7MQWL5H9RBPogLIeVmWIoBgerO', '2026-10-12 21:10:49', '2026-10-12 21:10:49'),
(107, 6, '0025553975', 'Lestari Hakim', '$2y$12$AUFf4JEdc5OCG3V3I0hGQOwZjdyxUZN5pcDAJQEkKSGyg2UyTj1pe', '2026-10-12 21:10:49', '2026-10-12 21:10:49'),
(108, 6, '0025427677', 'Lestari Syahputra Hidayat', '$2y$12$bR8lfUyRDubfCI80dvXGneIsJA.4rdvLlQZjnkGPtqKA9yzTnR/1i', '2026-10-12 21:10:50', '2026-10-12 21:10:50'),
(109, 6, '0025434785', 'Naufal Maulana', '$2y$12$ELb9l37smVpdlpknNvsLC.zZKbLXUEzuSi2wWfcUT6vmHufrb3W2G', '2026-10-12 21:10:50', '2026-10-12 21:10:50'),
(110, 6, '0025419474', 'Putri Lestari Hidayat', '$2y$12$ZOfYYy3gkxGf8UQnsLWOtuhD9rhmMHrU98S/5jS9jiRLpPX3t4b82', '2026-10-12 21:10:50', '2026-10-12 21:10:50'),
(111, 6, '0025675010', 'Rizky Saputra', '$2y$12$Qw0noJKuP8gqBl57TglA1OZkEM4epeg.I82aecVdkMz.iU7xMsO5K', '2026-10-12 21:10:50', '2026-10-12 21:10:50'),
(112, 6, '0025528315', 'Wulan Fauzi', '$2y$12$DaG6FZ2IUa.ORx/L7euYleHpMuacZ60Rrcd4H938g1W6.uwpgq42K', '2026-10-12 21:10:51', '2026-10-12 21:10:51'),
(113, 6, '0025706602', 'Wulan Rahmawati Permata', '$2y$12$9HCLYlQT2nq3axvaiie0UeEjcR3vvu0MldNRHvhLjzpBszIov3U1y', '2026-10-12 21:10:51', '2026-10-12 21:10:51'),
(114, 6, '0025742612', 'Yoga Kurniawan', '$2y$12$5ipANPduyEe4rmp2Eui8Y.72M6ZVgcOMlBVJKLLs0LpUq0mvWc54i', '2026-10-12 21:10:51', '2026-10-12 21:10:51'),
(115, 6, '0025773146', 'Zahra Firmansyah', '$2y$12$gZs.g92bh6AzB20nCzBWYO79sP7T.ctyLeL0oStht5BdXT9N2U.yy', '2026-10-12 21:10:51', '2026-10-12 21:10:51'),
(116, 7, '0024525916', 'Aditya Prasetyo', '$2y$12$7xasslHZlIn7tkzsgBPg7eWfuaxE86CUxXAXiTW9EAv9HXiIVu5LC', '2026-10-12 21:10:52', '2026-10-12 21:10:52'),
(117, 7, '0024833971', 'Ahmad Pratama', '$2y$12$kzxO31Z08tBj/3f/YqUlj.tfJHc3ot7ShNoIMlk3ZD3J06gGwgawi', '2026-10-12 21:10:52', '2026-10-12 21:10:52'),
(118, 7, '0024807941', 'Alya Wulandari', '$2y$12$0AqFiV5it5F8jszyYPuPPuQ3.Q3BsJYDD0mHS1WpMSbIU8gfTSMUK', '2026-10-12 21:10:52', '2026-10-12 21:10:52'),
(119, 7, '0024447305', 'Andi Utami', '$2y$12$x9M.8l/DLpaXOWRB4FpZYeWaWLNdAhc0N8udu7DSbWs6.sh8QbDBq', '2026-10-12 21:10:52', '2026-10-12 21:10:52'),
(120, 7, '0024849645', 'Anisa Santoso', '$2y$12$NxIk8KG8MIdMjMyf7aakReuYrYuY/qG.4eBfNfA8Gj1jb1gqNCU12', '2026-10-12 21:10:52', '2026-10-12 21:10:52'),
(121, 7, '0024959636', 'Arif Lestari', '$2y$12$flWs9f33Lh0zujfpYFF/...zEv0H7H06MjHvUW/55KClWWBo6YRaq', '2026-10-12 21:10:53', '2026-10-12 21:10:53'),
(122, 7, '0024610943', 'Aulia Firmansyah Safitri', '$2y$12$9YI5fjBqzCgxOrxbm5aI8eC6hCVaAJ734m2D/LZnjoV9FGdxYv4/m', '2026-10-12 21:10:53', '2026-10-12 21:10:53'),
(123, 7, '0024334697', 'Bagas Permata', '$2y$12$Ql8QMtNNO31GjdcLfqHNducs8n7BvK5Ip8jTWkxDQJy4XAGLKolqC', '2026-10-12 21:10:53', '2026-10-12 21:10:53'),
(124, 7, '0024883576', 'Budi Anggraini', '$2y$12$jwKIh67KRIa.UdRlEKfRkuhyNr4q5rOImTC14ih4MHFDT96Jnzv9a', '2026-10-12 21:10:53', '2026-10-12 21:10:53'),
(125, 7, '0024772098', 'Dewi Putra', '$2y$12$2fShbeFNoGpz6TNDNpgcZOu1MGm4RsnJrJnENVlPS/SBPCUXLX3Le', '2026-10-12 21:10:54', '2026-10-12 21:10:54'),
(126, 7, '0024632965', 'Dewi Safitri', '$2y$12$H7M4emKqSZKvwNAsajZ1OeFNcHSzlEsVsSsDFOpFH6DLyMMsvW0sq', '2026-10-12 21:10:54', '2026-10-12 21:10:54'),
(127, 7, '0024013784', 'Eko Setiawan', '$2y$12$PN/tFOsNy6NLY6jUfwSjE.d0eKxDeIwclpQ2O5WW73WChV0kG3bWW', '2026-10-12 21:10:54', '2026-10-12 21:10:54'),
(128, 7, '0024648398', 'Farhan Hidayat', '$2y$12$LIfK49qfGB.zRMM1ZfPJ7OH.qKceCGSeYUqSAjckx38ZWMphngk4O', '2026-10-12 21:10:54', '2026-10-12 21:10:54'),
(129, 7, '0024161524', 'Farhan Kurniawan', '$2y$12$uG1nQuZZrJ2SOTMvEhkDq.RZ1EUGNMj.qRo3ImW5k/N0ma/4rbsK2', '2026-10-12 21:10:54', '2026-10-12 21:10:54'),
(130, 7, '0024351503', 'Fikri Kurniawan', '$2y$12$2Aad4lOcX.KVftB693JXBuHg8yox156f5N3qNwUQQmhBAmF0fvjTa', '2026-10-12 21:10:55', '2026-10-12 21:10:55'),
(131, 7, '0024058292', 'Joko Hidayat Maulana', '$2y$12$VFesPbiH2i46H/oMoyn3wuCQ1DvlhYA0H3YUflRrFtb/4bUflrImm', '2026-10-12 21:10:55', '2026-10-12 21:10:55'),
(132, 7, '0024607473', 'Kevin Permata', '$2y$12$Y6uTt7tFGj3/NIBkVjoOuOvhcAZlCRr5/WunCI8CQUrMmgIh3Sn76', '2026-10-12 21:10:55', '2026-10-12 21:10:55'),
(133, 7, '0024110479', 'Lestari Fauzi Wulandari', '$2y$12$R27wdOpyqgizKYl9vk0YuuA3pD325LMuMbgABuUjOaP6WY7QG0XYa', '2026-10-12 21:10:55', '2026-10-12 21:10:55'),
(134, 7, '0024484221', 'Maya Lestari', '$2y$12$wNngU3LmbepcfRILHdXQyuTnLRg/rdfBGbtDFtG96YeiE6C3nvML6', '2026-10-12 21:10:56', '2026-10-12 21:10:56'),
(135, 7, '0024641245', 'Maya Rahmawati', '$2y$12$c/xnxilEbibMZ94i7Vs.repZHPMgKRtD1rxzCE4KPlfo5uh72t2cm', '2026-10-12 21:10:56', '2026-10-12 21:10:56'),
(136, 7, '0024758849', 'Nadia Putra Permata', '$2y$12$Z3u7coshoaUn7GQaM4LtUuSvUetft2xPUAwHbq3DETPYQBU1bbfUq', '2026-10-12 21:10:56', '2026-10-12 21:10:56'),
(137, 7, '0024014931', 'Nadia Putra Safitri', '$2y$12$eQhj6CSdM2PesmjxmBbfK.dv8mQ9sYBBSPn2LVXf/UAMl6OCNp/1C', '2026-10-12 21:10:56', '2026-10-12 21:10:56'),
(138, 7, '0024174630', 'Naufal Lestari Utami', '$2y$12$T8UhwT1BAzgQr65m71F9h.EFtgtkExuvvTbUkTDoykNeVdKYciul2', '2026-10-12 21:10:56', '2026-10-12 21:10:56'),
(139, 7, '0024274237', 'Rani Lestari Safitri', '$2y$12$h6xTFW/iw.i8mMlNboyXeOZ6evmZCvHmxXXPP/k1N5Y8TgWpn93vO', '2026-10-12 21:10:57', '2026-10-12 21:10:57'),
(140, 7, '0024736682', 'Rani Permata Wijaya', '$2y$12$dm3o39DP/r.YdB44X4/hiug4nevgDb8OBZxVX/9C39SIzjc5iYJ82', '2026-10-12 21:10:57', '2026-10-12 21:10:57'),
(141, 7, '0024538521', 'Reza Santoso', '$2y$12$b6Ry24jrtS7bk/3xpjuZG.Zz5OOV3BnozF2kIt2nnNjQV930M7RY6', '2026-10-12 21:10:57', '2026-10-12 21:10:57'),
(142, 7, '0024667108', 'Wulan Ningsih', '$2y$12$cvLy1hm7bWDi/RpBI0aBZu7tpSkwz4l9zkclHFjOk0jXRFtHj53SG', '2026-10-12 21:10:57', '2026-10-12 21:10:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` bigint(20) UNSIGNED NOT NULL,
  `sesi_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `pertanyaan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id_soal`, `sesi_id`, `tipe`, `pertanyaan`, `created_at`, `updated_at`) VALUES
(41, 5, 'Pilihan Ganda', 'Apa yang dimaksud dengan pemrograman berbasis teks?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(42, 5, 'Pilihan Ganda', 'Apa itu Tkinter dalam Python?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(43, 5, 'Pilihan Ganda', 'Berikut yang termasuk kedalam komponen dasar antarmuka grafis adalah', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(44, 5, 'Pilihan Ganda', 'Apa pustaka Python yang sering digunakan untuk membuat grafik berbasis teks di terminal?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(45, 5, 'Pilihan Ganda', 'Frame, Dialog, dan Applet yang diimplementasikan berupa classJFrame, Dialog, dan JApplet merupakan contoh dari ........', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(46, 5, 'Pilihan Ganda', 'Komponen yang berfungsi untuk menampilkan suatu teks di GUI disebut', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(47, 5, 'Pilihan Ganda', 'Keyword pada java yang digunakan untuk mengaplikasikan konsep pewarisan adalah…', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(48, 5, 'Pilihan Ganda', 'Suatu method yang dapat dijalankan otomatis pada saat object dari class dibuat, dikenal dengan ..', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(49, 5, 'Pilihan Ganda', 'Pada pemrograman java, file yang berekstensi class (nama_file.class) sebenarnya berisikan:', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(50, 5, 'Pilihan Ganda', 'Java mendefinisikan class String dalam pacakage', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(51, 5, 'Pilihan Ganda', 'Untuk mengonversi semua karakter di dalam objek string menjadi huruf kapital menggunakan method', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(52, 5, 'Pilihan Ganda', 'DBMS adalah singkatan dari', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(53, 5, 'Pilihan Ganda', 'Dibawah ini adalah salah satu tujuan atau manfaat penggunaan DBMS, Kecuali', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(54, 5, 'Pilihan Ganda', 'Yang tidak termasuk kedalam Atribut dasar ERD yang digunakan adalah', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(55, 5, 'Pilihan Ganda', 'Macam-macam kardinalitas kecuali?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(56, 5, 'Pilihan Ganda', 'Fungsi tanggal pada bahasa SQL yang digunakan untuk mengkalkulasi angka datepart antara dua tanggal adalah', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(57, 5, 'Pilihan Ganda', 'Apa yang dimaksud dengan MySQL', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(58, 5, 'Pilihan Ganda', 'Pengguna basis data yang membutuhkan akses ke database melalui query disebut …………….', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(59, 5, 'Pilihan Ganda', 'UPDATE adalah perintah SQL yang digunakan untuk …………..', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(60, 5, 'Pilihan Ganda', 'Dalam sebuah model relasional, relationship antartabel dibentuk oleh ……….. Key', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(61, 5, 'Pilihan Ganda', 'Manakah dari berikut ini yang merupakan contoh dari \"Primary Key\" dalam basis data?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(62, 5, 'Pilihan Ganda', 'Bahasa pemrograman apa yang digunakan untuk mengembangkan aplikasi dengan Flutter?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(63, 5, 'Pilihan Ganda', 'Manakah yang merupakan keunggulan Flutter?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(64, 5, 'Pilihan Ganda', 'Mana di antara berikut yang merupakan tipe widget yang digunakan untuk menangani status dalam Flutter?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(65, 5, 'Pilihan Ganda', 'Untuk melakukan navigasi ke halaman baru di Flutter, kita menggunakan method Navigator.push(). Method ini membutuhkan parameter kedua yang berupa:', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(66, 5, 'Pilihan Ganda', 'Apa yang dimaksud dengan Flutter?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(67, 5, 'Pilihan Ganda', 'Apa itu pemrograman perangkat bergerak?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(68, 5, 'Pilihan Ganda', 'Manakah framework berikut yang biasa digunakan untuk pengembangan aplikasi mobile?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(69, 5, 'Pilihan Ganda', 'Apa perbedaan utama antara aplikasi mobile native dan hybrid?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(70, 5, 'Pilihan Ganda', 'User dapat memilih lebuh dari satu pilihan pada halaman web merupakan kegunaan input jenis ……………….', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(71, 5, 'Pilihan Ganda', 'Memberikan tampilan awal video sebelum diklik play pada halaman HTML dapat menggunakan atibut ……………', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(72, 5, 'Pilihan Ganda', 'Atribut action digunakan untuk..............', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(73, 5, 'Pilihan Ganda', 'Garis tepi di sekelilingi padding dan konten pada css disebut................', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(74, 5, 'Pilihan Ganda', 'Manakah yang digunakan untuk menambahkan CSS secara internal pada sebuah dokumen HTML?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(75, 5, 'Pilihan Ganda', 'Manakah dari selektor berikut yang digunakan untuk memilih elemen berdasarkan class di CSS?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(76, 5, 'Essay', 'Dalam CSS, properti mana yang mengontrol jarak antara konten dan batas elemen (border)?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(77, 5, 'Essay', 'Apa efek dari properti CSS justify-content: center; dalam sebuah container dengan display flex?', '2026-10-13 19:08:16', '2026-10-13 19:08:16'),
(78, 5, 'Essay', 'Sebuah Framework PHP yang dapat mempercepat pengembang untuk membuat aplkasi php dinamis yang bersifat open source adalah….', '2026-10-13 19:08:16', '2026-10-13 19:08:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `guru_jurusan_id_foreign` (`jurusan_id`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `jawaban_siswa_id_foreign` (`siswa_id`),
  ADD KEY `jawaban_soal_id_foreign` (`soal_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kelas_jurusan_id_foreign` (`jurusan_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nilai_sesi_id_foreign` (`sesi_id`),
  ADD KEY `nilai_siswa_id_foreign` (`siswa_id`);

--
-- Indeks untuk tabel `opsi_soal`
--
ALTER TABLE `opsi_soal`
  ADD PRIMARY KEY (`id_opsi`),
  ADD KEY `opsi_soal_soal_id_foreign` (`soal_id`);

--
-- Indeks untuk tabel `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id_sesi`),
  ADD KEY `sesi_guru_id_foreign` (`guru_id`);

--
-- Indeks untuk tabel `sesi_kelas`
--
ALTER TABLE `sesi_kelas`
  ADD KEY `sesi_kelas_sesi_id_foreign` (`sesi_id`),
  ADD KEY `sesi_kelas_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `siswa_nisn_unique` (`nisn`),
  ADD KEY `siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `soal_sesi_id_foreign` (`sesi_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `opsi_soal`
--
ALTER TABLE `opsi_soal`
  MODIFY `id_opsi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT untuk tabel `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `opsi_soal`
--
ALTER TABLE `opsi_soal`
  ADD CONSTRAINT `opsi_soal_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sesi`
--
ALTER TABLE `sesi`
  ADD CONSTRAINT `sesi_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sesi_kelas`
--
ALTER TABLE `sesi_kelas`
  ADD CONSTRAINT `sesi_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `sesi_kelas_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
