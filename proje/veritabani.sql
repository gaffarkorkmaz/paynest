-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 11 Haz 2026, 20:59:30
-- Sunucu sürümü: 10.11.18-MariaDB
-- PHP Sürümü: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `forcescr_paynest`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-site_configs', 'a:6:{s:4:\"site\";s:34:\"PayNest Ödeme Geçidi Yazılımı\";s:6:\"sirket\";s:16:\"PayNest Şirketi\";s:5:\"adres\";s:17:\"Kocaeli, Türkiye\";s:6:\"eposta\";s:25:\"iletisim@forcescripts.com\";s:7:\"telefon\";s:17:\"+90 539 825 12 92\";s:7:\"favicon\";s:14:\"1781195510.png\";}', 1781203752);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`) VALUES
(1, 'site', 'PayNest Ödeme Geçidi Yazılımı'),
(2, 'sirket', 'PayNest Şirketi'),
(3, 'adres', 'Kocaeli, Türkiye'),
(4, 'eposta', 'iletisim@forcescripts.com'),
(5, 'telefon', '+90 539 825 12 92'),
(6, 'favicon', '1781195510.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `idn` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `tax_office` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `customer_type` int(11) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `deleted` int(11) DEFAULT 0,
  `notes` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `customers`
--

INSERT INTO `customers` (`id`, `name`, `surname`, `idn`, `email`, `phone`, `address`, `company`, `tax_office`, `website`, `customer_type`, `postal_code`, `district`, `city`, `deleted`, `notes`) VALUES
(1, 'Gaffar', 'Korkmaz', '11111111111', 'gaffarkorkmaz207@gmail.com', '05398251292', 'Bursa Karacabey', 'FORCESCRIPTS', NULL, NULL, 2, NULL, 'Körfez', NULL, 0, NULL),
(2, 'Gaffar', 'Korkmaz', '11111111111', 'test@gmail.com', '5398251292', 'Kocaeli Körfez', 'FORCESCRIPTS', 'Körfez VD', 'https://forcescripts.com', 1, '41780', 'Körfez', NULL, 1, 'asd'),
(4, 'Gaffar', 'Korkmaz', '11111111111', 'ahmetvekerem@hotmail.com', '905398251292', 'test 2. kullanıcı', NULL, NULL, NULL, 1, NULL, NULL, NULL, 0, 'Ürün alımı sonucu oluştu.'),
(5, 'Ahmet', 'Yılmaz', '11111111111', 'ahmet@example.com', '05321234567', 'Örnek Mahallesi, Test Sokak No:1 İstanbul', NULL, NULL, NULL, 1, NULL, NULL, NULL, 0, 'Sanal pos ödemesi için oluşturulmuştur.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `failed_jobs`
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
-- Tablo için tablo yapısı `gateways`
--

CREATE TABLE `gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `credentials` varchar(5000) DEFAULT NULL,
  `gateway` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `logo` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `gateways`
--

INSERT INTO `gateways` (`id`, `name`, `value`, `description`, `credentials`, `gateway`, `status`, `logo`) VALUES
(1, 'paytr', 'Paytr', 'Paytr kredi kartıyla ödeyin.', '{\"merchantId\":\"123\",\"merchantKey\":\"test\",\"merchantSalt\":\"asdd\",\"testMode\":0}', 1, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4TMIpkbmkTh3MflPp9FK8SrlQfVcRKV_V1w&s');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) DEFAULT NULL,
  `type` enum('fatura','urun','pos','') NOT NULL,
  `external_id` int(11) DEFAULT NULL,
  `cid` int(11) NOT NULL,
  `body` longtext DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tax_rate` int(11) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `payed_time` int(11) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `invoices`
--

INSERT INTO `invoices` (`id`, `invoiceid`, `type`, `external_id`, `cid`, `body`, `note`, `status`, `total`, `tax_rate`, `created_time`, `payed_time`, `ip`, `method`) VALUES
(1, 9414556, 'urun', 2, 1, '[{\"name\":\"Test Ürün\",\"quantity\":\"1\",\"price\":\"1000\",\"total\":1000}]', 'Test Ürün ürünü için oluşturulan fatura...', 0, 1000, 20, 1779483482, NULL, NULL, NULL),
(3, 3810182, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084583, NULL, '127.0.0.1', 'paytr'),
(4, 133792, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084610, NULL, '127.0.0.1', 'paytr'),
(5, 9336140, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084625, NULL, '127.0.0.1', 'paytr'),
(6, 7251822, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084638, NULL, '127.0.0.1', 'paytr'),
(7, 3455156, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084828, NULL, '127.0.0.1', 'paytr'),
(8, 7612969, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', '2 için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780084905, NULL, '127.0.0.1', 'paytr'),
(9, 3809978, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', 'TEST için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780085104, NULL, '127.0.0.1', 'paytr'),
(10, 4877180, 'pos', 0, 5, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', 'TEST için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780085168, NULL, '127.0.0.1', 'paytr'),
(11, 577277, 'pos', 0, 1, '[{\"name\":\"Premium Paket\",\"quantity\":\"1\",\"price\":\"150\",\"total\":\"150\"}]', 'TEST için oluşturulmuş pos ödemesinin faturasıdır.', 0, 150, 0, 1780085207, NULL, '127.0.0.1', 'paytr');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `jobs`
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
-- Tablo için tablo yapısı `job_batches`
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
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `invoice` int(11) DEFAULT NULL,
  `gateway` int(11) DEFAULT NULL,
  `gatewayBody` varchar(5000) DEFAULT NULL,
  `apiKey` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `callbackStatus` int(11) DEFAULT NULL,
  `callbackResponse` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pos_keys`
--

CREATE TABLE `pos_keys` (
  `id` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `secret_key` varchar(1000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `permissions` varchar(5000) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `pos_keys`
--

INSERT INTO `pos_keys` (`id`, `name`, `secret_key`, `status`, `permissions`, `time`) VALUES
(2, 'TEST', 'XSLZCgtfSzwZ1za1qH2mYJOexMRQNZBjU3yQvkEk', 1, 'paytr', 1779653890);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pos_request`
--

CREATE TABLE `pos_request` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) DEFAULT NULL,
  `key_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `body` varchar(5000) DEFAULT NULL,
  `response` varchar(5000) DEFAULT NULL,
  `method` varchar(1000) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `odeme_link` varchar(1000) DEFAULT NULL,
  `tur` varchar(200) DEFAULT NULL,
  `iframesrc` varchar(2000) DEFAULT NULL,
  `callback_response` mediumtext DEFAULT NULL,
  `callback_status` int(1) DEFAULT NULL,
  `yonlendirme` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `baslik` varchar(500) DEFAULT NULL,
  `aciklama` varchar(500) DEFAULT NULL,
  `ozellikler` mediumtext DEFAULT NULL,
  `kdv` int(11) DEFAULT NULL,
  `resim` varchar(500) DEFAULT NULL,
  `fiyat` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `url`, `baslik`, `aciklama`, `ozellikler`, `kdv`, `resim`, `fiyat`, `stok`, `deleted`) VALUES
(1, 'test-urun', 'Test Ürün', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Test Özellik 1 || Test Özellik 2 || Test Özellik 3', 20, 'urun_resimleri/f1klPKhGOzOcrEDLfVDgsoWT5Xaiuz7WptyIC0kN.png', 1000, 100, 1),
(2, 'test-urun', 'Test Ürün', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Test Özellik 1 || Test Özellik 2 || Test Özellik 3', 20, 'urun_resimleri/0sDvFJg1mPyI0Bl6z71033fGoESt0RJGJcuxYySu.png', 1000, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('26rOHzdzwIJxSeJIS7DxHga6f1oULcIvqN0wTDVj', NULL, '216.73.216.43', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ClaudeBot/1.0; +claudebot@anthropic.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0dTcDZjWVRaTmpmNU5GOGFPSzNDbmlCT1pmMWhITlpMTDNHMFdscCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781195479),
('3BSddnTskOSRG4V9AqwxIIkOKx5MmnBiZJ8rZVfz', NULL, '44.202.119.90', 'axios/1.16.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVR5SkZvOUhtYkxydVJUbFpFa1QyZmUzOEZzT3BJYnp3TldaWjhoeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781192188),
('4roUUfYa7J9AtpWgTnyukcpyAGETmyj7Ds97KHQD', NULL, '149.28.93.107', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXNUNXdKT2o3VGtId2VISTgxN3FIUEZPM3Vrb1V6Z1BTOWJUblFxcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781191421),
('75kfDApvRxWbQgb7GUsFM9pkp0WJTuEZvjzifjo4', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTXRoN3lTQkpSaEU4WTVza0pxT1dVSkR1RFgzSXJFRjc0M1hNQXA4TyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781193289),
('7stvir91hbpGpMbaTvfWaon7qMPsqtf81q1IKvnI', NULL, '2604:a880:cad:d0::d9d:e001', 'Mozilla/5.0 (l9scan/2.0.33a3a313231333a313368393a363031623; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1NWeE4yUW5YV3NtOFhBUVVrVDdjT1Awb0hhT1lTWnEwdExaVkJnOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781190763),
('8wDaESFlL1FJIxn3L7TVDOtTLUV3q9syZvheid7o', NULL, '91.231.89.121', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZEVnaXZ3cWg2UUpoMUE2MldldFhnTXlEbzFCNGlPbVpiMFpSZUEwOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781193426),
('AImuk2uZ4i21roCe69Sfg0SXTMRCDRgmvUCEI0dk', NULL, '91.231.89.35', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibG1KaFRwUEZPem1kUW9nWHpDQWtRQlNUTTA3TVJIc3k1Q0tyY1F6TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781193977),
('AWP3JPYmhSiVQtqLiuHqQkWLnS0tBZkxYwPJi5Oi', NULL, '23.27.145.191', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSW1NbHZTamplUVBhVnNSZVZTUlJuNHRNbTJteGZhNVlZOExpMHMycCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781197793),
('B4H8I40RFEnF2IYfEBJFaNBOwfL4jTcMmSSurwSA', NULL, '80.94.92.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN29UUVVmUU5TNThtU1d5M3J0eTZMeE5lbVdSRHFJRFNrUlM2V210SSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190602),
('B8uuH04jiVJtaRSQOGXbwATk4bPxnrJmLATjYuIh', NULL, '104.164.173.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTG1PODBCa1BXcXlFM2NGa0tmY2NROFlvc0FWRU1henNBQVpsbzJTeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781192876),
('cG1G59rhawreWVcs0cxlg1lNGXdbXoBs3X7519ia', NULL, '157.245.204.205', 'Mozilla/5.0 (l9scan/2.0.33e27393e2431313e2838313; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXVOV3VIMmpVakxCZzJzWUdEWHlMY3lhZ3d5cGR2MFBOQ05jcm5wRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781190771),
('CSTHN4W3k3cnlGCLpoe6fZ2NORoIiSsVxvc1WjI2', NULL, '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWxxNzNRdVhxR0V2WkUzaVFPQ0lOd3RFdG5LRHpNU3RMblRwRUlleiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781197224),
('EN0MFHa0087MHShkFwvETixUH8WidaVCSpOmxRsp', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2Q5dXdGa2ZEbmNvRTAzbndIRlBKUnFXV3BreHNtV2U2QnYySkxJNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781193289),
('fx7ffrxmIY1BIN6QGJV7nFiCp1KQHxuSpZZMsqjM', 1, '104.28.212.147', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUxWTUZTSElkbUhNWEdpczR1N0ZEaUtvakY3SzdLamZqZkRvTExEcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tL2FuYXNheWZhIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1781198972),
('GWH72j6L4DTkLcsw9qHzOPMyho9Vt3Yguu3LmGMF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQVEyRHhXVklvV0k5V1RoSFNxeFZVVTdlME9QZVFGc1E0emFUaUkwQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9heWFybGFyIjtzOjU6InJvdXRlIjtzOjc6ImF5YXJsYXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1781178820),
('IaJ7Vnj6ZGHl6b1AH4zIwjym7zqfaOHXHfGy9Btt', NULL, '149.28.93.107', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFNaV3dSRTJrTW10UlhHM1p1d2tKU1pqNlZLcTRnSkZiMDhGRFl5ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190626),
('jJQy6rKg9Qq6IhNcj8wCaWMvKfCDWYccO6KcLKyP', NULL, '3.94.247.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGhtQTNOS3JvbmRQWXVod1dSUWFzNTFra3lsY0RtNWJhMEdiQVQ1YiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781191241),
('mevUZa6BbGnKSC6yhmknHTmGqACZCV5Hz7hgsnzX', NULL, '157.245.204.205', 'Mozilla/5.0 (l9scan/2.0.33e27393e2431313e2838313; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmhxc1Y2emtIQ29vd2M4eENhaDkwVTdJY0lIdk5yZVVVbHVCdHpuUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781190763),
('MzB2XVhMIOpghLdWeSVHtTITD1n8LRnb8abNErOf', NULL, '2400:6180:0:d0::13f5:e001', 'Mozilla/5.0 (l9scan/2.0.33a3a303231333a313368393a363031623; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmV5SzJBQ2tncjBDTW9sbmtJRjJmQ3I5amlRcFROdWVWUGdCNHdFTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781190763),
('OG2ySVyHkcyhng2i1fj8qQyWgGN4PcyNFgr3SU4J', NULL, '91.92.241.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS013emU2SnRhYWVTWGZvbmVHUHVJNkUyNDM0dDd0R0VZYk1MZW1xbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781191474),
('pPhHYX8sEMtlup18d5s9niZABz6LHK0tr6EXVZpg', NULL, '91.92.241.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFd4b092TTB1ZkdVVU1nMHh5eTl1YUphUkhBcGhNRE1XdFNESWoxVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190747),
('PWaKwLL5BkFq2kLhmnPohBBHcltOa5UX6u3GGfRy', NULL, '103.4.250.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVlOc0dTbHpWeUxBc0psQlhGOGoyRXRETmxOUGNwTDRDWEdHRENaYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781194357),
('RvBtZbwJOcG2dzTBZNw4aODqfPWAkz2xXEpmjXta', NULL, '2604:a880:400:d0::24f2:4001', 'Mozilla/5.0 (l9scan/2.0.33a3a303231333a313368393a363031623; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzRiT01pYlpEQzRPMmdWaWo1M3h2TFlNSlpBMVVCNWp4WDVtV1AxQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190763),
('SndQl27Ulricb5dzBrKoSvMul2TuCimDDlMyBb3Y', NULL, '74.7.242.55', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.4; +https://openai.com/gptbot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTlFTGM1amNrWUNRT0JTdHhnTXlPRHdTbjFnaHVTcUtZdHdvZnZXWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781195154),
('TAiuWZviMeBsePl1dSacBj4JY49UeWObBuYRbFh8', NULL, '157.245.204.205', 'Mozilla/5.0 (l9scan/2.0.33e27393e2431313e2838313; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejhmSThLNHhSdHUzTHBxbGZWZUluVndqZ0pKMmRBTjhNM1p2bWxUUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20vP3Jlc3Rfcm91dGU9JTJGd3AlMkZ2MiUyRnVzZXJzJTJGIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190798),
('uThhXRBT73AolPLwFK6wd2EVsVMtNyBwh12sCFNt', NULL, '103.4.250.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVBGQm9yZXdtZ0thalJ1N2hnYXNWTzNlMlRqMDdDYnFWeUJZdzVKeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781192897),
('V8ENijsRbszxrNeghkqD9XkBgTYLRTyzeXXg4SOR', NULL, '91.231.89.127', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW5IaElMMHVBUXdtamgwZU5aa2tpczd4Y2l6MDYxMlZnNWEzNjNVYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781193344),
('xu1oHdN71z6DfI6PJYRCykhSS8e9QGl08TyxyGCK', NULL, '51.81.245.138', 'greedyhand/0.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMU50RjRnT3dYV01QeUNwQ3d6ZnN4UE04akV6V3JzSVI1bUJPbmk0TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190609),
('XWzi25K7xQB994mCP6v9MHj7xiaDFRy13lmg3ras', NULL, '91.231.89.32', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWXhuRFBoUWx0QThpa2FSejg2bTczbWhTT0t0c3JPUkF1V3VCbDl5UyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781193878),
('y5dlILcZhqBLKoASjjoH3iaFx2Z0UchCKLbb1m4w', NULL, '103.4.251.173', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjBST3ZZZkVmZTdtTkFxeWZiMzI2ZDdBNU5adXo1WldDM1cwUFYxeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781194356),
('YGSCcjUsZJ6feCJmu7qsc7kCjb1DgNKvYSqDWEpz', NULL, '34.158.41.98', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmdIeHhwWDQxVUxOUFpRbG0xZjU4Q2g2UTlxN3VYOVdoYWxIaVlUbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9wYXluZXN0LmZvcmNlc2NyaXB0cy5jb20iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781200152),
('ziWbX5fqaArIGILNppApiwQ5KR2qecSKThxBCVJw', NULL, '206.81.24.227', 'Mozilla/5.0 (l9scan/2.0.33e27393e2431313e2838313; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUVnM0FpM1daQzE3MmtJcEw3UGxkRHZ4QTFrZ0JOVFZyM0QybFZmNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190763),
('ZMYLt5NtbyDOzWUTtTJF48vthnWE6ahtyK9TTGUN', NULL, '2a03:b0c0:3:d0::d09:a001', 'Mozilla/5.0 (l9scan/2.0.33a3a313231333a313368393a363031623; +https://leakix.net)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUVXamtwVFdNdElzd0taa1VzQWhEc3hTcjFQZDg1R3kxU0xaeEpKbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vcGF5bmVzdC5mb3JjZXNjcmlwdHMuY29tIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1781190763);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Gaffar Korkmaz', 'test@gmail.com', '+905398251292', NULL, '$2y$12$6XkLZgwnZpHt.CUYVkq3F.9nwzai02D2p2pNxln3tfEoK2.kYyFNu', 'FKMGzneRXOhRKJrHUsInUphxtA6wdto27xEXc8krRs53GgMxU5qacXbbOAcE', NULL, '2026-06-11 08:53:18');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Tablo için indeksler `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Tablo için indeksler `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Tablo için indeksler `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Tablo için indeksler `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Tablo için indeksler `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pos_keys`
--
ALTER TABLE `pos_keys`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pos_request`
--
ALTER TABLE `pos_request`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `pos_keys`
--
ALTER TABLE `pos_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `pos_request`
--
ALTER TABLE `pos_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
