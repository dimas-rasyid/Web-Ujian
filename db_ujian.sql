-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2026 pada 15.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.35

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
-- Struktur dari tabel `control`
--

CREATE TABLE `control` (
  `id_control` bigint(20) UNSIGNED NOT NULL,
  `sesi_id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(2, 1, 'Asep', 'pengajar', '$2y$12$3UB69t0TbSjZHtk2a250Oe2ch37tkyToUC8qMmG3z1M7KKyeGOe/6', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(3, 1, 'Dimas', 'admin', '$2y$12$lovYbGg6Vkk17gHCWPnLY.usJARhMyg7o767tDBtHLJYzLhAs64tG', '2026-11-08 01:12:25', '2026-11-08 01:12:25'),
(4, 1, 'Dimas Habib', 'admin', '$2y$12$LN/zRwjw/Vt05fgpaAGp6OJ6z1h.Gi3GShv36/Eu8xX7t272hEBze', '2026-11-09 02:21:03', '2026-11-09 02:21:03'),
(5, 1, 'Rina Wulandari', 'pengajar', '$2y$12$8SxKSXESuQ4gHnJOUcqiw.icvgWUH7MVqXPiLKCSzDgufCUl0X7fa', '2026-11-09 02:21:03', '2026-11-09 02:21:03'),
(6, 1, 'Dedi Kurniawan', 'pengajar', '$2y$12$LdFYJ502u5hwa7hinRW0MebHc/lN0DrPFyynOBJjDFFGh3S8GUpgG', '2026-11-09 02:21:03', '2026-11-09 02:21:03'),
(7, 6, 'Fitriani Lestari', 'pengajar', '$2y$12$JX1Scwagzr2LdxMQg63N9epNJQD2U9zdTROoGoQPu5.ue6AZyLLtK', '2026-11-09 02:21:03', '2026-11-09 02:21:03'),
(8, 6, 'Agus Prasetyo', 'pengajar', '$2y$12$QF1NtJi2r3dkiSXaay9MCOPQ0PJVwpxREqPlJAz.va9I/n/KEVgDa', '2026-11-09 02:21:04', '2026-11-09 02:21:04'),
(9, 6, 'Lina Marlina', 'pengajar', '$2y$12$hLJDGMLtMO3myNR4.36d4uuRWVczt1im8cXqgmHASTqdhP6MMKrwK', '2026-11-09 02:21:04', '2026-11-09 02:21:04'),
(10, 6, 'Wahyu Hidayat', 'pengajar', '$2y$12$WUpfq9hHb0ZPtqlEoUD3bepV6uac7E9gyVwFB5mtWYNkvqQjvKSHa', '2026-11-09 02:21:04', '2026-11-09 02:21:04'),
(11, 5, 'Sri Rahayu', 'pengajar', '$2y$12$GFLaXqpnLfdz0/8ayrBeceicjZyYRXPOxx2WOE6Dv89LjuMDZt.9i', '2026-11-09 02:21:04', '2026-11-09 02:21:04'),
(12, 5, 'Dwi Anggraini', 'pengajar', '$2y$12$I2NoFrvpxjn/WaQCta6bZeUGOR7q.otfC5vM8q5jE1UIG1v0s0PHG', '2026-11-09 02:21:04', '2026-11-09 02:21:04'),
(13, 5, 'Rudi Hartono', 'pengajar', '$2y$12$uvLN.gGmNWrQaMWSyZQCdOWPcgzGAuVqu31MyC1hiMZ5m5H9l1VVu', '2026-11-09 02:21:05', '2026-11-09 02:21:05'),
(14, 5, 'Nia Kurnia', 'pengajar', '$2y$12$5g0T9E5So9/2JZobQFxajuQsy2s5Fz8OMcJionjIQK1YyK6fG2t8m', '2026-11-09 02:21:05', '2026-11-09 02:21:05'),
(15, 6, 'Teguh Wibowo', 'pengajar', '$2y$12$TxNgcYppVJezZA98GucVQ.rNGeSn2u/ciiGq3FXdT1iG.zcVt2D9q', '2026-11-09 02:21:05', '2026-11-09 02:21:05'),
(16, 4, 'Siti Nurhaliza', 'pengajar', '$2y$12$P2GR0CxCs1LiTuHYFR2GseGxxt4tF6zsnns9HozqIp4RqLuS2FlDW', '2026-11-09 02:21:05', '2026-11-09 02:21:05'),
(17, 4, 'Andi Firmansyah', 'pengajar', '$2y$12$gzEX5u6EwIN1nuD.WkC4s.Y7pL6Cl26sFKMuUgN3Um96yBDQ2iYDy', '2026-11-09 02:21:05', '2026-11-09 02:21:05'),
(18, 4, 'Maya Puspita', 'pengajar', '$2y$12$z9i9qP5iQgJpDYj8QErshegZskGtTsRG/ImNmFVIu/RspE2XnEu.a', '2026-11-09 02:21:06', '2026-11-09 02:21:06'),
(19, 4, 'Joko Widodo', 'pengajar', '$2y$12$rfuRfwlatOtxgMzRcNWK8uIqkUkLnKtQgsOMCEAHqavHTDaFhyyom', '2026-11-09 02:21:06', '2026-11-09 02:21:06'),
(20, 6, 'Lia Handayani', 'pengajar', '$2y$12$fvFfN4VgN63kV1U17wPCNOXo9juFF4aFvmdWG/iApTUYFLVNbB68m', '2026-11-09 02:21:06', '2026-11-09 02:21:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` text NOT NULL,
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
(1, 'RPL', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(2, 'TJKT', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(3, 'DKV', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(4, 'AKR', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(5, 'MP', '2026-11-05 09:07:48', '2026-11-05 09:07:48'),
(6, 'UMUM', '2026-11-09 02:21:03', '2026-11-09 02:21:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `guru_id`, `jurusan_id`, `kelas`, `tingkat`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'X RPL', 'X', '2026-11-05 09:29:05', '2026-11-05 09:29:05'),
(2, 6, 1, 'XI RPL', 'XI', '2026-11-05 09:29:13', '2026-11-05 09:29:13'),
(3, 7, 1, 'XII RPL', 'XII', '2026-11-05 09:29:34', '2026-11-05 09:29:34'),
(4, 8, 2, 'X TJKT', 'X', '2026-11-09 13:04:11', '2026-11-09 13:04:11'),
(5, 9, 2, 'XI TJKT', 'XI', '2026-11-09 13:04:38', '2026-11-09 13:04:38'),
(6, 10, 2, 'XII TJKT', 'XI', '2026-11-09 13:04:49', '2026-11-09 13:04:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` bigint(20) UNSIGNED NOT NULL,
  `mapel` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `mapel`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Konsentrasi RPL', NULL, '2026-11-09 02:24:38', '2026-11-09 02:24:38'),
(2, 'Bahasa Indonesia', NULL, '2026-11-09 02:25:27', '2026-11-09 02:25:27'),
(3, 'Bahasa Inggris', NULL, '2026-11-09 02:25:41', '2026-11-09 02:25:41'),
(4, 'Matematika', NULL, '2026-11-09 02:25:46', '2026-11-09 02:25:46'),
(5, 'Bahasa Jawa', NULL, '2026-11-09 02:26:02', '2026-11-09 02:26:02'),
(6, 'IPAS', NULL, '2026-11-09 02:26:07', '2026-11-09 02:26:07'),
(7, 'Konsentrasi TJKT', '$2y$12$ZNknRPH1JQcD/YgR9jIKJ.J8qpnRqXZGvDwSOScIShD1j7RZ3Sd1W', '2026-11-09 13:56:26', '2026-11-09 13:56:26'),
(8, 'Kewirausahaan (PKK)', '$2y$12$FMb1KiKMnTwjd8DC7SxQLuVrFaBAThk5i/EvFrG095enCLwqNzyEi', '2026-11-09 13:56:30', '2026-11-09 13:56:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_guru`
--

CREATE TABLE `mapel_guru` (
  `id_mapgur` bigint(20) UNSIGNED NOT NULL,
  `id_guru` bigint(20) UNSIGNED NOT NULL,
  `id_mapel` bigint(20) UNSIGNED NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mapel_guru`
--

INSERT INTO `mapel_guru` (`id_mapgur`, `id_guru`, `id_mapel`, `tingkat`, `created_at`, `updated_at`) VALUES
(1, 15, 2, 'X', '2026-11-09 02:27:32', '2026-11-09 02:27:32'),
(2, 4, 1, 'X', NULL, NULL),
(3, 5, 1, 'X', NULL, NULL),
(4, 7, 2, 'X', NULL, NULL),
(5, 9, 3, 'X', NULL, NULL),
(6, 10, 4, 'X', NULL, NULL),
(7, 15, 6, 'X', NULL, NULL),
(8, 4, 1, 'XI', NULL, NULL),
(9, 5, 1, 'XI', NULL, NULL),
(10, 7, 2, 'XI', NULL, NULL),
(11, 9, 3, 'XI', NULL, NULL),
(12, 10, 4, 'XI', NULL, NULL),
(13, 15, 6, 'XI', NULL, NULL),
(14, 4, 1, 'XII', NULL, NULL),
(15, 5, 1, 'XII', NULL, NULL),
(16, 7, 2, 'XII', NULL, NULL),
(17, 9, 3, 'XII', NULL, NULL),
(18, 10, 4, 'XII', NULL, NULL),
(19, 20, 8, 'XII', NULL, NULL);

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
(3, '2026_11_05_153932_create_jurusan_table', 1),
(4, '2026_11_05_154006_create_jurusan_table', 1),
(5, '2026_11_05_154021_create_guru_table', 1),
(6, '2026_11_05_154040_create_kelas_table', 1),
(7, '2026_11_05_154348_create_mapel_guru_table', 1),
(8, '2026_11_05_154413_create_sesi_table', 1),
(9, '2026_11_05_154439_create_control_table', 1),
(10, '2026_11_05_154505_create_siswa_table', 1),
(11, '2026_11_05_154531_create_soal_table', 1),
(12, '2026_11_05_154555_create_opsi_soal_table', 1),
(13, '2026_11_05_154615_create_nilai_table', 1),
(14, '2026_11_05_154704_create_jawaban_table', 1),
(15, '2026_11_13_194722_add_guru_id_to_kelas_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` bigint(20) UNSIGNED NOT NULL,
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `skor` double NOT NULL DEFAULT 0,
  `skor_up` double NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'belum_mulai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `opsi_soal`
--

CREATE TABLE `opsi_soal` (
  `id_opsi` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `kode_opsi` varchar(255) NOT NULL,
  `text_opsi` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `sesi` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `durasi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `kelas_id`, `nisn`, `name`, `password`, `created_at`, `updated_at`) VALUES
(147, 1, '0026923618', 'Andi Safitri Pratama', '$2y$12$JAULfmh9f/nJDHQ70zkwbOEGjK6SLaeEQhIF80XYo4ZkV/8IAU43y', '2026-11-09 13:25:46', '2026-11-09 13:25:46'),
(148, 1, '0026551309', 'Andi Syahputra', '$2y$12$1yQu5KRpsuq2BO8rf8GGDuQzeQdibnS/TwDYfG.uqGgHLZom0H02a', '2026-11-09 13:25:46', '2026-11-09 13:25:46'),
(149, 1, '0026012150', 'Bayu Wulandari', '$2y$12$cHjclrHD5gvn.PIAV/MaC.wY4Vvva3lUtHAASwUzhxgmPahJ5cnDm', '2026-11-09 13:25:46', '2026-11-09 13:25:46'),
(150, 1, '0026117528', 'Dina Wijaya', '$2y$12$6gbhL2CCDhdkiEGgElX.BOqfNf2v5C82x7X5Vg0gagBEeo/NdQt2y', '2026-11-09 13:25:46', '2026-11-09 13:25:46'),
(151, 1, '0026526846', 'Eka Rahmawati', '$2y$12$Thar102d.Ye/93oI.931GO7tqFjONff7mKXcG/zwLgBwfplSOQP22', '2026-11-09 13:25:46', '2026-11-09 13:25:46'),
(152, 1, '0026845149', 'Fitri Wulandari Kurniawan', '$2y$12$4SNZiUc97sActU8d/o8.I.FzTKHBcsvaKE2iIVlzJuUd4knBROvYe', '2026-11-09 13:25:47', '2026-11-09 13:25:47'),
(153, 1, '0026642625', 'Hendra Aprilia Fauzi', '$2y$12$l6yzRhko9C1QpDR1h6UHkuhWe5pMeVP/ExcwJSVFUwIKa7RWb8Hn.', '2026-11-09 13:25:47', '2026-11-09 13:25:47'),
(154, 1, '0026339006', 'Intan Setiawan', '$2y$12$mDH67/qS9vx8pBb9dFB/E.OMRDOaQlx9RgPyH/OXKE2HuvB/BC/YK', '2026-11-09 13:25:47', '2026-11-09 13:25:47'),
(155, 1, '0026983239', 'Irfan Maulana', '$2y$12$PyOBLEwmsNK3fOe3Pfk5D.5B346NeKtuSXJ3AdUQg9l7dILTQZlIK', '2026-11-09 13:25:47', '2026-11-09 13:25:47'),
(156, 1, '0026600608', 'Kevin Hakim', '$2y$12$I9EnJgt8iCjdQUgMY69Rpuv9jLJjuxzKIVQctiU716cusn3OjQipe', '2026-11-09 13:25:47', '2026-11-09 13:25:47'),
(157, 1, '0026159927', 'Kevin Utami', '$2y$12$.O40mFJ/gvYhllGieJMo9.qFzU3e3yae6ddcWe1JlgJc61bmqqzHG', '2026-11-09 13:25:48', '2026-11-09 13:25:48'),
(158, 1, '0026643439', 'Nadia Ningsih', '$2y$12$WCdfSj/OqaCZc.jer.RDxuHR5yuefkSAwB9Qm/Qqca8Y27C6c2HNe', '2026-11-09 13:25:48', '2026-11-09 13:25:48'),
(159, 1, '0026403218', 'Nadia Setiawan', '$2y$12$wCIN0kKzOdtWMeDpvMighOxcx.cSoEuxJAbH1hrvhT.H4hECaAg7a', '2026-11-09 13:25:48', '2026-11-09 13:25:48'),
(160, 1, '0026848291', 'Naufal Rahmawati', '$2y$12$Nn/BDDZGOlSb5lq.7yg6lOZO9t2n3E47IGzrNEMbn6v5mzqkFRlZK', '2026-11-09 13:25:48', '2026-11-09 13:25:48'),
(161, 1, '0026726727', 'Nur Maulana Prasetyo', '$2y$12$iqMndM/WMbSxMrzJr0w/buum1tcjs9LKnOR4Dxnvq3LU8JacvDhxa', '2026-11-09 13:25:48', '2026-11-09 13:25:48'),
(162, 1, '0026562837', 'Rani Hidayat', '$2y$12$PEKp5iCsd8E922XNfhr.Bu/XmS95FQehB7gr7CiMaUzG6fghPHgHS', '2026-11-09 13:25:49', '2026-11-09 13:25:49'),
(163, 1, '0026483455', 'Reza Saputra', '$2y$12$rxLflV456o.aBzngpn18PunzFEqoqMT7v8Wlb2cMZeKbjQrK811.W', '2026-11-09 13:25:49', '2026-11-09 13:25:49'),
(164, 1, '0026145144', 'Rina Nugroho Wijaya', '$2y$12$0tpj6GmGvdG5VSgdFPrILO5dO3/kCPGNEbN4r4cWvTgFkA2JtGJpi', '2026-11-09 13:25:49', '2026-11-09 13:25:49'),
(165, 1, '0026033269', 'Salsa Utami', '$2y$12$l2KXeq3FfZ./AdlnzfiS8.nqDukQ5.xiA3uK1AtvdsaohLDq641L2', '2026-11-09 13:25:49', '2026-11-09 13:25:49'),
(166, 1, '0026715174', 'Syifa Utami', '$2y$12$Zu8g.GSNS9iuGzV55prEs.Jtc208pTXIDM2SxGeD/i0CzNsC5q5L6', '2026-11-09 13:25:49', '2026-11-09 13:25:49'),
(167, 1, '0026493288', 'Yoga Setiawan Firmansyah', '$2y$12$B68HEn0R6QskGbfggda28eSZ8xpy7pKCa8I9D4Nzs0y.i6IEQrXde', '2026-11-09 13:25:50', '2026-11-09 13:25:50'),
(168, 2, '0025128947', 'Aditya Permata', '$2y$12$rMVFKTWiY21XKbNwfxtuhe13Nr5ImV4HaXvilAfZvVpPeFB.WE4Ra', '2026-11-09 13:25:50', '2026-11-09 13:25:50'),
(169, 2, '0025209872', 'Aditya Wijaya', '$2y$12$VspusxEVnqfdeGRAadwVT..89j2RzO7igrOs80BwK3UW0TqwXUMpG', '2026-11-09 13:25:50', '2026-11-09 13:25:50'),
(170, 2, '0025752727', 'Ahmad Permata', '$2y$12$NULme5w/ct5Pu5xAn/A0pe8A8NscgKgJryAlOoI5K.Mqb7NtLVqvy', '2026-11-09 13:25:50', '2026-11-09 13:25:50'),
(171, 2, '0025716421', 'Ahmad Wijaya Prasetyo', '$2y$12$Gfy4/KjszFKB9PvTAuwxue8ug/cTAzCkE3uHhUVUtvdMRa9MmqejW', '2026-11-09 13:25:50', '2026-11-09 13:25:50'),
(172, 2, '0025731160', 'Alya Utami', '$2y$12$n8kpkhYiYw46sNFLlo1mReDhRcw4DWNdytk35S/2gYO8lLNb4Oq.W', '2026-11-09 13:25:51', '2026-11-09 13:25:51'),
(173, 2, '0025510321', 'Anisa Santoso Hidayat', '$2y$12$gepBvkf.7.gPPlFKpxPF1.lUXE8rm9sR8nl1i8MXXCVSyIAbNFHFO', '2026-11-09 13:25:51', '2026-11-09 13:25:51'),
(174, 2, '0025611658', 'Arif Santoso Utami', '$2y$12$oL4Bbc.MzSl7Aqu0x5P2rOyKPtne7D1YjN2ETQ8/sHe5plH6R4v8a', '2026-11-09 13:25:51', '2026-11-09 13:25:51'),
(175, 2, '0025907738', 'Aulia Prasetyo Syahputra', '$2y$12$n4ALyG8xzrV2tlbbc/za4Okk6eB8vxxDZ4uDdujfUi/gcO0GU/Tt.', '2026-11-09 13:25:51', '2026-11-09 13:25:51'),
(176, 2, '0025511712', 'Ayu Wulandari', '$2y$12$HVAruyF8UeOK/YtOb5uL1.krBHy9KoZJbmTBT.Ecf0AnrVWI3FEDe', '2026-11-09 13:25:51', '2026-11-09 13:25:51'),
(177, 2, '0025191837', 'Bayu Ningsih', '$2y$12$Hrf.EV3ntJrPFaxJp0Ov9OYF1TyJss1fJuLs6soXFGNx7Rskuc7km', '2026-11-09 13:25:52', '2026-11-09 13:25:52'),
(178, 2, '0025305821', 'Citra Permata', '$2y$12$n4okBpJ2dV1dkWyZp9IW0.jUri6UhlTGqtHlC7cPpZ/Br/2kbuNh2', '2026-11-09 13:25:52', '2026-11-09 13:25:52'),
(179, 2, '0025058538', 'Citra Santoso Syahputra', '$2y$12$fd4sxDNllhx8shJ1o0Wz/u8AfyxVXI54d80TvI9oyHd0ibnUOF6w6', '2026-11-09 13:25:52', '2026-11-09 13:25:52'),
(180, 2, '0025063167', 'Eka Anggraini', '$2y$12$DwnkK5m1XQ01rDJCh4mfbei/kyVp5d0CD8mxgQp6SLEvc71IwsKzC', '2026-11-09 13:25:52', '2026-11-09 13:25:52'),
(181, 2, '0025033800', 'Eko Firmansyah', '$2y$12$LQPnOo6wqCK8FV.mC2qeAu6KTnVsIWRdWuIMQVYDn0ssHw4vtYll2', '2026-11-09 13:25:53', '2026-11-09 13:25:53'),
(182, 2, '0025485131', 'Fajar Hakim Utami', '$2y$12$Ju290XWryrlM0ysDXUDHEuCimujxNswoyMc8Y6kHdETBmIrOX9rdS', '2026-11-09 13:25:53', '2026-11-09 13:25:53'),
(183, 2, '0025749239', 'Irfan Utami', '$2y$12$6NtzeZwlk/bZll2Pe5kw/e7naUgitcVjTis6o4mRXDyRGnfg4NvtW', '2026-11-09 13:25:53', '2026-11-09 13:25:53'),
(184, 2, '0025677442', 'Joko Hakim', '$2y$12$ayS0C2dC.UB4qL9BK2xdV.AHDsUBvW2g.SFnS.SYRI/g5uJqISbzi', '2026-11-09 13:25:53', '2026-11-09 13:25:53'),
(185, 2, '0025590005', 'Maya Utami Wulandari', '$2y$12$HVD1kdxSMcJxHYaewabRt.Pg9kzdBLEWMfkbbtF6Hf1Xt/Ga8KIaK', '2026-11-09 13:25:53', '2026-11-09 13:25:53'),
(186, 2, '0025227230', 'Nadia Setiawan Hakim', '$2y$12$aOQ52mxbx91dpZDT6MzgPOUyOlMEzbSnOoAUnm6sVGnnfEKKy3uC2', '2026-11-09 13:25:54', '2026-11-09 13:25:54'),
(187, 2, '0025103096', 'Putri Anggraini', '$2y$12$FwhVTERV8eTqyeLbTO.UQ.b3uEo.8WvfOCSxW4r6oK9dJFZ3ouv8q', '2026-11-09 13:25:54', '2026-11-09 13:25:54'),
(188, 2, '0025954177', 'Rina Ramadhan', '$2y$12$H9mR4RQGincyrZ8D8Mx/4e09KZT3jAn9uhVLlAGDTrGGmUZe5LzVW', '2026-11-09 13:25:54', '2026-11-09 13:25:54'),
(189, 2, '0025511144', 'Rizky Fauzi', '$2y$12$NsBVrbJhTkBT/y2FgtyAtuquvSygmd3toMlxyedP6bzIPYYS5Rfgy', '2026-11-09 13:25:54', '2026-11-09 13:25:54'),
(190, 2, '0025271306', 'Rizky Kurniawan', '$2y$12$R1N.Eb79B9XaJQHS9DXV1.4voWTVknc5R7RukIWKoe8hQNjSm1hM6', '2026-11-09 13:25:54', '2026-11-09 13:25:54'),
(191, 2, '0025715393', 'Tika Ningsih', '$2y$12$le6sZTgjJDeMv8WlDa6ZEeCjy6NsOeH66GGIBMePXC7bAY9GnnhAC', '2026-11-09 13:25:55', '2026-11-09 13:25:55'),
(192, 2, '0025675244', 'Tika Putra', '$2y$12$9mDm3F4AVFmz0IVSgmob0.oUSqTegkJ8PX4wj0z8XzGUS3meEPt86', '2026-11-09 13:25:55', '2026-11-09 13:25:55'),
(193, 2, '0025468252', 'Wahyu Fauzi', '$2y$12$DzJMXQI5vYNGWfJam8/qYOolMms5R219lKZ.woMI.ArZK2UOzQSN2', '2026-11-09 13:25:55', '2026-11-09 13:25:55'),
(194, 2, '0025889490', 'Zahra Hakim Putra', '$2y$12$4iuaXyFtpLda/IPvaNgQH.C/cVGKgPf2ln9GpbVo8c3YVvR/SUiSW', '2026-11-09 13:25:55', '2026-11-09 13:25:55'),
(195, 3, '0024631837', 'Aditya Aprilia Rahmawati', '$2y$12$yZQ.MwseygzVVxH3.ombaeHJBZsnZR7GBJmkw2vfLPKPq2cUjUJm6', '2026-11-09 13:25:55', '2026-11-09 13:25:55'),
(196, 3, '0024572440', 'Aditya Firmansyah Putra', '$2y$12$O41dzu2s9rLKUG0xbz6el.9zHLb0R/RibpR6Va9m6KqBmLUSD5u1K', '2026-11-09 13:25:56', '2026-11-09 13:25:56'),
(197, 3, '0024160324', 'Aditya Putra Ningsih', '$2y$12$wMMMGL2iwoaxhXWNEfkDqOF/su7cOcj4Fh8C8CHd3LZCkuNuvxqv2', '2026-11-09 13:25:56', '2026-11-09 13:25:56'),
(198, 3, '0024020220', 'Alya Lestari', '$2y$12$2Qu.LJBcn682ZT4g2obBCeOZJzVkFl6WQ9i949qwJ.MBlDuTaa3hi', '2026-11-09 13:25:56', '2026-11-09 13:25:56'),
(199, 3, '0024710615', 'Alya Maulana Saputra', '$2y$12$y1BpRazg9/q2N4wH55vh9.ZnADQQd8iDbmFVutNMS19QM1jlvSsHC', '2026-11-09 13:25:56', '2026-11-09 13:25:56'),
(200, 3, '0024212499', 'Bayu Anggraini Hidayat', '$2y$12$nTfhKauoqUgshxyNVJbhkurz7r.uWkIRVfpiNmUu9c74Vk9rA0CYu', '2026-11-09 13:25:56', '2026-11-09 13:25:56'),
(201, 3, '0024460988', 'Budi Firmansyah', '$2y$12$7ShTE.DnumW29kAETufduODxPn8WHRB6C2BbhhDW//DJU4m7jUIku', '2026-11-09 13:25:57', '2026-11-09 13:25:57'),
(202, 3, '0024744543', 'Citra Putra Safitri', '$2y$12$9XKQ0tNCq.QfNF9EmE9PJesEVhCPrRd1i.wEOd9o5jUlWWaeWoVpG', '2026-11-09 13:25:57', '2026-11-09 13:25:57'),
(203, 3, '0024778647', 'Dedi Setiawan Santoso', '$2y$12$fgVMFzaWbf6tphSN7oJ9qe9uepArHAk.c5WdMfTrxtiXWgocB.bqu', '2026-11-09 13:25:57', '2026-11-09 13:25:57'),
(204, 3, '0024878702', 'Dewi Anggraini', '$2y$12$KWj8AVbcpa7jn3JZ2WMe/eo1rTby013PGaz5ArRuheON4Om7rDmTe', '2026-11-09 13:25:57', '2026-11-09 13:25:57'),
(205, 3, '0024652216', 'Dimas Firmansyah Aprilia', '$2y$12$f2W24D5.Icu9fu7Uko0HRujX2dwbvWu0kcM6Bxf53GYO8IhOQBkN2', '2026-11-09 13:25:57', '2026-11-09 13:25:57'),
(206, 3, '0024123038', 'Hendra Nugroho Hidayat', '$2y$12$AfZBF5nzooXYhAgTmJUql.8fDNupHQgo44k2exZC/Lf3k/K4drhwC', '2026-11-09 13:25:58', '2026-11-09 13:25:58'),
(207, 3, '0024358911', 'Irfan Rahmawati', '$2y$12$PLZLssAgczoQSYKHZGeoie/g1LH7PD06knX4Un92ir2o7A/jv1iqC', '2026-11-09 13:25:58', '2026-11-09 13:25:58'),
(208, 3, '0024126396', 'Joko Hidayat', '$2y$12$m/XU8pAS0mf3VowzvH.qb.bckPseGPiDXHm.uqrmcW5DqVeKY512q', '2026-11-09 13:25:58', '2026-11-09 13:25:58'),
(209, 3, '0024329746', 'Maya Fauzi', '$2y$12$4508V6NI9Fg6zC8Y8cTsBueXIcccDSfOUrO8MYJxdXgvWVGGoyWdy', '2026-11-09 13:25:58', '2026-11-09 13:25:58'),
(210, 3, '0024083774', 'Naufal Lestari', '$2y$12$7cd322wmgtRDcf16Lb7fge5IyUOQPrnHJpdSdWsbGGqvzQrvV1MZO', '2026-11-09 13:25:58', '2026-11-09 13:25:58'),
(211, 3, '0024018186', 'Naufal Ramadhan Wijaya', '$2y$12$M6Gb5dZrCYfoUWpDGQaI4u392k6U5GjXJfpcWKaAI30rLNfa3Dh1O', '2026-11-09 13:25:59', '2026-11-09 13:25:59'),
(212, 3, '0024899765', 'Putri Fauzi', '$2y$12$8X3j5Q6HE/g4.ywebATpeuruBAzuPJC6NWnWsVpmHeH4HhGtlmSiC', '2026-11-09 13:25:59', '2026-11-09 13:25:59'),
(213, 3, '0024994985', 'Rizky Hidayat', '$2y$12$/TOAsvRdCxGqcM9WZjxBHuyp7rK4E8p1snJGRKeRcH1eKqRlfvAM.', '2026-11-09 13:25:59', '2026-11-09 13:25:59'),
(214, 3, '0024795949', 'Salsa Firmansyah Aprilia', '$2y$12$rNgQMH3q7iN3IzT1FQ6XwuXLmAMRlPgInN5EwUP1OruZp9k22ewJ2', '2026-11-09 13:25:59', '2026-11-09 13:25:59'),
(215, 3, '0024878588', 'Salsa Wulandari', '$2y$12$aWSbd.e9hoTMxmZi64iquuMC.caAo56MaXSdyzCUhxA.PH8RPkf5a', '2026-11-09 13:25:59', '2026-11-09 13:25:59'),
(216, 3, '0024283821', 'Syifa Prasetyo', '$2y$12$.OMLJyuQb5TiPXvOmjAzReqSiJCrBa8u7zVbIVti/MVbJ6cFx.wY6', '2026-11-09 13:26:00', '2026-11-09 13:26:00'),
(217, 3, '0024139358', 'Wulan Ramadhan', '$2y$12$JniFViyzrGjDk4HL6V05K.0hwYAUph.gNU6cJHnw0BxvXfYg0woC2', '2026-11-09 13:26:00', '2026-11-09 13:26:00'),
(218, 3, '0024595215', 'Yoga Nugroho Wijaya', '$2y$12$Nj9KAWjJ5pQeGXG1/E6ojeLR0oWd92HKSjYz8VTNq0mG3FFrqVqj6', '2026-11-09 13:26:00', '2026-11-09 13:26:00'),
(219, 4, '0026685806', 'Ahmad Firmansyah', '$2y$12$UT6AOkup2fxfvMDxpC7t1e4NgBF.TmB1WSOZwA/iAIGkWFHD7iXxy', '2026-11-09 13:26:01', '2026-11-09 13:26:01'),
(220, 4, '0026867128', 'Alya Kurniawan Saputra', '$2y$12$t0fuuovjqXmeHomKCxDEE.sukMWFb3S.Z.niP/BI4SN.wqmhonBKu', '2026-11-09 13:26:01', '2026-11-09 13:26:01'),
(221, 4, '0026666841', 'Anisa Hakim', '$2y$12$Q93qvrmnzp/EKq4wFr9q1O7wIh9RcbE1pWvggG839Xm0ywC4Fm1zm', '2026-11-09 13:26:01', '2026-11-09 13:26:01'),
(222, 4, '0026466576', 'Budi Maulana', '$2y$12$/kG1Z1xy14XgCM16Gpry9.UHSLYmHZ5Z/oh.6u1A0bbHokS64u6/q', '2026-11-09 13:26:01', '2026-11-09 13:26:01'),
(223, 4, '0026547724', 'Budi Saputra Utami', '$2y$12$Eh/QDgp5a6uiqxzah6Kpf.cIlUG8srjVdQ1Fj9j607erUw5ixcNqW', '2026-11-09 13:26:02', '2026-11-09 13:26:02'),
(224, 4, '0026488628', 'Dedi Hakim Wulandari', '$2y$12$5OwYVCmO5J1kmbxLng7VwOf90HQDPh4jysCZCmlfq287vg.OIl9YC', '2026-11-09 13:26:02', '2026-11-09 13:26:02'),
(225, 4, '0026347635', 'Dimas Anggraini Rahmawati', '$2y$12$uDRlnilDmtKtw.rqgfCKQuPlHFbSmvL9NKpDMZgCMCeWWTryt.dA.', '2026-11-09 13:26:02', '2026-11-09 13:26:02'),
(226, 4, '0026416150', 'Dina Rahmawati', '$2y$12$ORvbL/lax9Ri5gsjw2ZkXO4JPFIAzo/pc/NKuodTB6hfOL4neHjJ6', '2026-11-09 13:26:02', '2026-11-09 13:26:02'),
(227, 4, '0026197716', 'Eko Nugroho', '$2y$12$c8b1/rI6/oEVeJVSZFfp2Otjf3rpoxKOEwoPm0KUsz3XLWvzFi.L6', '2026-11-09 13:26:03', '2026-11-09 13:26:03'),
(228, 4, '0026911739', 'Fitri Santoso', '$2y$12$rfDMObiaXa/ixwiASBJjveygr3GMfwzDOabZsEti/EyFaUahyhDWW', '2026-11-09 13:26:03', '2026-11-09 13:26:03'),
(229, 4, '0026868473', 'Galih Setiawan Maulana', '$2y$12$I8zSd0n8hJtiBGVTD/2hUuV/IXv0dmcnP/8BCZEsCMds22NvHNGNK', '2026-11-09 13:26:03', '2026-11-09 13:26:03'),
(230, 4, '0026782434', 'Irfan Pratama Firmansyah', '$2y$12$PZE7yf7KEn3wzBPZAhAY7.2DrFa7N34W6uoBlvclIWnqJH210soDS', '2026-11-09 13:26:03', '2026-11-09 13:26:03'),
(231, 4, '0026778101', 'Naufal Kurniawan', '$2y$12$sLMsUmBaq4f/8iCESzLN9ewgXIyml/gQ8DtPPd5Dl/ek8M8W82Bx6', '2026-11-09 13:26:03', '2026-11-09 13:26:03'),
(232, 4, '0026621369', 'Nur Hakim', '$2y$12$Bytk9rdtU3mB5479YbNFqePeAtWdBctW6azkemhRa2gwKzLCmlgK2', '2026-11-09 13:26:04', '2026-11-09 13:26:04'),
(233, 4, '0026318257', 'Rani Saputra', '$2y$12$4c0Dk9y1RaofMS5txz0eXekz/HgR396qsfaqJolZ1Kv/A60mN0s8y', '2026-11-09 13:26:04', '2026-11-09 13:26:04'),
(234, 4, '0026498838', 'Reza Prasetyo Setiawan', '$2y$12$XOhZgHDicWl6MlN7tbwtK.Qr51LRcY1vLLmF9NVgzSe2aqLPDH.EK', '2026-11-09 13:26:04', '2026-11-09 13:26:04'),
(235, 4, '0026201567', 'Reza Santoso Maulana', '$2y$12$xi8yeQRPr9vqjmYVi23rgOqfnsJ2D0SyAYDSYKlFIDGtXQHn/2mau', '2026-11-09 13:26:04', '2026-11-09 13:26:04'),
(236, 4, '0026193573', 'Syifa Anggraini Lestari', '$2y$12$hdVTYKwr0fmPCy/cy1IY5.tGY9F29BmCT6GDOzOqXAMa7HuRBlHDS', '2026-11-09 13:26:05', '2026-11-09 13:26:05'),
(237, 4, '0026304758', 'Vina Firmansyah', '$2y$12$JjNTSPvwAYwzBadoJljTQOkLrgkkRNojOfsgmQ4Sx25CKrf/GUj0G', '2026-11-09 13:26:05', '2026-11-09 13:26:05'),
(238, 4, '0026491165', 'Wahyu Permata', '$2y$12$7pWydZ4tyPZM4wleyekN0eB86XEjOyFJOjmA/XlRfThTPKFMcnF3u', '2026-11-09 13:26:05', '2026-11-09 13:26:05'),
(239, 4, '0026132050', 'Wulan Lestari Ningsih', '$2y$12$nBbYaUubkn7Wj5rBsV3IuOOhPkT4l6cDkCMc3/PhHZ19ub7FGOqGe', '2026-11-09 13:26:05', '2026-11-09 13:26:05'),
(240, 5, '0025468212', 'Aditya Wulandari', '$2y$12$3JMhLDFwTCG1Z2/hIB0IdujCNPMBZpckON0mkSQ9.CDcHW0GCOXCe', '2026-11-09 13:26:05', '2026-11-09 13:26:05'),
(241, 5, '0025704342', 'Alya Safitri', '$2y$12$SHakzZXHCPQabRKHf71S9u8cuXHpBm52hr9Ys8FDEpBXS1HMS1lUO', '2026-11-09 13:26:06', '2026-11-09 13:26:06'),
(242, 5, '0025296282', 'Alya Wulandari Fauzi', '$2y$12$BoD.KcGqfWrJMbNMfspYAekffbUH4/oseAy0WkXLaIsXDMxCepcZO', '2026-11-09 13:26:06', '2026-11-09 13:26:06'),
(243, 5, '0025895927', 'Anisa Nugroho', '$2y$12$sUnX2NzJAoX0ndazfxZG..Eq4Bbkl2APuuVoGLOfhvqad/H8wZYfa', '2026-11-09 13:26:06', '2026-11-09 13:26:06'),
(244, 5, '0025697472', 'Arif Wijaya Santoso', '$2y$12$BmeBMDxTom./XHUXGQa7NuDDcKPswXWIb30Ob5uMXqZY3TwAHwizu', '2026-11-09 13:26:06', '2026-11-09 13:26:06'),
(245, 5, '0025115167', 'Ayu Firmansyah Safitri', '$2y$12$fTmKVha5mrPzIB3LT5NmHuMXS6KKy1PavW1nNsIypjz/lUlb51nyW', '2026-11-09 13:26:07', '2026-11-09 13:26:07'),
(246, 5, '0025248742', 'Dedi Ningsih', '$2y$12$.n1zg/6qDGO2LrjKJ2UhGucHjDCVPM09m4C8J07/z/GjCAFg7kcZO', '2026-11-09 13:26:07', '2026-11-09 13:26:07'),
(247, 5, '0025288585', 'Dimas Santoso', '$2y$12$QVMx9F/Ln6d4RCKH6XHCT.EvhLdPJp7OgenTFe0HqnbENXYpP3L1a', '2026-11-09 13:26:07', '2026-11-09 13:26:07'),
(248, 5, '0025158518', 'Eka Hidayat Utami', '$2y$12$Bis3gkVKB8UyyERCpsUnvedgzp39LLWgPAmv3fOZJHew9XiUSsv.q', '2026-11-09 13:26:07', '2026-11-09 13:26:07'),
(249, 5, '0025825510', 'Galih Santoso', '$2y$12$NZGMdYPQT7iEqv9YuPSxkOW3dtuJqUXAkoZKT1UDuWEYZdjjVK39S', '2026-11-09 13:26:08', '2026-11-09 13:26:08'),
(250, 5, '0025808654', 'Hendra Ningsih Lestari', '$2y$12$h3Do5o2oIqaCuJZpV7vq7.zs2RFnPUEZMuVWDpEuiuzxtQfxt8nB2', '2026-11-09 13:26:08', '2026-11-09 13:26:08'),
(251, 5, '0025342674', 'Kevin Ningsih Anggraini', '$2y$12$HA3mpgvy.IIbtWmDNChAdulHeXFHPmUCAeZDRDQzt3PdTLrbCGtDa', '2026-11-09 13:26:08', '2026-11-09 13:26:08'),
(252, 5, '0025553975', 'Lestari Hakim', '$2y$12$NiggwMivo.nSel8rtBEFy.hoFgd2LtadBFyFwYc3w7/Vj8bo7rnJO', '2026-11-09 13:26:08', '2026-11-09 13:26:08'),
(253, 5, '0025427677', 'Lestari Syahputra Hidayat', '$2y$12$Ce4jbfxjjZpWzq0gagzf7OwLxJcJ7a41y/nvXrGiSnKqyrAMl/MAm', '2026-11-09 13:26:08', '2026-11-09 13:26:08'),
(254, 5, '0025434785', 'Naufal Maulana', '$2y$12$iSyjfPR4fv.uEwzgcAFWSO22pSJCDdUH9x5ZDEWZrwq73Zx/7DDoe', '2026-11-09 13:26:09', '2026-11-09 13:26:09'),
(255, 5, '0025419474', 'Putri Lestari Hidayat', '$2y$12$EiFiBISEi9OqVWFH6T1RneMzwMxJbPU94zYeN6d8mxaselcfCPYzS', '2026-11-09 13:26:09', '2026-11-09 13:26:09'),
(256, 5, '0025675010', 'Rizky Saputra', '$2y$12$tmFQVZFjSJfWPTRBRq0ViedqRSi22HMFjyTr/koz6RdCbVU3Sz/c.', '2026-11-09 13:26:09', '2026-11-09 13:26:09'),
(257, 5, '0025528315', 'Wulan Fauzi', '$2y$12$BbgyEutwOPkOM8ZiodcR7O4Hasmmxdp7V2UZd5nd7wKv88Ln373h2', '2026-11-09 13:26:09', '2026-11-09 13:26:09'),
(258, 5, '0025706602', 'Wulan Rahmawati Permata', '$2y$12$u5ZqwHM.20Da3m3eehwpLOu7rH8MDkQkHyvwesRfoHYWbSKbTIzcO', '2026-11-09 13:26:10', '2026-11-09 13:26:10'),
(259, 5, '0025742612', 'Yoga Kurniawan', '$2y$12$MSUiqmSzYlYytFuYW8HzcO5C8NVRSNZzRRJCqvrlao6Lm1itwKobK', '2026-11-09 13:26:10', '2026-11-09 13:26:10'),
(260, 5, '0025773146', 'Zahra Firmansyah', '$2y$12$RuEff0nlTaBSGizMxB55UuZpzwdtfWsWGnaTLBtIm3MA1zSuYCqyW', '2026-11-09 13:26:10', '2026-11-09 13:26:10'),
(261, 6, '0024525916', 'Aditya Prasetyo', '$2y$12$JuQv1N3vlCzSeJd459kHCe0WGYDTgwkcB4LSMlnh1fk5isASKMKhq', '2026-11-09 13:26:10', '2026-11-09 13:26:10'),
(262, 6, '0024833971', 'Ahmad Pratama', '$2y$12$sR60/iEZc2NJbEc9fPoQOun5Lnw9eip7b69hQv2VRi9AP26GENBFi', '2026-11-09 13:26:10', '2026-11-09 13:26:10'),
(263, 6, '0024807941', 'Alya Wulandari', '$2y$12$0k1DZ5GAbSdOXzjq9juc0.vQyOvYFacuZSKH9uXbhQbFADR.VgEhK', '2026-11-09 13:26:11', '2026-11-09 13:26:11'),
(264, 6, '0024447305', 'Andi Utami', '$2y$12$MuHjOrmR0TGOFxq83SCoQehBRXTvLExXEmajWkwFZ97GnlMHrf9Nq', '2026-11-09 13:26:11', '2026-11-09 13:26:11'),
(265, 6, '0024849645', 'Anisa Santoso', '$2y$12$aUz6up2.Zu2NfE48tqnmweqWri9lim9lOKCnTF4Lqw66BLrYlvosq', '2026-11-09 13:26:11', '2026-11-09 13:26:11'),
(266, 6, '0024959636', 'Arif Lestari', '$2y$12$oqmfIkTSr8R0H7ObmBmiHetQXr8LlNp7Hc.npKJVGop3prD9e7.J.', '2026-11-09 13:26:11', '2026-11-09 13:26:11'),
(267, 6, '0024610943', 'Aulia Firmansyah Safitri', '$2y$12$G4Gl1R4i8.z2SeRejBMtWepJtwkxeqynICBYBg.Qu.IfT2bVRCtdC', '2026-11-09 13:26:12', '2026-11-09 13:26:12'),
(268, 6, '0024334697', 'Bagas Permata', '$2y$12$nibSx7uD7kHhWujNIynCpuE/wFRQAJbqbsnTPF1xZ5hXihXdG4Qwm', '2026-11-09 13:26:12', '2026-11-09 13:26:12'),
(269, 6, '0024883576', 'Budi Anggraini', '$2y$12$VdMKhE.PhZFbbqj7xA9ALeUDAobCClRLwj7raTuE99dZDHw0dU3I.', '2026-11-09 13:26:12', '2026-11-09 13:26:12'),
(270, 6, '0024772098', 'Dewi Putra', '$2y$12$H/2na8tLIOGdvOL25a1/8OK.Hmvl3qThXYupAPmha4QU1jQ0x0Vj6', '2026-11-09 13:26:12', '2026-11-09 13:26:12'),
(271, 6, '0024632965', 'Dewi Safitri', '$2y$12$CYe9MVJQxY/RQT6DfB.R7.BxL./yV0D329wzrcxBFYfSEW6y4KrSa', '2026-11-09 13:26:12', '2026-11-09 13:26:12'),
(272, 6, '0024013784', 'Eko Setiawan', '$2y$12$0h7JpmUhLU2yqMm9/t.ig.FJUYvdvoRFO.8qguG3WhUPeKWJhF1.a', '2026-11-09 13:26:13', '2026-11-09 13:26:13'),
(273, 6, '0024648398', 'Farhan Hidayat', '$2y$12$uxU.xqxoPS9yo6zmSbIwKOLgQzFu1lROc0MiSltBr1lgcR8TO9N9a', '2026-11-09 13:26:13', '2026-11-09 13:26:13'),
(274, 6, '0024161524', 'Farhan Kurniawan', '$2y$12$RJxeoLLpo3dNyju8nS/aT.pQyZl9Wdt6LNixxrReZlld9fzYlAhue', '2026-11-09 13:26:13', '2026-11-09 13:26:13'),
(275, 6, '0024351503', 'Fikri Kurniawan', '$2y$12$fbmZS1nWL8IY9r7CeNx4dOWdVnSKhDEtwmYE/gVBQ6TC9LaKPGDb2', '2026-11-09 13:26:13', '2026-11-09 13:26:13'),
(276, 6, '0024058292', 'Joko Hidayat Maulana', '$2y$12$o5A4.XL4cFdDWdfrckUWquZ7RiTiyuj4Psok.YwddlXRRxjFJbqPu', '2026-11-09 13:26:14', '2026-11-09 13:26:14'),
(277, 6, '0024607473', 'Kevin Permata', '$2y$12$e1mgnzrlGd0GagMT19K7MuGU08jv/YIYO.9eARfjnXV8g/lAzeoIO', '2026-11-09 13:26:14', '2026-11-09 13:26:14'),
(278, 6, '0024110479', 'Lestari Fauzi Wulandari', '$2y$12$evbJnIDwDhrWFuQWN7P1IeOl2.tcWu/ljlPFPXLoaQ4WviZphJBbS', '2026-11-09 13:26:14', '2026-11-09 13:26:14'),
(279, 6, '0024484221', 'Maya Lestari', '$2y$12$XgplFKcdx/Yps9KjlP.saOc0RG/XnRlrsSNp7/X28ZNwZfgyDqmDO', '2026-11-09 13:26:14', '2026-11-09 13:26:14'),
(280, 6, '0024641245', 'Maya Rahmawati', '$2y$12$Cf8pB0198pUT2yR1mZj2L.QrJba03ISDvqNoUxkRRakLD4p5KkWS2', '2026-11-09 13:26:15', '2026-11-09 13:26:15'),
(281, 6, '0024758849', 'Nadia Putra Permata', '$2y$12$zXzW45/aLJgQflLtOr0/vOMmqmCkbhEnfAWIvaPZZPX3KLrpqnk7y', '2026-11-09 13:26:15', '2026-11-09 13:26:15'),
(282, 6, '0024014931', 'Nadia Putra Safitri', '$2y$12$S5qdxbs1hWHVPVtiWwIheOKFPZXSdb5yDQ2MItTSEKM0GZHs.OfQm', '2026-11-09 13:26:15', '2026-11-09 13:26:15'),
(283, 6, '0024174630', 'Naufal Lestari Utami', '$2y$12$19CfWUFLh0kaokYtcwkrgOmTFj76atHPH/QdX8Y5SHpv/JiX67Bey', '2026-11-09 13:26:15', '2026-11-09 13:26:15'),
(284, 6, '0024274237', 'Rani Lestari Safitri', '$2y$12$fMV4m/sBKsnYWtQDFI3YYus9gf1B3ec9.1HoADnHFKf7PmOq7g6sS', '2026-11-09 13:26:16', '2026-11-09 13:26:16'),
(285, 6, '0024736682', 'Rani Permata Wijaya', '$2y$12$IN9ss11sjZdswLLbanZBA.dT8n2kzoLeWaDDwHi35CwspiYE9NzlC', '2026-11-09 13:26:16', '2026-11-09 13:26:16'),
(286, 6, '0024538521', 'Reza Santoso', '$2y$12$jKpiuxF232aeQD3MoJU/y.rYYIDDOUdLnaBXHNVBHxETDxou7wOv2', '2026-11-09 13:26:16', '2026-11-09 13:26:16'),
(287, 6, '0024667108', 'Wulan Ningsih', '$2y$12$rVL7xtHvMPx433OPalMm5usuwTG6rg.1GUboyzj1zdNMs96MiGch.', '2026-11-09 13:26:16', '2026-11-09 13:26:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` bigint(20) UNSIGNED NOT NULL,
  `control_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `pertanyaan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indeks untuk tabel `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `control_sesi_id_foreign` (`sesi_id`),
  ADD KEY `control_mapel_id_foreign` (`mapel_id`),
  ADD KEY `control_kelas_id_foreign` (`kelas_id`);

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
  ADD KEY `kelas_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `kelas_guru_id_foreign` (`guru_id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `mapel_guru`
--
ALTER TABLE `mapel_guru`
  ADD PRIMARY KEY (`id_mapgur`),
  ADD KEY `mapel_guru_id_guru_foreign` (`id_guru`),
  ADD KEY `mapel_guru_id_mapel_foreign` (`id_mapel`);

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
  ADD KEY `nilai_control_id_foreign` (`control_id`),
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
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `soal_control_id_foreign` (`control_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `control`
--
ALTER TABLE `control`
  MODIFY `id_control` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id_jurusan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `mapel_guru`
--
ALTER TABLE `mapel_guru`
  MODIFY `id_mapgur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `opsi_soal`
--
ALTER TABLE `opsi_soal`
  MODIFY `id_opsi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT untuk tabel `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `control_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL,
  ADD CONSTRAINT `kelas_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mapel_guru`
--
ALTER TABLE `mapel_guru`
  ADD CONSTRAINT `mapel_guru_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE,
  ADD CONSTRAINT `mapel_guru_id_mapel_foreign` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `control` (`id_control`) ON DELETE CASCADE,
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
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_control_id_foreign` FOREIGN KEY (`control_id`) REFERENCES `control` (`id_control`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
