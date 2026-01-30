-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jan 28, 2026 at 06:24 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_filament`
--

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":null,\"google_refresh_token\":null,\"google_user_email\":null,\"google_expires_at\":null}', '{\"google_access_token\":\"eyJpdiI6IlZYUzUrWXZ2ai8xc0tBczJrcUpZYlE9PSIsInZhbHVlIjoicmQrL1A3dlYrd3ptajlUWGRiSUFhUnVhMEEyTDBtQVZjaFZURC8ySlhocldtckVFQzNCRDgrQjJxd0xjbXlxY3ZWdUY1ZmF6NUcybTZIUHpBK3lCc0R1RkJhNGhpRndQM3lrY3FuRm4vRitiaE5wb1pKdUxqMlRwREM0VEVQUEZWeDVXbHNSdFAvcVYxcHI3REVWWXFWcFdVRytCS0ZQS0JTSWJLL1FNMmNvdktLUWMzcUE4MnkrajhmWFFxTWtaTlFnSC9rN3FuRCtHREh1YmJqTHNXMFZ4c1BTcUd6WEkrbnd6cTlvQ2tMTkFya1RJbDQ5a3NWdmVNbXJ0OVI3MEtkY1JYK0Q5VkxRelRHMEtjMnpsVkZ2UFl0TFBQZHVnSTViSFJza2tNNDdZaGJnZWx0QXRpQjNiZkNZWWdWclVuR3B3VUpyTzd0VWkvazZta1hjeTVnPT0iLCJtYWMiOiIyNTM3YTY1ZWFhNjE4ZDU1NjlhMjM2MTkxZTUxMmJjODAwZGY4Yjk3YjFiYTU3ZTE2ZTIzOGQ0ZjI2MGZmZDcwIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6Iko0YVRsQmNnVkVzd0ZZRVcrSDYyN2c9PSIsInZhbHVlIjoicFBrd0hldXllclRIbEo5QjhKUXRiVUZBaXloMyt6Vk9Kd2RSOXVvWkVvWG9oUys1T0lJU09ib28xMWRNbG9IY0pYZnRFZnBKUjhLcjM1N04vVEF3c2lRV1ZHUlZiVFd5bkRHd3VRdmc1SGhTMDRWVUdYdmFlS3hydDg0bnlyb2czalhMbFFTa2pyQ0toeW9ZRjMvdldBPT0iLCJtYWMiOiIyYWY5NTlmZThmZTljZDVjZTJiMzc5M2U0ODFlMjZjNzQ4ZjRmNTgyMjZjZmFkN2EyMzExMTg5MzJhYzdkZDQ1IiwidGFnIjoiIn0=\",\"google_user_email\":\"dimmm931@gmail.com\",\"google_expires_at\":\"2026-01-05T18:41:44.702206Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lOIpCVEDsaMPt8mqdT_gStD20ewR1WXd-_BPR4q-Un5VJFhDdLAs0fa8SlB7QhC_A&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=czrkafgokSdsjSA6dlYIeZVnR5jQt98TINtawwi6', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 17:41:45', '2026-01-05 17:41:45'),
(2, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":\"eyJpdiI6IlZYUzUrWXZ2ai8xc0tBczJrcUpZYlE9PSIsInZhbHVlIjoicmQrL1A3dlYrd3ptajlUWGRiSUFhUnVhMEEyTDBtQVZjaFZURC8ySlhocldtckVFQzNCRDgrQjJxd0xjbXlxY3ZWdUY1ZmF6NUcybTZIUHpBK3lCc0R1RkJhNGhpRndQM3lrY3FuRm4vRitiaE5wb1pKdUxqMlRwREM0VEVQUEZWeDVXbHNSdFAvcVYxcHI3REVWWXFWcFdVRytCS0ZQS0JTSWJLL1FNMmNvdktLUWMzcUE4MnkrajhmWFFxTWtaTlFnSC9rN3FuRCtHREh1YmJqTHNXMFZ4c1BTcUd6WEkrbnd6cTlvQ2tMTkFya1RJbDQ5a3NWdmVNbXJ0OVI3MEtkY1JYK0Q5VkxRelRHMEtjMnpsVkZ2UFl0TFBQZHVnSTViSFJza2tNNDdZaGJnZWx0QXRpQjNiZkNZWWdWclVuR3B3VUpyTzd0VWkvazZta1hjeTVnPT0iLCJtYWMiOiIyNTM3YTY1ZWFhNjE4ZDU1NjlhMjM2MTkxZTUxMmJjODAwZGY4Yjk3YjFiYTU3ZTE2ZTIzOGQ0ZjI2MGZmZDcwIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6Iko0YVRsQmNnVkVzd0ZZRVcrSDYyN2c9PSIsInZhbHVlIjoicFBrd0hldXllclRIbEo5QjhKUXRiVUZBaXloMyt6Vk9Kd2RSOXVvWkVvWG9oUys1T0lJU09ib28xMWRNbG9IY0pYZnRFZnBKUjhLcjM1N04vVEF3c2lRV1ZHUlZiVFd5bkRHd3VRdmc1SGhTMDRWVUdYdmFlS3hydDg0bnlyb2czalhMbFFTa2pyQ0toeW9ZRjMvdldBPT0iLCJtYWMiOiIyYWY5NTlmZThmZTljZDVjZTJiMzc5M2U0ODFlMjZjNzQ4ZjRmNTgyMjZjZmFkN2EyMzExMTg5MzJhYzdkZDQ1IiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05 18:41:44\"}', '{\"google_access_token\":\"eyJpdiI6IkpWQ1NMZituUzRVbmlWSEVLS3FhNGc9PSIsInZhbHVlIjoid1JkTW5FZFNPaGtmKzZrZTF2WWdXKzhwSWowcnVtTVlNbzh1YmNEdzNvUndONmZiRGNZS0hZcjcwU3FSa2hQcXBia3FhaWNnK3JSZjJkclUrckZKUU9IcG8xNzJBdFo0T0EwRUZhTDFmWWhjMEdsc2p3TVlHTDYzQXpiZlhQd3lLY041S3d6dVBzZWZKTEdRalFEbjh3UjR5Ky9BUFpJcXp5WXQ2SnNhREw0VFNFZ2dxalh4MVVNUnpnRmJkcXdPWmRwTzlMQm9qNHF3TUF5YjJNK3VoNlI2MWlXeW5DZEFnVnNhRUR0azFsVzUyRXY0TWRnVlhWanB3ckdzOUs0ZFNwTm5UN245RnZ2b2orWGZYSVJxeDA4MGRJa0VrMVFUYm0yM25GYnFabFRsTWJUSmIyWmE1azBabEdpdlc4OWFFenNRN1hLWWtzNm5STGdxOXNPTlNBPT0iLCJtYWMiOiJmZjhjMTIxMmQ0ZmNkOTZmYWI2Zjk4ODU2YjI0NWEwZjNlZWY2OTE4NTNjMWQ0Zjc4NjAwOGQwYTgxMjA4MjcwIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6Im53RmtjNUNnUHNiOElSUU92U2FtVkE9PSIsInZhbHVlIjoiaEhtZzVhSlFKL3p2SlFYUXluWUpmNlQxL2FQa1M0R3VTZ25oV3JHY2EzNlRPOEtQSWVZS1FJc0l2ZVpMdXhZUGhDdWVqOXJxUnlDMlNLN29aWU5hbTgrbkVJVURSRUJPbER1MDlsY0hZVHZ3TFVqT3RNSzdXd2F1eHd2K1FwS1BoUDhSbERKSnkyRTY5Wkt0VXJXTTdBPT0iLCJtYWMiOiI4NDQ4ZDE2Zjk1YjFjZTQzNjczZmZiNGMyMGE3M2IyNzhhYzZmYzAxMTM1MTE4M2EwNjlkZjQxMTM5ZTI4MWQyIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05T18:46:10.766416Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lNfKrbez6bE-gDQmtS88n-f6W5evOCfuli--XXVKv85GG4Ct7JjlX1iHcjKhg5dFA&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=qVzw2jyO0j6DGHsdxn3Ll7z2XsoOPjmwuLXQ1Dcl', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 17:46:11', '2026-01-05 17:46:11'),
(3, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":\"eyJpdiI6IkpWQ1NMZituUzRVbmlWSEVLS3FhNGc9PSIsInZhbHVlIjoid1JkTW5FZFNPaGtmKzZrZTF2WWdXKzhwSWowcnVtTVlNbzh1YmNEdzNvUndONmZiRGNZS0hZcjcwU3FSa2hQcXBia3FhaWNnK3JSZjJkclUrckZKUU9IcG8xNzJBdFo0T0EwRUZhTDFmWWhjMEdsc2p3TVlHTDYzQXpiZlhQd3lLY041S3d6dVBzZWZKTEdRalFEbjh3UjR5Ky9BUFpJcXp5WXQ2SnNhREw0VFNFZ2dxalh4MVVNUnpnRmJkcXdPWmRwTzlMQm9qNHF3TUF5YjJNK3VoNlI2MWlXeW5DZEFnVnNhRUR0azFsVzUyRXY0TWRnVlhWanB3ckdzOUs0ZFNwTm5UN245RnZ2b2orWGZYSVJxeDA4MGRJa0VrMVFUYm0yM25GYnFabFRsTWJUSmIyWmE1azBabEdpdlc4OWFFenNRN1hLWWtzNm5STGdxOXNPTlNBPT0iLCJtYWMiOiJmZjhjMTIxMmQ0ZmNkOTZmYWI2Zjk4ODU2YjI0NWEwZjNlZWY2OTE4NTNjMWQ0Zjc4NjAwOGQwYTgxMjA4MjcwIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6Im53RmtjNUNnUHNiOElSUU92U2FtVkE9PSIsInZhbHVlIjoiaEhtZzVhSlFKL3p2SlFYUXluWUpmNlQxL2FQa1M0R3VTZ25oV3JHY2EzNlRPOEtQSWVZS1FJc0l2ZVpMdXhZUGhDdWVqOXJxUnlDMlNLN29aWU5hbTgrbkVJVURSRUJPbER1MDlsY0hZVHZ3TFVqT3RNSzdXd2F1eHd2K1FwS1BoUDhSbERKSnkyRTY5Wkt0VXJXTTdBPT0iLCJtYWMiOiI4NDQ4ZDE2Zjk1YjFjZTQzNjczZmZiNGMyMGE3M2IyNzhhYzZmYzAxMTM1MTE4M2EwNjlkZjQxMTM5ZTI4MWQyIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05 18:46:10\"}', '{\"google_access_token\":\"eyJpdiI6ImE4eHJvNXpEL1FMeGtSby9nTGtQY1E9PSIsInZhbHVlIjoibjRGSjQ4cnVCVXFGcjNZaW1zK3VvSnZaZlFVK2dsd0RCRGhDZStKeE11OVR0emt4RnBvMDB5LzV5Slp6Qm9HdWFXeVpDV0w4QVA4WXlMYnlVQm9EVitiS0pOQ0xoc01vUzlsemVVcENXa0g3OHhoMmN3ODEyeTZvZ2t2WTIvSTdlbVdtTFRsaHM4aWtIdm9ZR0krM3lrL0pjZ3l0cDkxNk1Xa1hlN1FkVDVOdFV1WEYveGV2SnN2WWh4aFd1ZmMxanRtaytUTVpaNGZqdjZscisyam5RR3NXWHAvZUo0REk0Yjc5YUZMVU5iU01HNVpYRTIxbGFLZ0tyUVcvZmlQUGtDNjloZjRhUEM1ZkZVYTdDbElqcVAyQWpGY3JTRXh4Q3hYbU9xYUZsUTNVSUR3RDcxSnBYc09Kb2hQYjJZNHY2eXg2RmROd3gwYmtyMW9RRHk0RlJnPT0iLCJtYWMiOiI2MmFmOTljMmMyYjA2NzFmMjQ1ZjNkNWRmNTk3NmVjZjczYzdkYmMxNDBjZDE1NTRjY2U4ODk3N2Y2MmM0YWUxIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6IkUwTHpTaTRXRk5rMGlUN3cxUFYzTmc9PSIsInZhbHVlIjoiMWZ2TDJ0V1BBdWtEQzUyNWp6R2Mra0wxQTQyMnpveHNUWXFacW1ZSFpwamo1R0ZMTnlyanFDdjFZVnovRHBRUDFMZmZWTkE0OFI4R2gwMmpiZHJWZmxCZXJSRHpqWXluRUJ3eEZPRnRIQ3NyYmVwSW8vTFBsaEV5ZjNFVEQyMGZ2aFNnOC9GbnQxZXFRUklEN0djd1p3PT0iLCJtYWMiOiI3ZTA0ODU3NWVhNzNkNjRlNDlhZTE0NzkyZjRhY2NlOGVmNWZkYWJiOTMwZTgwOThkOWE3ODBkMGRhOWEzODQ1IiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05T18:49:40.972989Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lOhVMqdyUmZUE6H7eYkoVW-Zms68FSg39-dfTKVt-ojpFb7L1ZUwV9RGHbTthqb2w&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=BY5zjOqTT9mkccku8sOOqN55oykVCsKzypZfnpZM', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 17:49:41', '2026-01-05 17:49:41'),
(4, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":\"eyJpdiI6ImE4eHJvNXpEL1FMeGtSby9nTGtQY1E9PSIsInZhbHVlIjoibjRGSjQ4cnVCVXFGcjNZaW1zK3VvSnZaZlFVK2dsd0RCRGhDZStKeE11OVR0emt4RnBvMDB5LzV5Slp6Qm9HdWFXeVpDV0w4QVA4WXlMYnlVQm9EVitiS0pOQ0xoc01vUzlsemVVcENXa0g3OHhoMmN3ODEyeTZvZ2t2WTIvSTdlbVdtTFRsaHM4aWtIdm9ZR0krM3lrL0pjZ3l0cDkxNk1Xa1hlN1FkVDVOdFV1WEYveGV2SnN2WWh4aFd1ZmMxanRtaytUTVpaNGZqdjZscisyam5RR3NXWHAvZUo0REk0Yjc5YUZMVU5iU01HNVpYRTIxbGFLZ0tyUVcvZmlQUGtDNjloZjRhUEM1ZkZVYTdDbElqcVAyQWpGY3JTRXh4Q3hYbU9xYUZsUTNVSUR3RDcxSnBYc09Kb2hQYjJZNHY2eXg2RmROd3gwYmtyMW9RRHk0RlJnPT0iLCJtYWMiOiI2MmFmOTljMmMyYjA2NzFmMjQ1ZjNkNWRmNTk3NmVjZjczYzdkYmMxNDBjZDE1NTRjY2U4ODk3N2Y2MmM0YWUxIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6IkUwTHpTaTRXRk5rMGlUN3cxUFYzTmc9PSIsInZhbHVlIjoiMWZ2TDJ0V1BBdWtEQzUyNWp6R2Mra0wxQTQyMnpveHNUWXFacW1ZSFpwamo1R0ZMTnlyanFDdjFZVnovRHBRUDFMZmZWTkE0OFI4R2gwMmpiZHJWZmxCZXJSRHpqWXluRUJ3eEZPRnRIQ3NyYmVwSW8vTFBsaEV5ZjNFVEQyMGZ2aFNnOC9GbnQxZXFRUklEN0djd1p3PT0iLCJtYWMiOiI3ZTA0ODU3NWVhNzNkNjRlNDlhZTE0NzkyZjRhY2NlOGVmNWZkYWJiOTMwZTgwOThkOWE3ODBkMGRhOWEzODQ1IiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05 18:49:40\"}', '{\"google_access_token\":\"eyJpdiI6Ii9pWjBOY2RVOWM4czF1R1l2N1BBcXc9PSIsInZhbHVlIjoicjdGMmFsMjkva2V4blNIV1kvb01YZ09idzhPZnlDQkVYWWRFWUIwQmVLK1NnMmQ2SXhxRkJUcDRLZnVwckViTmtrQ2k4c1U1VkFzVDlUN2psR2NJdEpDYkhQdVFSRjFpSHVrU1hydjNlWFlPd2x6WGRyQVUvN2lNak45ck1xS3lKSHpjbjNBZ0JNUFV1c01zYUd4V2QzTkZBQnEwWGV0bFJVSHUzK21rZ1pETzJ0bDR6aGZoS2dEQWdLMnVMSkxjZHhVZ0JhdkVmUno2S2FNbWVMb2huSzVFNktsYkFtSkUyM1YzMlRnTWkxMEJqR1o4TmFyWXJuL0p5QjM5czBwM0dpL1MrZUh2Z2JhZ0cwOHBucUtnbmlZSm9WTUVIOW5GbDdGa2o5ZUoxWnlldUp3L1I2cnBMclBzZWNsZ3cyUzZkOEFRSEtwaG9iUVBlc3hYSFI2YmZBPT0iLCJtYWMiOiIxMDJkNTFkYTU2Y2U0NDE1YWNkZGY0ZDVmMzkxOGMxYTU2ZmE0MTdkNTlhNWIzOGYwMjkyMDY3YTlhNGU3YmQ3IiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6IjdON2szT3M1UDBxcDJrNE9rQmhTWlE9PSIsInZhbHVlIjoiaDRPeDY4QnR0ajRFUzFGKzRGTmt1dXlFVmFUNWVGaDlEWHNhMlkwK0JlOVlLUjQ4d3g4WlNZb1Z1YUo4WDcvNXhTTkdXVXhVVFF5eHMxSDBPRWp2UGgyWU01dG96ZnVLNVZNU2Rpc1REMTMzU2pqanY3YiszUkZCSm5USE9BdEU0VVlvRjFwdHZpNlcrTDNyVlRoWTdBPT0iLCJtYWMiOiIxNmQ2ZWQzYzY4MTlmY2MwMTc2MTcyZjIyMWMyM2Q1NWVlYTA2NzE3N2JjYzkxZjI0NjZiZWI1ZDI1NTE1N2FjIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05T18:56:18.126408Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lOUgkFKsALWWofscJ5aVUYWCCfDAkowb2pyt7iVneQ64I39O9RwPTlvj8NtY-EuzA&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=dx3coV6xPXPeKLEMk3AKjGKtc1G1F2dwrhh0v82G', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 17:56:19', '2026-01-05 17:56:19'),
(5, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":\"eyJpdiI6Ii9pWjBOY2RVOWM4czF1R1l2N1BBcXc9PSIsInZhbHVlIjoicjdGMmFsMjkva2V4blNIV1kvb01YZ09idzhPZnlDQkVYWWRFWUIwQmVLK1NnMmQ2SXhxRkJUcDRLZnVwckViTmtrQ2k4c1U1VkFzVDlUN2psR2NJdEpDYkhQdVFSRjFpSHVrU1hydjNlWFlPd2x6WGRyQVUvN2lNak45ck1xS3lKSHpjbjNBZ0JNUFV1c01zYUd4V2QzTkZBQnEwWGV0bFJVSHUzK21rZ1pETzJ0bDR6aGZoS2dEQWdLMnVMSkxjZHhVZ0JhdkVmUno2S2FNbWVMb2huSzVFNktsYkFtSkUyM1YzMlRnTWkxMEJqR1o4TmFyWXJuL0p5QjM5czBwM0dpL1MrZUh2Z2JhZ0cwOHBucUtnbmlZSm9WTUVIOW5GbDdGa2o5ZUoxWnlldUp3L1I2cnBMclBzZWNsZ3cyUzZkOEFRSEtwaG9iUVBlc3hYSFI2YmZBPT0iLCJtYWMiOiIxMDJkNTFkYTU2Y2U0NDE1YWNkZGY0ZDVmMzkxOGMxYTU2ZmE0MTdkNTlhNWIzOGYwMjkyMDY3YTlhNGU3YmQ3IiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6IjdON2szT3M1UDBxcDJrNE9rQmhTWlE9PSIsInZhbHVlIjoiaDRPeDY4QnR0ajRFUzFGKzRGTmt1dXlFVmFUNWVGaDlEWHNhMlkwK0JlOVlLUjQ4d3g4WlNZb1Z1YUo4WDcvNXhTTkdXVXhVVFF5eHMxSDBPRWp2UGgyWU01dG96ZnVLNVZNU2Rpc1REMTMzU2pqanY3YiszUkZCSm5USE9BdEU0VVlvRjFwdHZpNlcrTDNyVlRoWTdBPT0iLCJtYWMiOiIxNmQ2ZWQzYzY4MTlmY2MwMTc2MTcyZjIyMWMyM2Q1NWVlYTA2NzE3N2JjYzkxZjI0NjZiZWI1ZDI1NTE1N2FjIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05 18:56:18\"}', '{\"google_access_token\":\"eyJpdiI6InpKM0dPR2J1ZkVNN0ZrOW1oaTdnamc9PSIsInZhbHVlIjoiWGczaFdnS3R6UHpQSGlNWDEzcWdwRFZ2T1F4T1M0T1ZVcmx1VTBUeEJLREhPVFRRSml5b3lFeHRaNHF5U3A4bGlmaDFpQkxDbFVhS3c5N3YxOEEzWWVURURKL0Q5TUlSWjJNd0Z1VW0xd0E4enhtRnRNM1FxSHFIMkFONURoMW0reGhiSitELzZHb0F0UGhTVWxwM2ViLzViZG1DYWtnd1RhSFVwZnRoMFpFa0ZOT2c4cDZOdmFOQ21raDNnR0tLaDZOdEtqTjc2YUxIdU5NREx4ZmhZSUhIU05pVDB6cUYrVlZGazZXcjhXL1NFRUljSnZDNnNKQXRBNXZYYkd6WVpPMytubkgyUDFOTkg2ZTB0KytlOXBpMXIrM2k4TXVSU25FSTJmeUVXZjNyOVVQU3lsNXlKRWEwR2wrNUFodktTVHZDR3puSU9ReEN1WUprTng2aERnPT0iLCJtYWMiOiI1YWIzOGE1ZmQ5ZGQ1NGFkZWZiNjZlMDhhYmY1MjE3NzJmMDQ0MzFiYTFhOWU2ZGMzOGNlNzcwOWI2ODI2YmU3IiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6ImJQZlc5dW4zNU9VNHFtZTBYNWdkWVE9PSIsInZhbHVlIjoiOTFWNDlhUWs2bW5STFRjcWI0ZDBrOVZnZDdyb1lFN3MvTnFWZHNnWWNsTThPR1JyU3dqRlB0TTNsa3hxOHNOVWljRTRIWWp0clpWS2pvMXE1VHc0bTQ5SWNyclQyNU1WZCtseitDNFM4OC9JRlBSblRKNWw0dEI2N3JYYXV3RVFqbFFxWk44cno0cDBoL1dNVlRZcGZnPT0iLCJtYWMiOiIxYzQ2YTBlYWVhNTcyZDE4YzQyYmNiNWQ1OWE0NGUyNGExNDFhNzBmYWZiNWNiNGYxMjllZGYwMDI0NTA2OGViIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05T19:03:02.206561Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lPGKEEO5SFew3TX_eeIODAHfeO0rqvDU_W_vq0619ArIfZiOJruDDatRR82SXtcVg&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=dx3coV6xPXPeKLEMk3AKjGKtc1G1F2dwrhh0v82G', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 18:03:03', '2026-01-05 18:03:03'),
(6, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"google_access_token\":\"eyJpdiI6InpKM0dPR2J1ZkVNN0ZrOW1oaTdnamc9PSIsInZhbHVlIjoiWGczaFdnS3R6UHpQSGlNWDEzcWdwRFZ2T1F4T1M0T1ZVcmx1VTBUeEJLREhPVFRRSml5b3lFeHRaNHF5U3A4bGlmaDFpQkxDbFVhS3c5N3YxOEEzWWVURURKL0Q5TUlSWjJNd0Z1VW0xd0E4enhtRnRNM1FxSHFIMkFONURoMW0reGhiSitELzZHb0F0UGhTVWxwM2ViLzViZG1DYWtnd1RhSFVwZnRoMFpFa0ZOT2c4cDZOdmFOQ21raDNnR0tLaDZOdEtqTjc2YUxIdU5NREx4ZmhZSUhIU05pVDB6cUYrVlZGazZXcjhXL1NFRUljSnZDNnNKQXRBNXZYYkd6WVpPMytubkgyUDFOTkg2ZTB0KytlOXBpMXIrM2k4TXVSU25FSTJmeUVXZjNyOVVQU3lsNXlKRWEwR2wrNUFodktTVHZDR3puSU9ReEN1WUprTng2aERnPT0iLCJtYWMiOiI1YWIzOGE1ZmQ5ZGQ1NGFkZWZiNjZlMDhhYmY1MjE3NzJmMDQ0MzFiYTFhOWU2ZGMzOGNlNzcwOWI2ODI2YmU3IiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6ImJQZlc5dW4zNU9VNHFtZTBYNWdkWVE9PSIsInZhbHVlIjoiOTFWNDlhUWs2bW5STFRjcWI0ZDBrOVZnZDdyb1lFN3MvTnFWZHNnWWNsTThPR1JyU3dqRlB0TTNsa3hxOHNOVWljRTRIWWp0clpWS2pvMXE1VHc0bTQ5SWNyclQyNU1WZCtseitDNFM4OC9JRlBSblRKNWw0dEI2N3JYYXV3RVFqbFFxWk44cno0cDBoL1dNVlRZcGZnPT0iLCJtYWMiOiIxYzQ2YTBlYWVhNTcyZDE4YzQyYmNiNWQ1OWE0NGUyNGExNDFhNzBmYWZiNWNiNGYxMjllZGYwMDI0NTA2OGViIiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05 19:03:02\"}', '{\"google_access_token\":\"eyJpdiI6IlRKNVkyNS9aTGliRVptcHJueTQ0MUE9PSIsInZhbHVlIjoiVXlBclBHTWdSakZnU3oxTWE4U282WERQWGpmbWdlQU5XWWxHc2RLK3p5ekhVZFRoWmpZL0xUanRSSXpKb29pTWx6RHNiazZacmxmMTFJMEpTMWhtZ1lRM0dZaVlZcUlOZy9ZazdSakY5RDhHTHZ6cE9DT0U1R2tvbE9zQmordXY0VkhXSWlaQ3dLN3pEWXlUNjVsOEo4WlpSR2d3VEN0RVVHUTdZdWN6VDlDNXpWc2FUdVBTZzB6K0xBTDBKS1EvbHpNdDJQbDdMcm1uRlYrMVJzTzhGREpLNkFIMEcvSGx0R0dLa3FKU1E1RnYrOG50bHhoaTdIMzZ1QXVXU3cwbjduQjFTelVIL25rczU2ZmUvZ2RheFBaTmprbFBodFVBTlpHUHltaUtzSUsrRHNnNnRZcTZ5ZDhoeW0vU0Y2K05HWHJoWmI3ODdSeUk1OTQrWHVkVjdBPT0iLCJtYWMiOiI5Y2FmODhhMzMzMTc0ODA0MWY3NDEzZjZlZGFhZmI0ZTg2MjYyMTdmMDU4YzNmZjRkMjE4MjAyNWM3M2E4MzhkIiwidGFnIjoiIn0=\",\"google_refresh_token\":\"eyJpdiI6Ii9FNjQ3eFNBMnp0OEIwSHpHdFhOa0E9PSIsInZhbHVlIjoibU5DSDc3OFJCOU9uSDlMQ3RzUXpEZUdzdFBNeTJGVCtMOTdtSXp2YmpmemF4TmFreUV2VjBiWm1VcUYyOEdwZXRxWUNpekJINW1EaGd3TzJveVJucTFRUVMvQmY1U2RucVdHeEljWXlZbjNDNkQ1MnFhaXdQWFI3SkM5K1lUbTBOV05tbmd0dk5lV2tPYkIxYlhvUUZnPT0iLCJtYWMiOiIwM2YxODEzZmMzYzNmOWQ4ODFmZGE3ZjY5NWIzZjJlM2VlNTE0MzY2N2QxYzdiZjE0YTU4YThjN2M4YTFkMDA3IiwidGFnIjoiIn0=\",\"google_expires_at\":\"2026-01-05T19:08:34.656749Z\"}', 'http://localhost:8000/auth/google/callback?authuser=0&code=4%2F0ATX87lONxOEMATYRbAjN8q0CQZHOF_8vrmmAVCh0FSthjrh-hspQZ3zeiR1EUU2cc6MmSA&prompt=consent&scope=email%20profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20openid&state=gQx3sJCAdkoc4tuEJeiIBpmGE6QP6Q4Nfnh3y2Em', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-05 18:08:35', '2026-01-05 18:08:35'),
(7, NULL, NULL, 'created', 'App\\Models\\Booking\\BookingBooking', 1, '[]', '{\"room_id\":1,\"username\":\"Dima\",\"start_time\":\"2026-01-08 04:00:00\",\"end_time\":\"2026-01-08 05:00:00\",\"password_to_delete\":\"pass\",\"status\":\"confirmed\",\"id\":1}', 'http://localhost:8000/api/rooms/1/bookings', '172.18.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', NULL, '2026-01-07 22:13:35', '2026-01-07 22:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `booking_bookings`
--

CREATE TABLE `booking_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_to_delete` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `total_hours` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_bookings`
--

INSERT INTO `booking_bookings` (`id`, `room_id`, `username`, `password_to_delete`, `user_id`, `start_time`, `end_time`, `total_hours`, `total_price`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Dima', 'pass', NULL, '2026-01-08 04:00:00', '2026-01-08 05:00:00', NULL, NULL, 'confirmed', '2026-01-07 22:13:35', '2026-01-07 22:13:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_rooms`
--

CREATE TABLE `booking_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int NOT NULL DEFAULT '1',
  `price_per_hour` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_rooms`
--

INSERT INTO `booking_rooms` (`id`, `name`, `type`, `capacity`, `price_per_hour`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Room-1', 'suite', 4, 193.83, 'Veniam occaecati qui est non. Ipsam repellendus debitis consequatur accusantium illum facilis. Officiis sed aut corrupti voluptatem ea. Illum omnis sequi voluptatem. Qui fugit ut eum error aliquam voluptatibus quia.', 1, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(2, 'Room-2', 'suite', 6, 310.01, 'Eum facilis voluptas et ab. Voluptates voluptates itaque quae non. Aut reiciendis amet sint rerum. Laborum maxime aspernatur non natus est molestias.', 1, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_filament_cache_livewire-rate-limiter:287b58015ec6ed41cc45119562d7402bb1069aed', 'i:1;', 1767276339),
('laravel_filament_cache_livewire-rate-limiter:287b58015ec6ed41cc45119562d7402bb1069aed:timer', 'i:1767276339;', 1767276339),
('laravel_filament_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:18:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"view owner\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"view owners\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"edit owners\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"delete owners\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"view venue \";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"view venues\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"edit venue\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"delete venue\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:18:\"create permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"update permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:18:\"delete permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:11:\"view audits\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:25:\"view owner admin quantity\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"view scramble docs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:3:{s:1:\"a\";i:18;s:1:\"b\";s:20:\"not admin permission\";s:1:\"c\";s:3:\"web\";}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"user\";s:1:\"c\";s:3:\"web\";}}}', 1767909230);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `trademark_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `trademark_name`, `model_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Technics', 'G-120', 'Sit quia aut.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(2, 'Technics', 'SL-1200', 'Eum sint sed.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(3, 'Pioneer', 'M-1000', 'Nam laborum neque.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(4, 'Pioneer', 'SL-1200', 'Saepe eaque.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(5, 'Pioneer', 'G-120', 'Reiciendis eius veniam rem.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(6, 'Numark', '500', 'Nisi quas commodi nihil cum.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(7, 'Vestax', 'G-120', 'Quo rerum incidunt.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(8, 'Vestax', 'G-120', 'Quidem placeat natus.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(9, 'Vestax', '500', 'Exercitationem non deserunt.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(10, 'Technics', 'G-120', 'Consequatur incidunt eum rem.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(11, 'Vestax', '500', 'Debitis qui cupiditate natus.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(12, 'Numark', 'G-120', 'Quibusdam qui quas beatae.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(13, 'Pioneer', '500', 'Reprehenderit minus dignissimos eligendi.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(14, 'Pioneer', '500', 'Vitae impedit odio distinctio.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(15, 'Numark', '500', 'Sapiente et officiis.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(16, 'Technics', 'G-120', 'Illum ea unde aliquam.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(17, 'Vestax', 'M-1000', 'Maxime autem quis sed.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(18, 'Numark', 'SL-1200', 'Reiciendis labore deleniti.', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(19, 'Technics', 'SL-1200', 'Aliquam provident.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(20, 'Vestax', 'M-1000', 'Odio impedit qui incidunt ut.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(21, 'Pioneer', '500', 'Voluptatibus quia alias ipsa.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(22, 'Pioneer', 'M-1000', 'Rem totam non.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(23, 'Vestax', 'G-120', 'Sit harum minus iusto.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(24, 'Pioneer', 'SL-1200', 'Beatae natus id tempore.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(25, 'Technics', '500', 'Aut non aut.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(26, 'Vestax', 'M-1000', 'Dolorem porro excepturi.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(27, 'Pioneer', 'SL-1200', 'Dolore dicta hic pariatur.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(28, 'Pioneer', '500', 'Quo omnis nobis omnis.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(29, 'Pioneer', '500', 'Ipsam illo repellat.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(30, 'Vestax', 'SL-1200', 'Veniam quia.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(31, 'Vestax', 'G-120', 'Quia non deleniti et.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(32, 'Vestax', 'G-120', 'Odit sed explicabo possimus cupiditate.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(33, 'Technics', 'M-1000', 'In rerum suscipit quas.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(34, 'Pioneer', 'SL-1200', 'Provident nobis.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(35, 'Pioneer', 'M-1000', 'Voluptatum optio ipsum.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(36, 'Vestax', 'SL-1200', 'Sunt perspiciatis eius quidem sapiente.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(37, 'Vestax', 'G-120', 'Corporis neque laboriosam.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(38, 'Technics', 'M-1000', 'Est voluptas nihil.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(39, 'Pioneer', '500', 'Aliquam quae.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(40, 'Pioneer', 'SL-1200', 'Earum facilis nihil est.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(41, 'Pioneer', '500', 'Est adipisci harum voluptatem.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(42, 'Technics', '500', 'Alias voluptates incidunt.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(43, 'Technics', 'G-120', 'Nihil beatae et minus.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(44, 'Pioneer', '500', 'Ut sunt ut.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(45, 'Pioneer', '500', 'Nulla eum mollitia beatae eaque.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(46, 'Pioneer', 'G-120', 'Odit officia minus in.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(47, 'Vestax', 'SL-1200', 'Ipsum provident.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(48, 'Vestax', 'G-120', 'Facilis reprehenderit a facilis.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(49, 'Technics', 'G-120', 'Et molestiae.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(50, 'Technics', 'G-120', 'Similique soluta in.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(51, 'Technics', 'M-1000', 'Laudantium quasi dicta.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(52, 'Numark', 'G-120', 'Repudiandae cumque quasi.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(53, 'Vestax', 'M-1000', 'Eius delectus qui dolor ut.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(54, 'Technics', '500', 'Molestias nemo.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(55, 'Pioneer', '500', 'Aperiam suscipit.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(56, 'Pioneer', 'SL-1200', 'Dolore autem non.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(57, 'Numark', 'M-1000', 'Est explicabo dolore.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(58, 'Vestax', '500', 'Quisquam saepe sint culpa.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(59, 'Vestax', 'G-120', 'Sunt est quidem molestiae.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(60, 'Vestax', 'M-1000', 'Magnam nemo ducimus.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(61, 'Vestax', 'SL-1200', 'Ullam a voluptate et ut.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(62, 'Pioneer', 'G-120', 'Repellendus mollitia quam.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(63, 'Vestax', 'M-1000', 'Sed ullam est quam.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(64, 'Pioneer', 'G-120', 'Voluptates veritatis sed.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(65, 'Vestax', '500', 'Voluptas quia laboriosam doloribus quis.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(66, 'Technics', '500', 'Sequi eius corrupti.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(67, 'Technics', 'M-1000', 'Nostrum asperiores est porro.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(68, 'Numark', 'M-1000', 'Nemo id possimus odio.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(69, 'Technics', 'G-120', 'Fuga itaque ut est.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(70, 'Technics', 'SL-1200', 'Inventore perferendis aliquid reiciendis vel.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(71, 'Vestax', 'M-1000', 'Totam accusamus optio consectetur.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(72, 'Pioneer', 'G-120', 'Reiciendis amet consequuntur.', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_venue`
--

CREATE TABLE `equipment_venue` (
  `equipment_id` bigint UNSIGNED NOT NULL,
  `venue_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_venue`
--

INSERT INTO `equipment_venue` (`equipment_id`, `venue_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 1, NULL, NULL),
(3, 1, NULL, NULL),
(4, 2, NULL, NULL),
(5, 2, NULL, NULL),
(6, 2, NULL, NULL),
(7, 3, NULL, NULL),
(8, 3, NULL, NULL),
(9, 3, NULL, NULL),
(10, 4, NULL, NULL),
(11, 4, NULL, NULL),
(12, 4, NULL, NULL),
(13, 5, NULL, NULL),
(14, 5, NULL, NULL),
(15, 5, NULL, NULL),
(16, 6, NULL, NULL),
(17, 6, NULL, NULL),
(18, 6, NULL, NULL),
(19, 7, NULL, NULL),
(20, 7, NULL, NULL),
(21, 7, NULL, NULL),
(22, 8, NULL, NULL),
(23, 8, NULL, NULL),
(24, 8, NULL, NULL),
(25, 9, NULL, NULL),
(26, 9, NULL, NULL),
(27, 9, NULL, NULL),
(28, 10, NULL, NULL),
(29, 10, NULL, NULL),
(30, 10, NULL, NULL),
(31, 11, NULL, NULL),
(32, 11, NULL, NULL),
(33, 11, NULL, NULL),
(34, 12, NULL, NULL),
(35, 12, NULL, NULL),
(36, 12, NULL, NULL),
(37, 13, NULL, NULL),
(38, 13, NULL, NULL),
(39, 13, NULL, NULL),
(40, 14, NULL, NULL),
(41, 14, NULL, NULL),
(42, 14, NULL, NULL),
(43, 15, NULL, NULL),
(44, 15, NULL, NULL),
(45, 15, NULL, NULL),
(46, 16, NULL, NULL),
(47, 16, NULL, NULL),
(48, 16, NULL, NULL),
(49, 17, NULL, NULL),
(50, 17, NULL, NULL),
(51, 17, NULL, NULL),
(52, 18, NULL, NULL),
(53, 18, NULL, NULL),
(54, 18, NULL, NULL),
(55, 19, NULL, NULL),
(56, 19, NULL, NULL),
(57, 19, NULL, NULL),
(58, 20, NULL, NULL),
(59, 20, NULL, NULL),
(60, 20, NULL, NULL),
(61, 21, NULL, NULL),
(62, 21, NULL, NULL),
(63, 21, NULL, NULL),
(64, 22, NULL, NULL),
(65, 22, NULL, NULL),
(66, 22, NULL, NULL),
(67, 23, NULL, NULL),
(68, 23, NULL, NULL),
(69, 23, NULL, NULL),
(70, 24, NULL, NULL),
(71, 24, NULL, NULL),
(72, 24, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_20_135953_create_owners_table', 1),
(5, '2025_06_20_140022_create_venues_table', 1),
(6, '2025_06_20_140044_create_equipment_table', 1),
(7, '2025_06_20_140127_create_equipment_venue_table', 1),
(8, '2025_06_20_140244_add_column_options_to_owners_table', 1),
(9, '2025_06_20_140320_add_location_to_venues_table', 1),
(10, '2025_06_23_161855_create_permission_tables', 1),
(11, '2025_06_28_112729_add_image_to_owners_table', 1),
(12, '2025_06_28_131136_create_personal_access_tokens_table', 1),
(13, '2025_07_02_114605_create_audits_table', 1),
(14, '2025_07_02_132132_add_description_and_status_to_users_table', 1),
(15, '2025_07_12_130133_create_notifications_table', 1),
(16, '2025_07_30_170410_add_cashier_columns_to_users_table', 1),
(17, '2025_08_04_134619_create_products_table', 1),
(18, '2025_08_04_162022_create_orders_table', 1),
(19, '2025_08_04_162306_create_order_items_table', 1),
(20, '2025_08_22_135958_create_one_time_links', 1),
(21, '2025_09_16_161533_add_google_tokens_to_users_table', 1),
(22, '2025_10_10_161734_create_user_images_gcloud_table', 1),
(23, '2025_12_16_162519_create_booking_rooms_table', 1),
(24, '2025_12_16_162757_create_booking_bookings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `one_time_links`
--

CREATE TABLE `one_time_links` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `one_time_links`
--

INSERT INTO `one_time_links` (`id`, `token`, `used`, `created_at`, `updated_at`) VALUES
(1, 'PceVDFIhhhjMsiqMtjuIfJvOq1liKxMnPomm0Tzz', 0, '2026-01-07 22:12:26', '2026-01-07 22:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `stripe_session_id` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `first_name`, `last_name`, `email`, `image`, `phone`, `confirmed`, `location`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Christina', 'Hodkiewicz', 'janick50@example.com', 'https://picsum.photos/400/300?random=9797', '+38098233687', 1, 'EUU', NULL, '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(2, 'Billie', 'Dooley', 'ustracke@example.com', 'https://picsum.photos/400/300?random=5299', '+38077359022', 0, 'EUU', NULL, '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(3, 'Chauncey', 'Zulauf', 'feest.alexandra@example.net', 'https://picsum.photos/400/300?random=6209', '+38098098341', 1, 'UAA', NULL, '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(4, 'Myra', 'Cole', 'diana44@example.net', 'https://picsum.photos/400/300?random=1809', '+38059992397', 0, 'UAA', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(5, 'Alexane', 'Hansen', 'murray.breitenberg@example.net', 'https://picsum.photos/400/300?random=6800', '+38038855371', 1, 'EUU', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(6, 'Ali', 'Marks', 'edavis@example.org', 'https://picsum.photos/400/300?random=6158', '+38096369183', 0, 'UAA', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(7, 'Grayce', 'Friesen', 'graham05@example.net', 'https://picsum.photos/400/300?random=4013', '+38020801842', 1, 'EUU', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(8, 'Rosendo', 'Gusikowski', 'jjerde@example.net', 'https://picsum.photos/400/300?random=9644', '+38028134707', 0, 'EUU', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(9, 'Amir', 'Ullrich', 'hagenes.andy@example.net', 'https://picsum.photos/400/300?random=9870', '+38069520420', 1, 'UAA', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(10, 'Nettie', 'Botsford', 'laverna.wehner@example.com', 'https://picsum.photos/400/300?random=5062', '+38010924071', 0, 'EUU', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(11, 'Bud', 'Dooley', 'llabadie@example.org', 'https://picsum.photos/400/300?random=2381', '+38034327842', 1, 'EUU', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(12, 'Laury', 'Beer', 'vrunolfsdottir@example.net', 'https://picsum.photos/400/300?random=5624', '+38000896779', 0, 'UAA', NULL, '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view owner', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(2, 'view owners', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(3, 'edit owners', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(4, 'delete owners', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(5, 'view venue ', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(6, 'view venues', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(7, 'edit venue', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(8, 'delete venue', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(9, 'view roles', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(10, 'create roles', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(11, 'view permissions', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(12, 'create permissions', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(13, 'update permissions', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(14, 'delete permissions', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(15, 'view audits', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(16, 'view owner admin quantity', 'api', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(17, 'view scramble docs', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(18, 'not admin permission', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'authSanctumToken', 'b0fcbf469c68e25e331e12f1a7556b7d196ad4a604dab047b9ec0be80d181d3f', '[\"*\"]', NULL, NULL, '2026-01-02 18:30:31', '2026-01-02 18:30:31'),
(2, 'App\\Models\\User', 1, 'authSanctumToken', 'cccd38783defd6e70a7a04630e4404b701f6f91135aeb304791ce3f1c530eb45', '[\"*\"]', '2026-01-02 18:31:11', NULL, '2026-01-02 18:31:00', '2026-01-02 18:31:11'),
(3, 'App\\Models\\User', 1, 'filament', 'a8b8194397df34bfcacdc76707e9c1897d70ce1ffca9b783480a36b076458278', '[\"*\"]', '2026-01-07 21:53:53', NULL, '2026-01-07 21:53:52', '2026-01-07 21:53:53'),
(4, 'App\\Models\\User', 1, 'filament', 'ac6eb1b8d9c38db377ff22b0dd1219060f3895d8b72f96bf71cf4065c33df15c', '[\"*\"]', '2026-01-07 21:54:03', NULL, '2026-01-07 21:54:02', '2026-01-07 21:54:03'),
(5, 'App\\Models\\User', 1, 'filament', 'bd515035498af2206eac0a0bedb2a2a3d2168c4fb08aa013450d38075865628c', '[\"*\"]', '2026-01-07 21:54:08', NULL, '2026-01-07 21:54:07', '2026-01-07 21:54:08'),
(6, 'App\\Models\\User', 1, 'filament', '7ccceb079d27fbf6af14d5050c0003a3f1871123f37187ef71607be5c9c65f57', '[\"*\"]', '2026-01-07 21:54:13', NULL, '2026-01-07 21:54:12', '2026-01-07 21:54:13'),
(7, 'App\\Models\\User', 1, 'filament', '27af3f6ba7031e4a662671f3d321ef56898ad532978b71f1ae523d03d3a8d8e1', '[\"*\"]', '2026-01-07 21:54:18', NULL, '2026-01-07 21:54:18', '2026-01-07 21:54:18'),
(8, 'App\\Models\\User', 1, 'filament', '62b4d1946c4e1604b433458e2546ef6d5549905c31db1454c0512420ef19b136', '[\"*\"]', '2026-01-07 21:54:23', NULL, '2026-01-07 21:54:22', '2026-01-07 21:54:23'),
(9, 'App\\Models\\User', 1, 'filament', '94b35de514d9f849e98f20f063141416fda3070dea6a5266f2ff632ad0ec73e9', '[\"*\"]', '2026-01-07 21:54:28', NULL, '2026-01-07 21:54:28', '2026-01-07 21:54:28'),
(10, 'App\\Models\\User', 1, 'filament', '0e7af450ab0f982b240f45253bde0884e21e2f230b4b4dc2994665311a97ae6e', '[\"*\"]', '2026-01-07 21:54:33', NULL, '2026-01-07 21:54:33', '2026-01-07 21:54:33'),
(11, 'App\\Models\\User', 1, 'filament', 'e45ac6651f0424673bc6c394daee8a7bed1c328d4c3f5f041f8137acc00a34e0', '[\"*\"]', '2026-01-07 21:54:38', NULL, '2026-01-07 21:54:38', '2026-01-07 21:54:38'),
(12, 'App\\Models\\User', 1, 'filament', '86e710a1bc7a5a703addcbcea3d7edd298a45f3500be06d2dfb3bdfc3ec78bd0', '[\"*\"]', '2026-01-07 21:54:43', NULL, '2026-01-07 21:54:43', '2026-01-07 21:54:43'),
(13, 'App\\Models\\User', 1, 'filament', 'b597d0b9905abd197db453fc7c4c000ac5fdec6af4402659e8569679fc55dd42', '[\"*\"]', '2026-01-07 21:54:48', NULL, '2026-01-07 21:54:48', '2026-01-07 21:54:48'),
(14, 'App\\Models\\User', 1, 'filament', 'f3c170d60542626654293c3ea11c9c59e0e52a83e43aa0aedc95b63a7de83dd1', '[\"*\"]', '2026-01-07 21:54:53', NULL, '2026-01-07 21:54:53', '2026-01-07 21:54:53'),
(15, 'App\\Models\\User', 1, 'filament', '0fb94f8bba308c2faed1d07284c876ed7c730de657961b7090b8a3a9a3d7e110', '[\"*\"]', '2026-01-07 21:54:58', NULL, '2026-01-07 21:54:57', '2026-01-07 21:54:58'),
(16, 'App\\Models\\User', 1, 'filament', 'c81fa505061a758b767e99efce06991f0f249541804e6b32fc82a27bd15662cb', '[\"*\"]', '2026-01-07 21:55:03', NULL, '2026-01-07 21:55:03', '2026-01-07 21:55:03'),
(17, 'App\\Models\\User', 1, 'filament', 'b6bdc77ee04fe841f7748b7420346c49e998a707664dd23a0a44a7291f4caf32', '[\"*\"]', '2026-01-07 21:55:08', NULL, '2026-01-07 21:55:08', '2026-01-07 21:55:08'),
(18, 'App\\Models\\User', 1, 'filament', 'f56eeb40a003c35d4f117a640bf8db4bde94af94c087c47400900b097388cdb1', '[\"*\"]', '2026-01-07 21:55:13', NULL, '2026-01-07 21:55:12', '2026-01-07 21:55:13'),
(19, 'App\\Models\\User', 1, 'filament', 'cff519005b9b8fc5878f74c0a79c50fc68711124e03433e595dfbc066494538e', '[\"*\"]', '2026-01-07 21:55:18', NULL, '2026-01-07 21:55:18', '2026-01-07 21:55:18'),
(20, 'App\\Models\\User', 1, 'filament', 'dcd9150946dd6bf641af1f8079a964aaf1a299cb330e005486d27305c717b6da', '[\"*\"]', '2026-01-07 21:55:23', NULL, '2026-01-07 21:55:22', '2026-01-07 21:55:23'),
(21, 'App\\Models\\User', 1, 'filament', '031e42a208cfe5dc6c9c6148ba639c7452072c16d46495f305c9c18702faeb45', '[\"*\"]', '2026-01-07 21:55:28', NULL, '2026-01-07 21:55:27', '2026-01-07 21:55:28'),
(22, 'App\\Models\\User', 1, 'filament', '102e63a035c98dc3fbb9a537258491b75a8d273c4b05705b785479711c047bc3', '[\"*\"]', '2026-01-07 21:55:33', NULL, '2026-01-07 21:55:32', '2026-01-07 21:55:33'),
(23, 'App\\Models\\User', 1, 'filament', 'd03da97858415926c3a3e781d09df6d8ef139ad987055e4e8e66f35b5e416862', '[\"*\"]', '2026-01-07 21:55:38', NULL, '2026-01-07 21:55:37', '2026-01-07 21:55:38'),
(24, 'App\\Models\\User', 1, 'filament', '63f7417f96caba5b9fc652e6c0483a657fd727639fab8e8674f345463ba04e7a', '[\"*\"]', '2026-01-07 21:55:43', NULL, '2026-01-07 21:55:43', '2026-01-07 21:55:43'),
(25, 'App\\Models\\User', 1, 'filament', 'f8b4929a4321cf2ff57068645f45ae46710ababf9389c04f63756a489c4e030c', '[\"*\"]', '2026-01-07 21:55:48', NULL, '2026-01-07 21:55:48', '2026-01-07 21:55:48'),
(26, 'App\\Models\\User', 1, 'filament', '986a07e9c25984ab7a7a09d547dfd3b3595531d39c85fd6f8ebd88d75998cc1a', '[\"*\"]', '2026-01-07 21:55:53', NULL, '2026-01-07 21:55:53', '2026-01-07 21:55:53'),
(27, 'App\\Models\\User', 1, 'filament', '944d4f0d75534e50c06b5aee9ba7944d81ced6c3d831218a9536e53e855519d8', '[\"*\"]', '2026-01-07 21:55:58', NULL, '2026-01-07 21:55:58', '2026-01-07 21:55:58'),
(28, 'App\\Models\\User', 1, 'filament', '59a6ebeea59a62d9ee536eb45ce8f36648624e954788d86710380bc7dcf76d74', '[\"*\"]', '2026-01-07 21:56:03', NULL, '2026-01-07 21:56:03', '2026-01-07 21:56:03'),
(29, 'App\\Models\\User', 1, 'filament', '3db9cb5066f7ca499d849b9226282dc2e1fc94f0d1c112935e03aa2b8e9c4a38', '[\"*\"]', '2026-01-07 21:56:08', NULL, '2026-01-07 21:56:08', '2026-01-07 21:56:08'),
(30, 'App\\Models\\User', 1, 'filament', '99ad0e24b7254d8753a92a98e18f8830fb5f10ee3f061d5893fddb68fd773b84', '[\"*\"]', '2026-01-07 21:56:13', NULL, '2026-01-07 21:56:13', '2026-01-07 21:56:13'),
(31, 'App\\Models\\User', 1, 'filament', 'dfd6259db16ea6e0f8a8b09ad96ff4cbde11e405fee8bdc430d0b36f12c816cb', '[\"*\"]', '2026-01-07 21:56:18', NULL, '2026-01-07 21:56:17', '2026-01-07 21:56:18'),
(32, 'App\\Models\\User', 1, 'filament', 'ace69e7458d02ab0eba7b2422755ed3d29dd0da2bbbab3b680b16b9a8cf33fc1', '[\"*\"]', '2026-01-07 21:56:23', NULL, '2026-01-07 21:56:23', '2026-01-07 21:56:23'),
(33, 'App\\Models\\User', 1, 'filament', 'c9a436a0518fd13500b3931ce18af248228a04aa23ea26a7d098d149d8f0cb99', '[\"*\"]', '2026-01-07 21:56:28', NULL, '2026-01-07 21:56:27', '2026-01-07 21:56:28'),
(34, 'App\\Models\\User', 1, 'filament', 'fb0cd64c5b4e4a6075276e082cece73a394bf0839fe26e02ca57952757fca7b0', '[\"*\"]', '2026-01-07 21:56:33', NULL, '2026-01-07 21:56:33', '2026-01-07 21:56:33'),
(35, 'App\\Models\\User', 1, 'filament', 'c4cf6d03513d1e6f383ff9c17f7cb2344f086700d6613325064c248bea92e376', '[\"*\"]', '2026-01-07 21:56:38', NULL, '2026-01-07 21:56:38', '2026-01-07 21:56:38'),
(36, 'App\\Models\\User', 1, 'filament', 'df22377cda04ca755e4ee1bda4112af3901a65b4420434bdf4dfc2f13f9e3af1', '[\"*\"]', '2026-01-07 21:56:43', NULL, '2026-01-07 21:56:43', '2026-01-07 21:56:43'),
(37, 'App\\Models\\User', 1, 'filament', '16937f6a2c24f3ebd92ac15ed509af7a8d49e247accd5beb2a279fe2b06bd087', '[\"*\"]', '2026-01-07 21:56:48', NULL, '2026-01-07 21:56:48', '2026-01-07 21:56:48'),
(38, 'App\\Models\\User', 1, 'filament', 'ee896eeb113a18ced967f7a11e004ec55c4503c79dd3fb4e52da460dc52de32c', '[\"*\"]', '2026-01-07 21:56:53', NULL, '2026-01-07 21:56:53', '2026-01-07 21:56:53'),
(39, 'App\\Models\\User', 1, 'filament', 'b4a3668568dceace2fdee6bcdb0a29ffa966c31b4a3c5471dcec54cf2c73b62a', '[\"*\"]', '2026-01-07 21:56:58', NULL, '2026-01-07 21:56:57', '2026-01-07 21:56:58'),
(40, 'App\\Models\\User', 1, 'filament', '4a31eee194919e3bc5700be08178ff683d4782f4f772175483b67f0bd19d0e76', '[\"*\"]', '2026-01-07 21:57:03', NULL, '2026-01-07 21:57:03', '2026-01-07 21:57:03'),
(41, 'App\\Models\\User', 1, 'filament', '95ff7a2453a3ea1ac5a8490e6a0e71d484797ab3c10e6893ce5521ee85df0358', '[\"*\"]', '2026-01-07 21:57:08', NULL, '2026-01-07 21:57:07', '2026-01-07 21:57:08'),
(42, 'App\\Models\\User', 1, 'filament', 'fba83f747fb7fb62f14b746e0bd527d4da354c0c935d9405f00a80dd548106a1', '[\"*\"]', '2026-01-07 21:57:13', NULL, '2026-01-07 21:57:13', '2026-01-07 21:57:13'),
(43, 'App\\Models\\User', 1, 'filament', '980fc4e1863e7a9d2a0f1c7a6bb46b0608945e5593b60c8517de8ef1f7fcc237', '[\"*\"]', '2026-01-07 21:57:18', NULL, '2026-01-07 21:57:17', '2026-01-07 21:57:18'),
(44, 'App\\Models\\User', 1, 'filament', 'a9a6f9f70f0be9945f7fb114a7c33c770326234543c3d15843d233edb2c74e9f', '[\"*\"]', '2026-01-07 21:57:23', NULL, '2026-01-07 21:57:22', '2026-01-07 21:57:23'),
(45, 'App\\Models\\User', 1, 'filament', '2846aea49f21324176f65219ebc1ee514816212612df3064f748b1c6fa91ee68', '[\"*\"]', '2026-01-07 21:57:28', NULL, '2026-01-07 21:57:27', '2026-01-07 21:57:28'),
(46, 'App\\Models\\User', 1, 'filament', '0e552784f36c6c30699563ab9725b99c2027a3e871e64b9fef0397832afb4c79', '[\"*\"]', '2026-01-07 21:57:33', NULL, '2026-01-07 21:57:32', '2026-01-07 21:57:33'),
(47, 'App\\Models\\User', 1, 'filament', '1c60e9c934cfd0657b3cc6a96fabf783cce4d18d3dee8bb7833e5d8c4c65e812', '[\"*\"]', '2026-01-07 21:57:38', NULL, '2026-01-07 21:57:37', '2026-01-07 21:57:38'),
(48, 'App\\Models\\User', 1, 'filament', '051b7111110eb881669d5a001065f9efd75cdd568671748ba9a00699968c61e0', '[\"*\"]', '2026-01-07 21:57:43', NULL, '2026-01-07 21:57:42', '2026-01-07 21:57:43'),
(49, 'App\\Models\\User', 1, 'filament', '41a7d5c91a86d378868fe2fc233c7c84436ae0ff15bb2173f054915b249b1120', '[\"*\"]', '2026-01-07 21:57:48', NULL, '2026-01-07 21:57:48', '2026-01-07 21:57:48'),
(50, 'App\\Models\\User', 1, 'filament', '81c4bec92feed6175bddf938c399b7af01047b4cbd874e324a636f6f94031cf8', '[\"*\"]', '2026-01-07 21:57:53', NULL, '2026-01-07 21:57:52', '2026-01-07 21:57:53'),
(51, 'App\\Models\\User', 1, 'filament', '44d892ec9431a275e1b3351042ec25ae04d7305dcd23e294faef5c6a20fd8707', '[\"*\"]', '2026-01-07 21:57:58', NULL, '2026-01-07 21:57:58', '2026-01-07 21:57:58'),
(52, 'App\\Models\\User', 1, 'filament', '9093408ef405c6bd70228570f9a685849ee87e5a66baf0a594d0209109d60d31', '[\"*\"]', '2026-01-07 21:58:03', NULL, '2026-01-07 21:58:03', '2026-01-07 21:58:03'),
(53, 'App\\Models\\User', 1, 'filament', '523192082026f633ed211ff7a701690a83bc1b1696c0e74a361c1fc1d057346f', '[\"*\"]', '2026-01-07 21:58:08', NULL, '2026-01-07 21:58:08', '2026-01-07 21:58:08'),
(54, 'App\\Models\\User', 1, 'filament', '61fd97e13e7d58e78b514c92696607632fc63f4cc1657e6c3d59dcdb39923a33', '[\"*\"]', '2026-01-07 21:58:13', NULL, '2026-01-07 21:58:13', '2026-01-07 21:58:13'),
(55, 'App\\Models\\User', 1, 'filament', '9d7c4be23e349ff5248732129f07382f8a909b1b3a09013a8599e07280ca4caf', '[\"*\"]', '2026-01-07 21:58:18', NULL, '2026-01-07 21:58:17', '2026-01-07 21:58:18'),
(56, 'App\\Models\\User', 1, 'filament', 'c0e9d011dbf491f8ea52a361b131693ee754bcc3b1e36a25f610e272911a94ff', '[\"*\"]', '2026-01-07 21:58:23', NULL, '2026-01-07 21:58:23', '2026-01-07 21:58:23'),
(57, 'App\\Models\\User', 1, 'filament', 'f2285943c3fccd533620ec6c8b73210dd5cdfb681fac8c445f256675716c7586', '[\"*\"]', '2026-01-07 21:58:28', NULL, '2026-01-07 21:58:27', '2026-01-07 21:58:28'),
(58, 'App\\Models\\User', 1, 'filament', 'a9643fe78f7788537d75d1d5ee001dac5b7680f77f88e4941f1ba63e5c487014', '[\"*\"]', '2026-01-07 21:58:33', NULL, '2026-01-07 21:58:32', '2026-01-07 21:58:33'),
(59, 'App\\Models\\User', 1, 'filament', '3a8ebd48b7da1f31f9ca5d2ddb9568f060c5a5b087d84158fded0ab90bcfe2b6', '[\"*\"]', '2026-01-07 21:58:38', NULL, '2026-01-07 21:58:37', '2026-01-07 21:58:38'),
(60, 'App\\Models\\User', 1, 'filament', '2385e2dbf6a33a1de49d88d2bc0c07c1c293e6eed7f5f9a49366df46a409fc5c', '[\"*\"]', '2026-01-07 21:58:43', NULL, '2026-01-07 21:58:43', '2026-01-07 21:58:43'),
(61, 'App\\Models\\User', 1, 'filament', '4be5c3d49428307e748844d0bb41d000b4ba9c27da75f617f25dedcb1f34e53b', '[\"*\"]', '2026-01-07 21:58:48', NULL, '2026-01-07 21:58:47', '2026-01-07 21:58:48'),
(62, 'App\\Models\\User', 1, 'filament', '4f90aaec1e8f297207c63896d5bb518d6e4eaf2b4b8202ee9c19695188f1ba7d', '[\"*\"]', '2026-01-07 21:58:53', NULL, '2026-01-07 21:58:53', '2026-01-07 21:58:53'),
(63, 'App\\Models\\User', 1, 'filament', '89477c349bb946b45ba1b2a0ddc6d9f8a3a9f20e44de9056f6bdd96b0a0a6929', '[\"*\"]', '2026-01-07 21:58:58', NULL, '2026-01-07 21:58:58', '2026-01-07 21:58:58'),
(64, 'App\\Models\\User', 1, 'filament', '8ade6406d5203f3adb5ad761253f2527194bb3469de18d2a0765c6944eaf31af', '[\"*\"]', '2026-01-07 21:59:03', NULL, '2026-01-07 21:59:02', '2026-01-07 21:59:03'),
(65, 'App\\Models\\User', 1, 'filament', '6da6d44d1e2ed2f57a9cc2a9d962cb1a7031f697d90fa33cfb6747a23cdfb135', '[\"*\"]', '2026-01-07 21:59:08', NULL, '2026-01-07 21:59:08', '2026-01-07 21:59:08'),
(66, 'App\\Models\\User', 1, 'filament', '8142a2d22756e991b1aba6348218f822c90fa61f30c3966c2af0355f2e188eaa', '[\"*\"]', '2026-01-07 21:59:13', NULL, '2026-01-07 21:59:12', '2026-01-07 21:59:13'),
(67, 'App\\Models\\User', 1, 'filament', '91ec9073f3cd7cee170d1ad9a3edc3ca0df06fad0c1b451b711d2d403a27427e', '[\"*\"]', '2026-01-07 21:59:18', NULL, '2026-01-07 21:59:18', '2026-01-07 21:59:18'),
(68, 'App\\Models\\User', 1, 'filament', '733efae1ee61324a702d5c3fe1228549c2f7a2528c2f5176d93ad0c68f5d45c7', '[\"*\"]', '2026-01-07 21:59:23', NULL, '2026-01-07 21:59:23', '2026-01-07 21:59:23'),
(69, 'App\\Models\\User', 1, 'filament', '7c543d960ed10fbda469b3726327d6123a2dd56153e4692215fe869e7dbbcc15', '[\"*\"]', '2026-01-07 21:59:28', NULL, '2026-01-07 21:59:28', '2026-01-07 21:59:28'),
(70, 'App\\Models\\User', 1, 'filament', 'e4c41fda4ca367b055396db5a5e88b42334b30c047763135a555d77ba7f548b6', '[\"*\"]', '2026-01-07 21:59:33', NULL, '2026-01-07 21:59:33', '2026-01-07 21:59:33'),
(71, 'App\\Models\\User', 1, 'filament', '158814d2f69226bbb32afac57b85c8e8e9d8c0eac00d73db8c44fd2279fc215b', '[\"*\"]', '2026-01-07 21:59:38', NULL, '2026-01-07 21:59:37', '2026-01-07 21:59:38'),
(72, 'App\\Models\\User', 1, 'filament', 'aec1be48056720bdd6913561c2c49a4c47e3ea8a60143a9fe22ac17cd1a9adbb', '[\"*\"]', '2026-01-07 21:59:43', NULL, '2026-01-07 21:59:43', '2026-01-07 21:59:43'),
(73, 'App\\Models\\User', 1, 'filament', 'f1d9e8366221e8352ae883112cb7e81dfe0edc98ba4e0a328f8478b0b4458bad', '[\"*\"]', '2026-01-07 21:59:48', NULL, '2026-01-07 21:59:48', '2026-01-07 21:59:48'),
(74, 'App\\Models\\User', 1, 'filament', '4f68e8fac71802a0ed30c03798496c1b86d5b570276da10e0faf9f92a36197e2', '[\"*\"]', '2026-01-07 21:59:53', NULL, '2026-01-07 21:59:53', '2026-01-07 21:59:53'),
(75, 'App\\Models\\User', 1, 'filament', 'f584b57bc969bd4daf7798845cd37346e5c2dc0fe01690593b287e06cc7bec30', '[\"*\"]', '2026-01-07 21:59:58', NULL, '2026-01-07 21:59:58', '2026-01-07 21:59:58'),
(76, 'App\\Models\\User', 1, 'filament', 'bfba3fe9f28525a73bf05e9a8aa268b7d7b4aa0d2018e3b7b52aaf0d0c8653e9', '[\"*\"]', '2026-01-07 22:00:03', NULL, '2026-01-07 22:00:03', '2026-01-07 22:00:03'),
(77, 'App\\Models\\User', 1, 'filament', '78289d218d26b01e39cafad89bb56d0e82e94e6e34fa0c628b9d2a424800819e', '[\"*\"]', '2026-01-07 22:00:08', NULL, '2026-01-07 22:00:08', '2026-01-07 22:00:08'),
(78, 'App\\Models\\User', 1, 'filament', '17092084b91dacd39466b53b8e2b6bd40a326376b8054c715cc7d8f0e2b38491', '[\"*\"]', '2026-01-07 22:00:13', NULL, '2026-01-07 22:00:13', '2026-01-07 22:00:13'),
(79, 'App\\Models\\User', 1, 'filament', 'fa082397d57e9c213c502ca432173059d4656a75a1beee958dbacf06d25b3f08', '[\"*\"]', '2026-01-07 22:00:18', NULL, '2026-01-07 22:00:17', '2026-01-07 22:00:18'),
(80, 'App\\Models\\User', 1, 'filament', '43c9e26cc98bee61a79c13226618bb2ccbe4b1050ffd8a46195fc9ed230a46af', '[\"*\"]', '2026-01-07 22:00:23', NULL, '2026-01-07 22:00:23', '2026-01-07 22:00:23'),
(81, 'App\\Models\\User', 1, 'filament', '6c6310d04f7e33994be4246d80b02b1d350ae11b00751a9c8a98cd62e3641f72', '[\"*\"]', '2026-01-07 22:00:28', NULL, '2026-01-07 22:00:27', '2026-01-07 22:00:28'),
(82, 'App\\Models\\User', 1, 'filament', '9d0b51e6d2f159f765fce875521e6c032f80f65a6b67fe5325ff58036e4b8bab', '[\"*\"]', '2026-01-07 22:00:33', NULL, '2026-01-07 22:00:33', '2026-01-07 22:00:33'),
(83, 'App\\Models\\User', 1, 'filament', 'bbac6b50b680d67bbce3fe52fb637cfe9e283bf253d3464becaa2752f6d815eb', '[\"*\"]', '2026-01-07 22:00:38', NULL, '2026-01-07 22:00:38', '2026-01-07 22:00:38'),
(84, 'App\\Models\\User', 1, 'filament', 'd980cd97782527d78380821a11ccbf8c5948857abdd9c1656f2a10e37eea3509', '[\"*\"]', '2026-01-07 22:00:43', NULL, '2026-01-07 22:00:43', '2026-01-07 22:00:43'),
(85, 'App\\Models\\User', 1, 'filament', 'c7090b764cbdd2948d2a171b71e158702faf0357035174cdfdec4729eca9231c', '[\"*\"]', '2026-01-07 22:00:48', NULL, '2026-01-07 22:00:48', '2026-01-07 22:00:48'),
(86, 'App\\Models\\User', 1, 'filament', '80e130ea02ce61c49c87d5f796fa824218b8dac1a78f742bd15f7cb0602e1837', '[\"*\"]', '2026-01-07 22:00:53', NULL, '2026-01-07 22:00:53', '2026-01-07 22:00:53'),
(87, 'App\\Models\\User', 1, 'filament', 'ca2d7b0d953e9477f0879b4f260f533c4da75d56cddd15199030a6bef6125b99', '[\"*\"]', '2026-01-07 22:00:58', NULL, '2026-01-07 22:00:58', '2026-01-07 22:00:58'),
(88, 'App\\Models\\User', 1, 'filament', '46f0de65243677159e574919720da25cfa431f3bcd893aabb9185b8a443d9991', '[\"*\"]', '2026-01-07 22:01:03', NULL, '2026-01-07 22:01:03', '2026-01-07 22:01:03'),
(89, 'App\\Models\\User', 1, 'filament', '582d481cb610b269f8a6059e3a0d1f93424a616dc63b796d82db206d49b21693', '[\"*\"]', '2026-01-07 22:01:08', NULL, '2026-01-07 22:01:07', '2026-01-07 22:01:08'),
(90, 'App\\Models\\User', 1, 'filament', '9ac6089d837c93b00d852bf587c375de1a2a18c0fd06a12bdf05c93316b4685f', '[\"*\"]', '2026-01-07 22:01:13', NULL, '2026-01-07 22:01:12', '2026-01-07 22:01:13'),
(91, 'App\\Models\\User', 1, 'filament', 'c2b24d7dae0e3c085ed022973113bfba07e1fa8d9d8d16aa3717b6fc823ac07b', '[\"*\"]', '2026-01-07 22:01:18', NULL, '2026-01-07 22:01:18', '2026-01-07 22:01:18'),
(92, 'App\\Models\\User', 1, 'filament', '8ceb1c305764d644e397d473bac32644b1a652c2053dace8e59bb3284d32da8b', '[\"*\"]', '2026-01-07 22:01:23', NULL, '2026-01-07 22:01:23', '2026-01-07 22:01:23'),
(93, 'App\\Models\\User', 1, 'filament', '5fa9cad1b14c9ce01425b8b1cadc8b83a1fd11d707afbdbba21d720d33ba5465', '[\"*\"]', '2026-01-07 22:01:28', NULL, '2026-01-07 22:01:28', '2026-01-07 22:01:28'),
(94, 'App\\Models\\User', 1, 'filament', 'c7be673af269f6a98691fc1ed1ce7245ac16fe0a9077eddb81aaff75bfa2b8e1', '[\"*\"]', '2026-01-07 22:01:33', NULL, '2026-01-07 22:01:33', '2026-01-07 22:01:33'),
(95, 'App\\Models\\User', 1, 'filament', '77f4be88d20ca8be188b81fbb2d64a6ca8b5ac983eae63b44dff3bbe1f89b9f7', '[\"*\"]', '2026-01-07 22:01:38', NULL, '2026-01-07 22:01:37', '2026-01-07 22:01:38'),
(96, 'App\\Models\\User', 1, 'filament', '5c3c45ec178804c9cdf51cfa6957bcb06211c14c27a78bd03d799253b2cf9046', '[\"*\"]', '2026-01-07 22:01:43', NULL, '2026-01-07 22:01:43', '2026-01-07 22:01:43'),
(97, 'App\\Models\\User', 1, 'filament', 'd883d3c271429be1dd7eff2ba99bce653940ef8aee407b3b3f38f38f3a7ec236', '[\"*\"]', '2026-01-07 22:01:48', NULL, '2026-01-07 22:01:47', '2026-01-07 22:01:48'),
(98, 'App\\Models\\User', 1, 'filament', 'c953cdc1e9079ae71a7f0331c09796dc81589f6aee10d2079e96634b79456249', '[\"*\"]', '2026-01-07 22:01:53', NULL, '2026-01-07 22:01:52', '2026-01-07 22:01:53'),
(99, 'App\\Models\\User', 1, 'filament', '2e9fbd56247c5c262ff0b7619d53c32849f53a1c2747849c7b4506c799ce8d97', '[\"*\"]', '2026-01-07 22:01:58', NULL, '2026-01-07 22:01:58', '2026-01-07 22:01:58'),
(100, 'App\\Models\\User', 1, 'filament', '4db813e02f01169bdfee731bb24e16cde3e8cb29281b8a4bafca4d0e33992ca5', '[\"*\"]', '2026-01-07 22:02:03', NULL, '2026-01-07 22:02:02', '2026-01-07 22:02:03'),
(101, 'App\\Models\\User', 1, 'filament', '9b3d3d0dfbe85678d4b26bfcb2725b773dc32294f2c08b3122f151c55a54e8ce', '[\"*\"]', '2026-01-07 22:02:08', NULL, '2026-01-07 22:02:07', '2026-01-07 22:02:08'),
(102, 'App\\Models\\User', 1, 'filament', '3c777a79764f0265c410e093ed6f1b4a3d89ae4bd85ce7ecc02d9087d1db14a8', '[\"*\"]', '2026-01-07 22:02:13', NULL, '2026-01-07 22:02:13', '2026-01-07 22:02:13'),
(103, 'App\\Models\\User', 1, 'filament', '1e75f7f4e5b1b7a23a27f350ea15f1415dd3404ca8356dfac5d4a6891da64a4c', '[\"*\"]', '2026-01-07 22:02:18', NULL, '2026-01-07 22:02:18', '2026-01-07 22:02:18'),
(104, 'App\\Models\\User', 1, 'filament', 'a01a61a945c097e6249e94fbd665bc9958136d3981e35b530b0e07526c2ac291', '[\"*\"]', '2026-01-07 22:02:23', NULL, '2026-01-07 22:02:23', '2026-01-07 22:02:23'),
(105, 'App\\Models\\User', 1, 'filament', '2d8451214c6976e3a8e8ec4863a5884133de8d00eb035e0e047e330e6bee648b', '[\"*\"]', '2026-01-07 22:02:28', NULL, '2026-01-07 22:02:27', '2026-01-07 22:02:28'),
(106, 'App\\Models\\User', 1, 'filament', '8f72240d37b63e1099dc31dcee9005ddb20e79c09b239f5114f1541b6cf12b83', '[\"*\"]', '2026-01-07 22:02:33', NULL, '2026-01-07 22:02:33', '2026-01-07 22:02:33'),
(107, 'App\\Models\\User', 1, 'filament', '18a326102c18be316cc008674c5dad808ec8f1e666cade0534414abdb408b912', '[\"*\"]', '2026-01-07 22:02:38', NULL, '2026-01-07 22:02:37', '2026-01-07 22:02:38'),
(108, 'App\\Models\\User', 1, 'filament', 'a6c9ffb0ecf33592d4d1ece17137bf4c7d0b57e96a9431e88a4bc3a386f0b0e3', '[\"*\"]', '2026-01-07 22:02:43', NULL, '2026-01-07 22:02:42', '2026-01-07 22:02:43'),
(109, 'App\\Models\\User', 1, 'filament', '7ceda1ecb0787a638533bc9ccb88466d46616807da8c3281d35d565f9aeb5f95', '[\"*\"]', '2026-01-07 22:02:48', NULL, '2026-01-07 22:02:48', '2026-01-07 22:02:48'),
(110, 'App\\Models\\User', 1, 'filament', '766b949f7624fda279a344f0d3760e43a4d61abd62d558199e9e832f9e250095', '[\"*\"]', '2026-01-07 22:02:53', NULL, '2026-01-07 22:02:53', '2026-01-07 22:02:53'),
(111, 'App\\Models\\User', 1, 'filament', 'ac4f46fde5be7b6d2d5597c9f931bb72db2c05fd1d1b826308a7cbade23982fe', '[\"*\"]', '2026-01-07 22:02:58', NULL, '2026-01-07 22:02:58', '2026-01-07 22:02:58'),
(112, 'App\\Models\\User', 1, 'filament', '8575f68f4110f5a29040c7a1a70b325c7f5fbf43fd8f9f946fe020e5afb868cc', '[\"*\"]', '2026-01-07 22:03:03', NULL, '2026-01-07 22:03:02', '2026-01-07 22:03:03'),
(113, 'App\\Models\\User', 1, 'filament', 'dcf09d907d7a0f22ab4c99fe15a57c41114f69b312e6577fe8f72f3410be2b1a', '[\"*\"]', '2026-01-07 22:03:08', NULL, '2026-01-07 22:03:07', '2026-01-07 22:03:08'),
(114, 'App\\Models\\User', 1, 'filament', '2bdf7f41a299c728e48b3f0db636e0064b23c0edff8bf187f7759d110aba3495', '[\"*\"]', '2026-01-07 22:03:13', NULL, '2026-01-07 22:03:13', '2026-01-07 22:03:13'),
(115, 'App\\Models\\User', 1, 'filament', 'd6d6a333bdf4a21c75f6fde986fbd193aad4fc76491c5273956d0d175720e5d5', '[\"*\"]', '2026-01-07 22:03:18', NULL, '2026-01-07 22:03:17', '2026-01-07 22:03:18'),
(116, 'App\\Models\\User', 1, 'filament', 'f0be18ef910b7286eb8a1425b8766b77efb1ea71e775b846ac22de0863746166', '[\"*\"]', '2026-01-07 22:03:23', NULL, '2026-01-07 22:03:22', '2026-01-07 22:03:23'),
(117, 'App\\Models\\User', 1, 'filament', 'abd9bf9608f9d27d6415b7f6376f24abc023cb552f90d0fe4811ff56f2ebedbb', '[\"*\"]', '2026-01-07 22:03:28', NULL, '2026-01-07 22:03:28', '2026-01-07 22:03:28'),
(118, 'App\\Models\\User', 1, 'filament', '5372d9941ee38c08d97134c2edbfb21c28ae6dfbcb03d84ae099daaf2d65f223', '[\"*\"]', '2026-01-07 22:03:33', NULL, '2026-01-07 22:03:32', '2026-01-07 22:03:33'),
(119, 'App\\Models\\User', 1, 'filament', '017bc60c2eb511ba73eaa28823994247832047c99a9c5636c49baa56711987ae', '[\"*\"]', '2026-01-07 22:03:38', NULL, '2026-01-07 22:03:38', '2026-01-07 22:03:38'),
(120, 'App\\Models\\User', 1, 'filament', '236fd63ef6d429a4545a41323905820e2b41877b2580bd3148da5a788aa397df', '[\"*\"]', '2026-01-07 22:03:43', NULL, '2026-01-07 22:03:43', '2026-01-07 22:03:43'),
(121, 'App\\Models\\User', 1, 'filament', 'b221d67822a4d3a3d6240d7747da8883a4a283451c857144754fd3994b0bb917', '[\"*\"]', '2026-01-07 22:03:48', NULL, '2026-01-07 22:03:48', '2026-01-07 22:03:48'),
(122, 'App\\Models\\User', 1, 'filament', 'e6f1f009624175b963f17deb3b537104bbeebb9491ce6d05cda79045dd0f6f3a', '[\"*\"]', '2026-01-07 22:03:53', NULL, '2026-01-07 22:03:52', '2026-01-07 22:03:53'),
(123, 'App\\Models\\User', 1, 'filament', 'c508c576b1ac8722cb484277d2278efb237199584cf7addf31b981d36e2a0913', '[\"*\"]', '2026-01-07 22:03:58', NULL, '2026-01-07 22:03:58', '2026-01-07 22:03:58'),
(124, 'App\\Models\\User', 1, 'filament', 'f0e1d2720584e7a3e837403d3c694d0f9899b17f0d018951ab0a9899f93c2147', '[\"*\"]', '2026-01-07 22:04:03', NULL, '2026-01-07 22:04:02', '2026-01-07 22:04:03'),
(125, 'App\\Models\\User', 1, 'filament', '6acb655286a5e6afc4610eb49c2fdf37ae566814160f0ce399d5873dede6a0a7', '[\"*\"]', '2026-01-07 22:04:08', NULL, '2026-01-07 22:04:08', '2026-01-07 22:04:08'),
(126, 'App\\Models\\User', 1, 'filament', '7bc5dd715fa8f802ee012e3e7a9a81416891083634bad137fb7909f77a576447', '[\"*\"]', '2026-01-07 22:04:13', NULL, '2026-01-07 22:04:13', '2026-01-07 22:04:13'),
(127, 'App\\Models\\User', 1, 'filament', '02a9ad09de7a2b489c8ba817de2af35d8006a5b7903c0f7d4f4ee14caee8748b', '[\"*\"]', '2026-01-07 22:04:18', NULL, '2026-01-07 22:04:17', '2026-01-07 22:04:18'),
(128, 'App\\Models\\User', 1, 'filament', '35d7cb323490bd81915bb25c72678e26212ab5cf5617d4fec36113cbcf011c51', '[\"*\"]', '2026-01-07 22:04:23', NULL, '2026-01-07 22:04:23', '2026-01-07 22:04:23'),
(129, 'App\\Models\\User', 1, 'filament', 'cde231f5710d68cf3e03a7544988c312032d0f1f90f7658f43640222700da089', '[\"*\"]', '2026-01-07 22:04:28', NULL, '2026-01-07 22:04:27', '2026-01-07 22:04:28'),
(130, 'App\\Models\\User', 1, 'filament', '66fe7d338daca8e893750025d4c4a67f33814b974f089a0b30380b8255146cfa', '[\"*\"]', '2026-01-07 22:04:33', NULL, '2026-01-07 22:04:32', '2026-01-07 22:04:33'),
(131, 'App\\Models\\User', 1, 'filament', 'b875a13980fd34932df7e23bff45f0d9b2f9459d634762e80ded39f346b687ce', '[\"*\"]', '2026-01-07 22:04:38', NULL, '2026-01-07 22:04:37', '2026-01-07 22:04:38'),
(132, 'App\\Models\\User', 1, 'filament', 'f0cab27a639687d4131a8e8c6500186054729ee034bed690160d628702a452f0', '[\"*\"]', '2026-01-07 22:04:43', NULL, '2026-01-07 22:04:43', '2026-01-07 22:04:43'),
(133, 'App\\Models\\User', 1, 'filament', '43d46aa43c2f95825bb3f6417f829fcd6663017621995e9219f84d81b116e1e0', '[\"*\"]', '2026-01-07 22:04:48', NULL, '2026-01-07 22:04:47', '2026-01-07 22:04:48'),
(134, 'App\\Models\\User', 1, 'filament', 'afbeac85e426a2cc8e382835d8a1726fea70682502dfcf48bd7d23ee1da5ed77', '[\"*\"]', '2026-01-07 22:04:53', NULL, '2026-01-07 22:04:53', '2026-01-07 22:04:53'),
(135, 'App\\Models\\User', 1, 'filament', 'cf0559b1bde91840d6911248e8e3efd55b36d6a10f810464d98bcc16606fc1bf', '[\"*\"]', '2026-01-07 22:04:58', NULL, '2026-01-07 22:04:57', '2026-01-07 22:04:58'),
(136, 'App\\Models\\User', 1, 'filament', '384d5f5b9868400f767a2e1962a5cb1f17b0d1b88d5bc7502c776c906aa2addf', '[\"*\"]', '2026-01-07 22:05:03', NULL, '2026-01-07 22:05:02', '2026-01-07 22:05:03'),
(137, 'App\\Models\\User', 1, 'filament', 'fa3ec0af962170c62989e754405bd4effac86b0b5c092e2fe59d54f7f8dc6422', '[\"*\"]', '2026-01-07 22:05:08', NULL, '2026-01-07 22:05:08', '2026-01-07 22:05:08'),
(138, 'App\\Models\\User', 1, 'filament', 'd5c4d2832e26c381326e01140ec1c6226aba0eea2fa62d6d37e2f00d3aafceec', '[\"*\"]', '2026-01-07 22:05:13', NULL, '2026-01-07 22:05:13', '2026-01-07 22:05:13'),
(139, 'App\\Models\\User', 1, 'filament', 'ccfaec357fbe2d07e7798a3808dd5ccd4f7245cd2376033d876f399aefb11622', '[\"*\"]', '2026-01-07 22:05:18', NULL, '2026-01-07 22:05:17', '2026-01-07 22:05:18'),
(140, 'App\\Models\\User', 1, 'filament', '720f12abd32efe620677c9bb5137923c3b597c875b0232b3869785060d6a4aad', '[\"*\"]', '2026-01-07 22:05:23', NULL, '2026-01-07 22:05:22', '2026-01-07 22:05:23'),
(141, 'App\\Models\\User', 1, 'filament', 'a2845ab938bfa4a01c3b445526c014aa4591d3f278b5c4daf5f3785a776e9ab2', '[\"*\"]', '2026-01-07 22:05:28', NULL, '2026-01-07 22:05:27', '2026-01-07 22:05:28'),
(142, 'App\\Models\\User', 1, 'filament', 'eb0ff6097374007d5790ba4e7f661dc044c16800c63c4091f2520524db794b40', '[\"*\"]', '2026-01-07 22:05:33', NULL, '2026-01-07 22:05:32', '2026-01-07 22:05:33'),
(143, 'App\\Models\\User', 1, 'filament', '6693d5c1058b6bb575ba0748a7d9b82cd94385c1a47bf5f66d5d63518747c05a', '[\"*\"]', '2026-01-07 22:05:38', NULL, '2026-01-07 22:05:38', '2026-01-07 22:05:38'),
(144, 'App\\Models\\User', 1, 'filament', 'a7aede8fb0601242e31ba75437dba1d80c6ceab3fd8cd040b2ea3f8bf6862f00', '[\"*\"]', '2026-01-07 22:05:43', NULL, '2026-01-07 22:05:42', '2026-01-07 22:05:43'),
(145, 'App\\Models\\User', 1, 'filament', '3b1b5714292b896ef6628cf78fdc9932a405a4c0efb2a82b09ed82683fcb1da3', '[\"*\"]', '2026-01-07 22:05:48', NULL, '2026-01-07 22:05:47', '2026-01-07 22:05:48'),
(146, 'App\\Models\\User', 1, 'filament', '3e051e3f265a3b9ecb8ea04752b69daa220fe0854e8adeaa15801bea39b6ca6b', '[\"*\"]', '2026-01-07 22:05:53', NULL, '2026-01-07 22:05:52', '2026-01-07 22:05:53'),
(147, 'App\\Models\\User', 1, 'filament', 'a93d445bfa494126ced7614595e975f479e168af019466bdc4f1feed00fb9cd4', '[\"*\"]', '2026-01-07 22:05:58', NULL, '2026-01-07 22:05:57', '2026-01-07 22:05:58'),
(148, 'App\\Models\\User', 1, 'filament', '7129c843ea31770ff5e6a9ab532bf40a8c2a9c40ee9c1b82d98bad63521b12f8', '[\"*\"]', '2026-01-07 22:06:03', NULL, '2026-01-07 22:06:03', '2026-01-07 22:06:03'),
(149, 'App\\Models\\User', 1, 'filament', '807330d207fa3b13c2d3cccff15ce32dffdce455fb9ad47f5449c08a5ae68ce6', '[\"*\"]', '2026-01-07 22:06:08', NULL, '2026-01-07 22:06:07', '2026-01-07 22:06:08'),
(150, 'App\\Models\\User', 1, 'filament', 'fc6dc9672cc16cd3ca421fcb5dcac0faafffc26a24545db437c8a568ebd94d04', '[\"*\"]', '2026-01-07 22:06:13', NULL, '2026-01-07 22:06:12', '2026-01-07 22:06:13'),
(151, 'App\\Models\\User', 1, 'filament', 'e11b584e8a6f59fa2913f802c3f68ae5810c0254484f5778b1f5d63edb7a6224', '[\"*\"]', '2026-01-07 22:06:18', NULL, '2026-01-07 22:06:17', '2026-01-07 22:06:18'),
(152, 'App\\Models\\User', 1, 'filament', '6680127f9e0875fa49ec657b4f2b17e3e1b9ce3888589b41734b6a57058a7f5a', '[\"*\"]', '2026-01-07 22:06:23', NULL, '2026-01-07 22:06:23', '2026-01-07 22:06:23'),
(153, 'App\\Models\\User', 1, 'filament', 'c18e4eac745fd189bca27337e65a328246aa1ff3f67f40701772eae9bea14c4a', '[\"*\"]', '2026-01-07 22:06:28', NULL, '2026-01-07 22:06:28', '2026-01-07 22:06:28'),
(154, 'App\\Models\\User', 1, 'filament', '963535893fc372255bc5c0ce24f427f54601d1cd2d55a24331e91eaad27227d6', '[\"*\"]', '2026-01-07 22:06:33', NULL, '2026-01-07 22:06:33', '2026-01-07 22:06:33'),
(155, 'App\\Models\\User', 1, 'filament', 'd6c7ea886fa8a7f121d772b5dc1f46c723668b302467856fe48aa75a55571ac7', '[\"*\"]', '2026-01-07 22:06:38', NULL, '2026-01-07 22:06:38', '2026-01-07 22:06:38'),
(156, 'App\\Models\\User', 1, 'filament', '8109c2259612b74b7f55b20338c19387e1f3eb0e3e550082abac47d01f664eb0', '[\"*\"]', '2026-01-07 22:06:43', NULL, '2026-01-07 22:06:42', '2026-01-07 22:06:43'),
(157, 'App\\Models\\User', 1, 'filament', '93d207a44d105d3a3a894b0046523066ee069c22f532e4eb4a90ff1c68e5c16c', '[\"*\"]', '2026-01-07 22:06:48', NULL, '2026-01-07 22:06:48', '2026-01-07 22:06:48'),
(158, 'App\\Models\\User', 1, 'filament', '58c7373ec6fd0d31f85d811761090d1da33d9357762b23a80590b2d1d23be888', '[\"*\"]', '2026-01-07 22:06:53', NULL, '2026-01-07 22:06:52', '2026-01-07 22:06:53'),
(159, 'App\\Models\\User', 1, 'filament', '2526d367d38ddcc40dcc19475e1ea1bea34218c9eef49e1c55758ffb7cfcf917', '[\"*\"]', '2026-01-07 22:06:58', NULL, '2026-01-07 22:06:57', '2026-01-07 22:06:58'),
(160, 'App\\Models\\User', 1, 'filament', '92f508126e82be62c8d76c70ac0423c2298919ebd370aff2cb51395cc42418ef', '[\"*\"]', '2026-01-07 22:07:03', NULL, '2026-01-07 22:07:03', '2026-01-07 22:07:03'),
(161, 'App\\Models\\User', 1, 'filament', '9b2a5effefc884fe9ac6d8a12a784205ad11ecc6e2463dd0861235be014bd8a6', '[\"*\"]', '2026-01-07 22:07:08', NULL, '2026-01-07 22:07:07', '2026-01-07 22:07:08'),
(162, 'App\\Models\\User', 1, 'filament', '9e9acec2672e5669d4bec8840cf4ce289656932e997c4a38205310d6bd90843d', '[\"*\"]', '2026-01-07 22:07:13', NULL, '2026-01-07 22:07:12', '2026-01-07 22:07:13'),
(163, 'App\\Models\\User', 1, 'filament', '52c02bb312e442ef05428ad65887a1217500d3ae2b1e98a13c8ce0b3bd71dd97', '[\"*\"]', '2026-01-07 22:07:18', NULL, '2026-01-07 22:07:18', '2026-01-07 22:07:18'),
(164, 'App\\Models\\User', 1, 'filament', '0122704f41e2c2b80e46dabeac7b3b4b39ce6ba43b3f633e07781d3a5ea6cd40', '[\"*\"]', '2026-01-07 22:07:23', NULL, '2026-01-07 22:07:23', '2026-01-07 22:07:23'),
(165, 'App\\Models\\User', 1, 'filament', 'a68bc3884cdecde40468daeb7905dfd2a375c2e76b4036fd00727107f0a21c73', '[\"*\"]', '2026-01-07 22:07:28', NULL, '2026-01-07 22:07:27', '2026-01-07 22:07:28'),
(166, 'App\\Models\\User', 1, 'filament', '33bbe0d25a3ee48db244778214442e56ba3d6037f5f1984ae78a4a744aee8101', '[\"*\"]', '2026-01-07 22:07:33', NULL, '2026-01-07 22:07:32', '2026-01-07 22:07:33'),
(167, 'App\\Models\\User', 1, 'filament', '885265e96e4470952364b23347cccf6dea3898f34290311a464d579d38a4cad6', '[\"*\"]', '2026-01-07 22:07:38', NULL, '2026-01-07 22:07:38', '2026-01-07 22:07:38'),
(168, 'App\\Models\\User', 1, 'filament', '1b5336b36fc0609ae03b83aeb8bbda397467cb73e0d1a5d5d2435edbe6e3d117', '[\"*\"]', '2026-01-07 22:07:43', NULL, '2026-01-07 22:07:42', '2026-01-07 22:07:43'),
(169, 'App\\Models\\User', 1, 'filament', '867762e0fecf625d4caa592c3571022f084fefa6873c7a32d1b1763764d0b6ac', '[\"*\"]', '2026-01-07 22:07:48', NULL, '2026-01-07 22:07:48', '2026-01-07 22:07:48'),
(170, 'App\\Models\\User', 1, 'filament', '78135ebb2560a4c5bc37a3ed1dd99db05f2ba26ddf9c859793f4cfc669574d94', '[\"*\"]', '2026-01-07 22:07:53', NULL, '2026-01-07 22:07:53', '2026-01-07 22:07:53'),
(171, 'App\\Models\\User', 1, 'filament', '4484e7b14e5d4ec94082488c36cf107ebbcc6e9b77835b8edf8819f68f904252', '[\"*\"]', '2026-01-07 22:07:58', NULL, '2026-01-07 22:07:57', '2026-01-07 22:07:58'),
(172, 'App\\Models\\User', 1, 'filament', 'a209fd257cf9d84b88416d2b328b8c8623a559d539367aef40265023d24a854e', '[\"*\"]', '2026-01-07 22:08:03', NULL, '2026-01-07 22:08:02', '2026-01-07 22:08:03'),
(173, 'App\\Models\\User', 1, 'filament', 'a629ded0337b78513c2f08d10f61f31e29a887238679769505d21f8013e54df3', '[\"*\"]', '2026-01-07 22:08:08', NULL, '2026-01-07 22:08:08', '2026-01-07 22:08:08'),
(174, 'App\\Models\\User', 1, 'filament', '78ca03edb51c72854bc9f035fc7316d88c5faabecd0568b6a5ddd1f3393c5513', '[\"*\"]', '2026-01-07 22:08:13', NULL, '2026-01-07 22:08:12', '2026-01-07 22:08:13'),
(175, 'App\\Models\\User', 1, 'filament', 'f6294160754f15585650281a3df241ad1ab05d2b61e17837a03763216519e34c', '[\"*\"]', '2026-01-07 22:08:18', NULL, '2026-01-07 22:08:18', '2026-01-07 22:08:18'),
(176, 'App\\Models\\User', 1, 'filament', 'bf5bcc660fa23e0e39dd35d9a5059ff196ed64c0a92c24397e50bdafe2222e64', '[\"*\"]', '2026-01-07 22:08:23', NULL, '2026-01-07 22:08:23', '2026-01-07 22:08:23'),
(177, 'App\\Models\\User', 1, 'filament', 'ec865a51bcf866b5ac2fd45f5f335e7e870aea3a6704d96ad96bb96f862cf694', '[\"*\"]', '2026-01-07 22:08:28', NULL, '2026-01-07 22:08:27', '2026-01-07 22:08:28'),
(178, 'App\\Models\\User', 1, 'filament', '046db7144f94f0b0a14c2ffa2e8fd3c602706b76529f1531571d97851c04cf8f', '[\"*\"]', '2026-01-07 22:08:33', NULL, '2026-01-07 22:08:32', '2026-01-07 22:08:33'),
(179, 'App\\Models\\User', 1, 'filament', 'e9ad2896986eaeaf489999baa7230663e9f5a784a959f187ddcab161506adb36', '[\"*\"]', '2026-01-07 22:08:38', NULL, '2026-01-07 22:08:37', '2026-01-07 22:08:38'),
(180, 'App\\Models\\User', 1, 'filament', 'b0bd52a1eabc5ff88a79e1a2566d44487d254d33a4035469d1be24a1f7ed1bc2', '[\"*\"]', '2026-01-07 22:08:43', NULL, '2026-01-07 22:08:42', '2026-01-07 22:08:43'),
(181, 'App\\Models\\User', 1, 'filament', '8918defccbff9076768112e042874eca3c0464dec18e818d0e469ec9f922605f', '[\"*\"]', '2026-01-07 22:08:48', NULL, '2026-01-07 22:08:47', '2026-01-07 22:08:48'),
(182, 'App\\Models\\User', 1, 'filament', '6639b678b0d2b721148b10932015f180f48f7c5c31b7b34b7480a200448e4a8d', '[\"*\"]', '2026-01-07 22:08:53', NULL, '2026-01-07 22:08:52', '2026-01-07 22:08:53'),
(183, 'App\\Models\\User', 1, 'filament', 'a6c5ec00be2afd9dd641295223c5be86f55ff353890b0d299d5ba0646b90e432', '[\"*\"]', '2026-01-07 22:08:58', NULL, '2026-01-07 22:08:58', '2026-01-07 22:08:58'),
(184, 'App\\Models\\User', 1, 'filament', '39a2cb500b868c48ec30e62470c517eace684729c662da9087e1cdfe10c12995', '[\"*\"]', '2026-01-07 22:09:03', NULL, '2026-01-07 22:09:02', '2026-01-07 22:09:03'),
(185, 'App\\Models\\User', 1, 'filament', 'd04b834580d4fb08595d33c6fcabe5d8e301886883a70852ea74757434e6050f', '[\"*\"]', '2026-01-07 22:09:08', NULL, '2026-01-07 22:09:07', '2026-01-07 22:09:08'),
(186, 'App\\Models\\User', 1, 'filament', 'e4a2d097ff451b921654f4aeb2b772b7dbde36e723432a7e120a337f2b6b5bc2', '[\"*\"]', '2026-01-07 22:09:13', NULL, '2026-01-07 22:09:13', '2026-01-07 22:09:13'),
(187, 'App\\Models\\User', 1, 'filament', '66dc650545a789e8e12585856288b1137c963d0a54cb0f14e7d76681833b61f1', '[\"*\"]', '2026-01-07 22:09:18', NULL, '2026-01-07 22:09:18', '2026-01-07 22:09:18'),
(188, 'App\\Models\\User', 1, 'filament', 'a65bdf86ec993ea99090ae1f32b7f8334dcdf5a5fe5e7f7567938f1a122feb9e', '[\"*\"]', '2026-01-07 22:09:23', NULL, '2026-01-07 22:09:22', '2026-01-07 22:09:23'),
(189, 'App\\Models\\User', 1, 'filament', 'ead255953383d1c3d15ae701e607419a3da81111ff06993efe1aedafef2a48e2', '[\"*\"]', '2026-01-07 22:09:28', NULL, '2026-01-07 22:09:27', '2026-01-07 22:09:28'),
(190, 'App\\Models\\User', 1, 'filament', '79642894e738f2b41a2e4bf7ee7d7eef459160776f62acf7d61a63dd1961be1b', '[\"*\"]', '2026-01-07 22:09:33', NULL, '2026-01-07 22:09:33', '2026-01-07 22:09:33'),
(191, 'App\\Models\\User', 1, 'filament', '593aac1bbd4cf572f532c7266983ef1c32fc0b90c54bee63cafbd7942cf494d3', '[\"*\"]', '2026-01-07 22:09:38', NULL, '2026-01-07 22:09:38', '2026-01-07 22:09:38'),
(192, 'App\\Models\\User', 1, 'filament', '73150880725c1bf544eb41714d26f21de9c21f3398bbcc3801887281c1fd90c5', '[\"*\"]', '2026-01-07 22:09:43', NULL, '2026-01-07 22:09:43', '2026-01-07 22:09:43'),
(193, 'App\\Models\\User', 1, 'filament', '3be6cddc1a5edf5970450525910b022609fcfaefe0c8f3dc528ea43f577ab7d1', '[\"*\"]', '2026-01-07 22:09:48', NULL, '2026-01-07 22:09:48', '2026-01-07 22:09:48'),
(194, 'App\\Models\\User', 1, 'filament', 'c3a983525228281c4b591f8f4cc4bcc04e180d680d6c2b499824d229d6283df3', '[\"*\"]', '2026-01-07 22:09:53', NULL, '2026-01-07 22:09:53', '2026-01-07 22:09:53'),
(195, 'App\\Models\\User', 1, 'filament', '95531840b5dae529e839c22e0e81197f48f169c7e79f44ed2472af6486d7d2fc', '[\"*\"]', '2026-01-07 22:09:58', NULL, '2026-01-07 22:09:57', '2026-01-07 22:09:58'),
(196, 'App\\Models\\User', 1, 'filament', 'dc5a5a0dda11ed510bc064e045ab5df16da149dca0eeeca653ecb72041ed4791', '[\"*\"]', '2026-01-07 22:10:03', NULL, '2026-01-07 22:10:02', '2026-01-07 22:10:03'),
(197, 'App\\Models\\User', 1, 'filament', '64fb6d6e8167f540e5e84054d22ead091aeb17ba8ad2b8bd6a1b3a24c73035cc', '[\"*\"]', '2026-01-07 22:10:08', NULL, '2026-01-07 22:10:07', '2026-01-07 22:10:08'),
(198, 'App\\Models\\User', 1, 'filament', '3324d4c39b72e338bb884b891bda760f0755de4546fdbe5efa78e1d909595a99', '[\"*\"]', '2026-01-07 22:10:13', NULL, '2026-01-07 22:10:13', '2026-01-07 22:10:13'),
(199, 'App\\Models\\User', 1, 'filament', '119f34b19b7cf1f7f4c8677b22fb344466f17872d28ce32498c6a7357afef3a2', '[\"*\"]', '2026-01-07 22:10:18', NULL, '2026-01-07 22:10:17', '2026-01-07 22:10:18'),
(200, 'App\\Models\\User', 1, 'filament', 'e5131a52e38f5e305cf7b20a92b03c2a06368ee6e34de1b22789d31e76380865', '[\"*\"]', '2026-01-07 22:10:23', NULL, '2026-01-07 22:10:23', '2026-01-07 22:10:23'),
(201, 'App\\Models\\User', 1, 'filament', '6a3e82c258c791033d09b60912cec093463ba0af7fcae2976b71f2d2d845f9c4', '[\"*\"]', '2026-01-07 22:10:28', NULL, '2026-01-07 22:10:28', '2026-01-07 22:10:28'),
(202, 'App\\Models\\User', 1, 'filament', 'e963bfd068beddd9ed5af72dc8068f2758e0d9f443536c1696d35bfb793a3cda', '[\"*\"]', '2026-01-07 22:10:33', NULL, '2026-01-07 22:10:33', '2026-01-07 22:10:33'),
(203, 'App\\Models\\User', 1, 'filament', 'd47d70559bb0f7ac24bee9631c6be881e1f4b9fe253bb4184af6478f9c1ff8c0', '[\"*\"]', '2026-01-07 22:10:38', NULL, '2026-01-07 22:10:38', '2026-01-07 22:10:38'),
(204, 'App\\Models\\User', 1, 'filament', 'c67a9099b88f2c2e1fa1575063cd89368386de9104fdc974fc5c1b11817dc718', '[\"*\"]', '2026-01-07 22:10:43', NULL, '2026-01-07 22:10:42', '2026-01-07 22:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `sku`, `price`, `discount_price`, `stock`, `image`, `gallery`, `is_active`, `views`, `details`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vestax', 'vestax-78Yei', 'Est nemo quod ipsa perferendis vitae ut dolor asperiores magnam nisi consequatur omnis alias.', 'SKU-4864IL', 317.19, NULL, 72, 'https://picsum.photos/200/150?random=9848', '[\"https://via.placeholder.com/640x480.png/00ff88?text=products+nisi\", \"https://via.placeholder.com/640x480.png/002288?text=products+animi\"]', 1, 214, '{\"color\": \"BlueViolet\", \"material\": \"sit\", \"warranty\": \"1 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(2, 'Numark', 'numark-CmnDP', 'Totam consectetur perspiciatis perferendis quia nihil dignissimos veniam occaecati aut nulla fugit et pariatur aut aspernatur.', 'SKU-3657LI', 356.31, NULL, 97, 'https://picsum.photos/200/150?random=4181', '[\"https://via.placeholder.com/640x480.png/00ddaa?text=products+quo\", \"https://via.placeholder.com/640x480.png/001166?text=products+facilis\"]', 1, 548, '{\"color\": \"Cornsilk\", \"material\": \"odio\", \"warranty\": \"5 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(3, 'AKAI Professional', 'akai-professional-6DPOb', 'Facilis architecto possimus iusto voluptatem et nam laboriosam incidunt fuga eligendi voluptates consequatur corrupti laborum aut magni.', 'SKU-0542ZV', 366.55, NULL, 75, 'https://picsum.photos/200/150?random=7116', '[\"https://via.placeholder.com/640x480.png/003322?text=products+accusamus\", \"https://via.placeholder.com/640x480.png/004477?text=products+est\"]', 1, 556, '{\"color\": \"SkyBlue\", \"material\": \"sequi\", \"warranty\": \"2 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(4, 'Hercules', 'hercules-P9rBa', 'Architecto praesentium veniam magni adipisci tempore sed excepturi repellendus excepturi.', 'SKU-3586HU', 446.59, 197.25, 95, 'https://picsum.photos/200/150?random=5573', '[\"https://via.placeholder.com/640x480.png/000088?text=products+omnis\", \"https://via.placeholder.com/640x480.png/00dd66?text=products+dolor\"]', 1, 636, '{\"color\": \"OrangeRed\", \"material\": \"et\", \"warranty\": \"3 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(5, 'Soundcraft', 'soundcraft-dNf2o', 'Aliquam ut impedit officia velit totam voluptatem amet ut consequuntur placeat dolorum eos esse unde beatae.', 'SKU-3013TM', 161.37, NULL, 23, 'https://picsum.photos/200/150?random=7791', '[\"https://via.placeholder.com/640x480.png/0000ff?text=products+fugiat\", \"https://via.placeholder.com/640x480.png/009955?text=products+inventore\"]', 1, 421, '{\"color\": \"AliceBlue\", \"material\": \"delectus\", \"warranty\": \"2 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(6, 'Serato', 'serato-BinO8', 'Velit quia et a sapiente voluptates porro doloremque architecto eveniet illum est nisi quibusdam cumque quibusdam mollitia doloribus.', 'SKU-8412AG', 441.43, 205.62, 53, 'https://picsum.photos/200/150?random=3469', '[\"https://via.placeholder.com/640x480.png/00aabb?text=products+beatae\", \"https://via.placeholder.com/640x480.png/00ff55?text=products+nobis\"]', 1, 953, '{\"color\": \"DarkGray\", \"material\": \"voluptas\", \"warranty\": \"3 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(7, 'Native Instruments', 'native-instruments-nl71j', 'Quis labore maiores non quis quia sint necessitatibus iste necessitatibus consequatur libero perferendis est veniam ex.', 'SKU-6686JR', 464.02, NULL, 82, 'https://picsum.photos/200/150?random=6630', '[\"https://via.placeholder.com/640x480.png/002277?text=products+aut\", \"https://via.placeholder.com/640x480.png/001188?text=products+ut\"]', 1, 873, '{\"color\": \"CornflowerBlue\", \"material\": \"et\", \"warranty\": \"2 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(8, 'Roland', 'roland-AW6uO', 'Ut distinctio perferendis asperiores a at voluptatibus libero nihil omnis voluptatum maxime.', 'SKU-4482WS', 208.46, NULL, 60, 'https://picsum.photos/200/150?random=3317', '[\"https://via.placeholder.com/640x480.png/004499?text=products+ex\", \"https://via.placeholder.com/640x480.png/00aaaa?text=products+inventore\"]', 1, 953, '{\"color\": \"OliveDrab\", \"material\": \"quaerat\", \"warranty\": \"4 years\"}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27'),
(2, 'user', 'web', '2026-01-01 14:04:27', '2026-01-01 14:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(1, 2),
(2, 2),
(5, 2),
(6, 2),
(15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `google_access_token` text COLLATE utf8mb4_unicode_ci,
  `google_refresh_token` text COLLATE utf8mb4_unicode_ci,
  `google_user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `description`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `google_access_token`, `google_refresh_token`, `google_user_email`, `google_expires_at`) VALUES
(1, 'Dima', 'dima@gmail.com', NULL, '2026-01-01 14:04:26', '$2y$12$nhEPr5rZxNmmQA4bu3nG.elAaQ3gwxrNshzTqzuTo.fi1vHUxAAcu', 1, 'RSL9SqEbju', '2026-01-01 14:04:26', '2026-01-05 18:08:35', NULL, NULL, NULL, NULL, 'eyJpdiI6IlRKNVkyNS9aTGliRVptcHJueTQ0MUE9PSIsInZhbHVlIjoiVXlBclBHTWdSakZnU3oxTWE4U282WERQWGpmbWdlQU5XWWxHc2RLK3p5ekhVZFRoWmpZL0xUanRSSXpKb29pTWx6RHNiazZacmxmMTFJMEpTMWhtZ1lRM0dZaVlZcUlOZy9ZazdSakY5RDhHTHZ6cE9DT0U1R2tvbE9zQmordXY0VkhXSWlaQ3dLN3pEWXlUNjVsOEo4WlpSR2d3VEN0RVVHUTdZdWN6VDlDNXpWc2FUdVBTZzB6K0xBTDBKS1EvbHpNdDJQbDdMcm1uRlYrMVJzTzhGREpLNkFIMEcvSGx0R0dLa3FKU1E1RnYrOG50bHhoaTdIMzZ1QXVXU3cwbjduQjFTelVIL25rczU2ZmUvZ2RheFBaTmprbFBodFVBTlpHUHltaUtzSUsrRHNnNnRZcTZ5ZDhoeW0vU0Y2K05HWHJoWmI3ODdSeUk1OTQrWHVkVjdBPT0iLCJtYWMiOiI5Y2FmODhhMzMzMTc0ODA0MWY3NDEzZjZlZGFhZmI0ZTg2MjYyMTdmMDU4YzNmZjRkMjE4MjAyNWM3M2E4MzhkIiwidGFnIjoiIn0=', 'eyJpdiI6Ii9FNjQ3eFNBMnp0OEIwSHpHdFhOa0E9PSIsInZhbHVlIjoibU5DSDc3OFJCOU9uSDlMQ3RzUXpEZUdzdFBNeTJGVCtMOTdtSXp2YmpmemF4TmFreUV2VjBiWm1VcUYyOEdwZXRxWUNpekJINW1EaGd3TzJveVJucTFRUVMvQmY1U2RucVdHeEljWXlZbjNDNkQ1MnFhaXdQWFI3SkM5K1lUbTBOV05tbmd0dk5lV2tPYkIxYlhvUUZnPT0iLCJtYWMiOiIwM2YxODEzZmMzYzNmOWQ4ODFmZGE3ZjY5NWIzZjJlM2VlNTE0MzY2N2QxYzdiZjE0YTU4YThjN2M4YTFkMDA3IiwidGFnIjoiIn0=', 'dimmm931@gmail.com', '2026-01-05 19:08:34'),
(2, 'Olya', 'olya@gmail.com', NULL, '2026-01-01 14:04:27', '$2y$12$u/RaZ7jcNRHpDCRvPATfDuzirhdlqovO725Xkfq6HYltw3i66JcEi', 1, 'ZKbOZgiJyX', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_images_gcloud`
--

CREATE TABLE `user_images_gcloud` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_images_gcloud`
--

INSERT INTO `user_images_gcloud` (`id`, `user_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://storage.googleapis.com/my-laravel-gcs-bucket/images/X3JaFtkZtvzmSXBEytknGgy87XHRyKe2QgosK5GR.jpg', '2026-01-02 18:31:38', '2026-01-02 18:31:38');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` bigint UNSIGNED NOT NULL,
  `venue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `owner_id` bigint UNSIGNED DEFAULT NULL,
  `location` json DEFAULT NULL COMMENT 'lon, lng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `venue_name`, `address`, `active`, `owner_id`, `location`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fay Group', '39263 Veum Stream\nPort Meggie, WV 04500-9586', 1, 1, '{\"lat\": 39.473038, \"lng\": 3.366142}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(2, 'Blanda, Moore and Renner', '442 Veum Mountains\nChrisside, SD 60002-7972', 1, 1, '{\"lat\": 39.393294, \"lng\": 2.702565}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(3, 'Smitham Ltd', '11989 Billy Estates Suite 228\nEast Caylaview, NV 67421', 1, 2, '{\"lat\": 39.549584, \"lng\": 2.468425}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(4, 'Leannon Ltd', '8202 Grady Mountain\nPort Mckayla, ME 18033-1533', 1, 2, '{\"lat\": 39.415655, \"lng\": 3.506308}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(5, 'Schaden Ltd', '89421 Pollich Wall Apt. 869\nWest Payton, MS 47716', 1, 3, '{\"lat\": 39.219937, \"lng\": 2.556321}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(6, 'Hoeger and Sons', '741 Zechariah Inlet Apt. 455\nVonstad, OH 64828-1936', 1, 3, '{\"lat\": 39.626835, \"lng\": 3.141527}', '2026-01-01 14:04:27', '2026-01-01 14:04:27', NULL),
(7, 'Okuneva, Pfannerstill and Deckow', '678 Beer Estate Apt. 575\nDanielleside, WV 86885', 1, 4, '{\"lat\": 39.395351, \"lng\": 2.896583}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(8, 'Haag, White and Jacobs', '132 Grant Hollow\nStrackefurt, GA 98733', 1, 4, '{\"lat\": 39.822777, \"lng\": 2.855408}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(9, 'Metz, Wilderman and Abernathy', '9949 Smitham Terrace Suite 003\nMaynardtown, ME 39197-9961', 1, 5, '{\"lat\": 39.706484, \"lng\": 2.707311}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(10, 'Hirthe-Jerde', '382 Deondre Island Apt. 817\nBernardshire, PA 36273-0524', 1, 5, '{\"lat\": 39.336421, \"lng\": 3.131362}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(11, 'Kub-Towne', '621 Gottlieb Falls\nNew Reychester, IA 34439-4732', 1, 6, '{\"lat\": 39.202331, \"lng\": 3.440389}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(12, 'Friesen, Abshire and Schultz', '717 Elton Unions\nLake Kraig, MN 45621', 1, 6, '{\"lat\": 39.34004, \"lng\": 2.725813}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(13, 'Hyatt-Hagenes', '54798 Bernhard Ports Apt. 057\nWest Camron, AR 99420-1334', 1, 7, '{\"lat\": 39.477451, \"lng\": 2.599927}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(14, 'Huel Ltd', '315 Miller Road Suite 107\nAlexistown, LA 45953-6598', 1, 7, '{\"lat\": 39.880671, \"lng\": 3.090867}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(15, 'Renner PLC', '4050 Goodwin Track\nNew Brennanfort, SC 88597', 1, 8, '{\"lat\": 39.408644, \"lng\": 2.985339}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(16, 'Johns, Hintz and Littel', '390 Funk Oval\nNew Iliana, SC 34716', 1, 8, '{\"lat\": 39.878164, \"lng\": 2.634279}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(17, 'Zulauf, Price and Ziemann', '6579 Conroy Isle\nMallieborough, NM 13529-8529', 1, 9, '{\"lat\": 39.776564, \"lng\": 2.329993}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(18, 'Bogan PLC', '72754 Bettie Rapid\nThaliaview, FL 26880-8066', 1, 9, '{\"lat\": 39.572795, \"lng\": 2.489255}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(19, 'Murphy, Satterfield and Collier', '468 Champlin Street\nSouth Joana, ME 52283-5202', 1, 10, '{\"lat\": 39.515434, \"lng\": 3.310044}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(20, 'Lindgren PLC', '47417 Brionna Freeway\nAlethaton, LA 60443-8857', 1, 10, '{\"lat\": 39.318873, \"lng\": 3.431953}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(21, 'Hansen-Lubowitz', '22028 Brown River Apt. 268\nWest Nash, NE 57897', 1, 11, '{\"lat\": 39.499035, \"lng\": 3.378833}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(22, 'Windler and Sons', '31251 Cronin Prairie\nEast Sigurdville, ME 26485', 1, 11, '{\"lat\": 39.927879, \"lng\": 2.495909}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(23, 'Willms-Eichmann', '5611 Austen Curve\nEast Bethel, FL 74676', 1, 12, '{\"lat\": 39.236398, \"lng\": 2.795978}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL),
(24, 'Ziemann, Christiansen and Wilderman', '583 Ethyl Club Apt. 413\nCollinshaven, IA 71973', 1, 12, '{\"lat\": 39.442405, \"lng\": 2.847753}', '2026-01-01 14:04:28', '2026-01-01 14:04:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `booking_bookings`
--
ALTER TABLE `booking_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_bookings_user_id_foreign` (`user_id`),
  ADD KEY `booking_bookings_room_id_start_time_end_time_index` (`room_id`,`start_time`,`end_time`);

--
-- Indexes for table `booking_rooms`
--
ALTER TABLE `booking_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment_venue`
--
ALTER TABLE `equipment_venue`
  ADD PRIMARY KEY (`equipment_id`,`venue_id`),
  ADD KEY `equipment_venue_venue_id_foreign` (`venue_id`),
  ADD KEY `equipment_venue_equipment_id_index` (`equipment_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `one_time_links`
--
ALTER TABLE `one_time_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `one_time_links_token_unique` (`token`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `user_images_gcloud`
--
ALTER TABLE `user_images_gcloud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_images_gcloud_user_id_foreign` (`user_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venues_owner_id_index` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_bookings`
--
ALTER TABLE `booking_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_rooms`
--
ALTER TABLE `booking_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `one_time_links`
--
ALTER TABLE `one_time_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_images_gcloud`
--
ALTER TABLE `user_images_gcloud`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_bookings`
--
ALTER TABLE `booking_bookings`
  ADD CONSTRAINT `booking_bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `booking_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment_venue`
--
ALTER TABLE `equipment_venue`
  ADD CONSTRAINT `equipment_venue_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_images_gcloud`
--
ALTER TABLE `user_images_gcloud`
  ADD CONSTRAINT `user_images_gcloud_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
