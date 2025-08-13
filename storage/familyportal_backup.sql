/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: familyportal_db
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `album_media`
--

DROP TABLE IF EXISTS `album_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `album_media` (
  `album_id` bigint(20) unsigned NOT NULL,
  `media_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`album_id`,`media_id`),
  KEY `album_media_media_id_foreign` (`media_id`),
  CONSTRAINT `album_media_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `album_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_media`
--

LOCK TABLES `album_media` WRITE;
/*!40000 ALTER TABLE `album_media` DISABLE KEYS */;
INSERT INTO `album_media` VALUES
(1,31),
(1,32),
(1,33),
(1,36),
(1,37),
(2,35),
(2,38),
(2,39),
(2,40),
(2,41),
(2,42),
(2,43),
(2,44),
(2,45),
(2,46),
(2,48),
(2,49),
(2,50),
(2,51),
(2,52),
(2,53),
(2,54),
(2,55),
(2,56),
(2,57),
(2,74),
(3,1),
(3,2),
(3,95),
(4,34),
(4,47),
(4,66),
(4,67),
(4,68),
(4,70),
(5,9),
(5,91),
(5,92),
(5,93),
(5,94),
(5,105),
(5,106),
(5,107),
(5,108),
(5,109),
(5,110),
(5,111),
(5,113),
(5,114),
(5,115),
(5,122),
(5,123),
(5,124),
(5,125);
/*!40000 ALTER TABLE `album_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `albums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `albums_user_id_foreign` (`user_id`),
  CONSTRAINT `albums_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` VALUES
(1,9,'Im Gartenschaugelände mit den Rutkies/Jürgens','Wir haben uns mit Johannes und seiner Familie im Park der Gartenschau Kaiserslautern getroffen','2025-07-30 05:55:24','2025-07-30 05:55:24'),
(2,9,'Heckings','Die ersten Jahre mit Conny, Lea, Lilith und Richard','2025-07-30 14:27:24','2025-07-30 14:27:24'),
(3,9,'Villa Kastoras','Bilder rund ums Haus','2025-07-30 18:03:38','2025-07-30 18:03:38'),
(4,9,'Ubud','Urlaub in Ubud','2025-08-01 18:21:27','2025-08-01 18:21:27'),
(5,9,'Zypern 2017',NULL,'2025-08-02 05:51:48','2025-08-02 05:51:48');
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `families`
--

DROP TABLE IF EXISTS `families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `families` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `families`
--

LOCK TABLES `families` WRITE;
/*!40000 ALTER TABLE `families` DISABLE KEYS */;
INSERT INTO `families` VALUES
(1,'Wernecke','2025-07-26 14:39:45','2025-07-26 14:39:45'),
(2,'Familie1','2025-08-02 10:57:52','2025-08-02 10:57:52'),
(3,'Geissen','2025-08-03 10:36:26','2025-08-03 10:36:26');
/*!40000 ALTER TABLE `families` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family_media`
--

DROP TABLE IF EXISTS `family_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `family_media` (
  `media_id` bigint(20) unsigned NOT NULL,
  `family_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`media_id`,`family_id`),
  KEY `family_media_family_id_foreign` (`family_id`),
  CONSTRAINT `family_media_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE,
  CONSTRAINT `family_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family_media`
--

LOCK TABLES `family_media` WRITE;
/*!40000 ALTER TABLE `family_media` DISABLE KEYS */;
INSERT INTO `family_media` VALUES
(32,3),
(113,3),
(124,3);
/*!40000 ALTER TABLE `family_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES
(1,'App\\Models\\User',9,'433c57f6-a9c3-4a67-8df2-26a27aa79892','photos','20201130_112951','20201130_112951.jpg','image/jpeg','private_media','private_media',3163619,'[]','{\"description\":\"Setzk\\u00e4sten im Flur der Villa Kastoras\",\"photo_date\":\"2021-02-20\",\"ignore_completeness\":false,\"location\":\"Peyia\",\"photographer\":\"ronald\"}','[]','[]',1,'2025-07-28 05:59:07','2025-07-29 07:03:42'),
(2,'App\\Models\\User',9,'3b684094-c0c0-4034-9c27-a2ce3695f6c0','photos','20211219_110828','20211219_110828.jpg','image/jpeg','private_media','private_media',2331240,'[]','{\"description\":\"Gewitter zieht \\u00fcber dem Meer auf.\\r\\nIn Paphos hat die Sonne eine Wolkenl\\u00fccke gefunden.\",\"photo_date\":\"2021-05-17\",\"ignore_completeness\":false,\"location\":\"Peyia\",\"photographer\":\"ronald\"}','[]','[]',2,'2025-07-28 06:00:38','2025-07-29 07:04:47'),
(8,'App\\Models\\User',9,'b075a05e-c63f-4b6d-a7c0-840811708991','photos','DSCF2860','DSCF2860.JPG','image/jpeg','private_media','private_media',2491471,'[]','{\"description\":\"Tombs of Kings 2016\",\"photo_date\":null}','[]','[]',1,'2025-07-28 14:12:32','2025-08-06 14:26:35'),
(9,'App\\Models\\User',9,'35033d99-63ef-489d-b84f-5e40f49e80dc','photos','DSCF2872','DSCF2872.JPG','image/jpeg','private_media','private_media',3023654,'[]','{\"description\":\"Tombs of Kings\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Paphos\",\"photographer\":\"ronald\"}','[]','[]',8,'2025-07-28 14:29:00','2025-07-29 07:05:37'),
(31,'App\\Models\\User',9,'1021b687-c801-4d06-abc0-73c7495fcfda','photos','20210814_131207','20210814_131207.jpg','image/jpeg','private_media','private_media',2116876,'[]','{\"description\":\"Johannes mit Familie\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kaiserslautern\",\"photographer\":\"ronald\"}','[]','[]',4,'2025-07-28 17:41:08','2025-07-29 07:04:38'),
(32,'App\\Models\\User',9,'acb00ee1-e99a-476c-8c1b-3fe4a3955842','photos','20210814_131145','20210814_131145.jpg','image/jpeg','private_media','private_media',2055503,'[]','{\"description\":\"Johannes\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kaiserslautern\",\"photographer\":\"ronald\"}','[]','[]',3,'2025-07-28 17:42:01','2025-07-29 07:04:05'),
(33,'App\\Models\\User',9,'4057ae98-ea50-445d-90e0-7f1038b4d985','photos','20210814_131507','20210814_131507.jpg','image/jpeg','private_media','private_media',746109,'[]','{\"description\":\"Simone und Niklas im Gartenschaupart Kaiserslautern\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kaiserslautern\",\"photographer\":\"ronald\"}','[]','[]',5,'2025-07-28 18:46:32','2025-07-29 07:05:04'),
(34,'App\\Models\\User',9,'df8e96b3-31a3-40ff-ac3f-236e1071d631','photos','IMG_20150919_045016','IMG_20150919_045016.jpg','image/jpeg','private_media','private_media',1409226,'[]','{\"description\":\"T\\u00fcre zu unserem Zimmer in Ubud - Sanyas House\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',24,'2025-07-28 18:49:43','2025-08-01 18:23:23'),
(35,'App\\Models\\User',9,'9662bc4b-ff4b-4b37-8da7-d1ded63e1544','photos','Cornelius','Cornelius.jpg','image/jpeg','private_media','private_media',340044,'[]','{\"description\":\"Conny der Espressok\\u00f6nig\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Freiburg\",\"photographer\":\"ronald\"}','[]','[]',9,'2025-07-29 02:48:43','2025-07-29 07:06:07'),
(36,'App\\Models\\User',9,'402083a8-d667-4df8-b9df-858c144ac6a3','photos','20210814_131228','20210814_131228.jpg','image/jpeg','private_media','private_media',1833565,'[]','{\"description\":\"Luciana und Niclas im Gartenschaugel\\u00e4nde\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kaiserslautern\",\"photographer\":\"ronald\"}','[]','[]',6,'2025-07-29 11:36:11','2025-07-29 11:36:11'),
(37,'App\\Models\\User',9,'6cfea21d-b5cc-4f9d-b233-afdc671b4ad2','photos','20210814_132444','20210814_132444.jpg','image/jpeg','private_media','private_media',1861341,'[]','{\"description\":\"Johannes im Gartenschaugel\\u00e4nde\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kaiserslautern\",\"photographer\":\"ronald\"}','[]','[]',7,'2025-07-29 11:37:42','2025-07-29 11:37:42'),
(38,'App\\Models\\User',9,'b3c83da0-5d1d-44e4-8518-831d35d10461','photos','IMG-20211206-WA0011','IMG-20211206-WA0011.jpg','image/jpeg','private_media','private_media',165507,'[]','{\"description\":\"Lilith mit Lea\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',10,'2025-07-29 11:38:14','2025-07-29 11:38:14'),
(39,'App\\Models\\User',9,'d217e7ff-9f86-4b11-b2fd-d294fe6c5d23','photos','IMG-20211206-WA0013','IMG-20211206-WA0013.jpg','image/jpeg','private_media','private_media',518396,'[]','{\"description\":\"Conny und Lea\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',11,'2025-07-29 11:38:43','2025-07-29 11:38:43'),
(40,'App\\Models\\User',9,'7cfd61e3-8041-4349-932b-e400f2e92314','photos','IMG-20211206-WA0015','IMG-20211206-WA0015.jpg','image/jpeg','private_media','private_media',164942,'[]','{\"description\":\"Lilith mit Lea\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',12,'2025-07-29 16:41:41','2025-07-29 16:41:41'),
(41,'App\\Models\\User',9,'9904e72c-39d4-4b17-9466-5b2d175207c9','photos','IMG-20211206-WA0014','IMG-20211206-WA0014.jpg','image/jpeg','private_media','private_media',143499,'[]','{\"description\":\"Lea\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',12,'2025-07-29 16:42:06','2025-07-29 16:42:06'),
(42,'App\\Models\\User',9,'1e0114b4-4ac7-43b5-ad04-b165ea3d1d6d','photos','IMG-20211206-WA0017','IMG-20211206-WA0017.jpg','image/jpeg','private_media','private_media',182206,'[]','{\"description\":\"Conny\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',13,'2025-07-29 16:42:23','2025-07-29 16:42:23'),
(43,'App\\Models\\User',9,'6b47518c-1838-4263-b1a9-a0584f628d69','photos','IMG-20211206-WA0016','IMG-20211206-WA0016.jpg','image/jpeg','private_media','private_media',111614,'[]','{\"description\":\"Pl\\u00e4tzchen backen mit Lea\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"Lilith\"}','[]','[]',13,'2025-07-30 04:35:11','2025-07-30 04:35:11'),
(44,'App\\Models\\User',9,'081e75f1-a322-4fcf-90ca-3a6afb1bcf58','photos','IMG-20211206-WA0021','IMG-20211206-WA0021.jpg','image/jpeg','private_media','private_media',217718,'[]','{\"description\":\"Lea ist in der Schaukel eingeschlafen\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":\"Kirchzarten\",\"photographer\":\"Lilith\"}','[]','[]',15,'2025-07-30 04:36:50','2025-07-31 16:12:15'),
(45,'App\\Models\\User',9,'73786378-5d7b-4c3d-be1d-ec6729e1d6db','photos','IMG-20211206-WA0012','IMG-20211206-WA0012.jpg','image/jpeg','private_media','private_media',422286,'[]','{\"description\":\"Conny und Richard\",\"photo_date\":null,\"location\":null,\"photographer\":\"Lilith\",\"ignore_completeness\":false}','[]','[]',11,'2025-07-30 14:28:00','2025-07-30 14:28:00'),
(46,'App\\Models\\User',9,'6319297e-b2b6-4f48-bc78-0405685b7c48','photos','IMG-20211206-WA0019','IMG-20211206-WA0019.jpg','image/jpeg','private_media','private_media',220028,'[]','{\"description\":\"Conny f\\u00e4hrt Lea im Bollerwagen spazieren\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',14,'2025-07-30 14:28:45','2025-07-30 14:28:45'),
(47,'App\\Models\\User',9,'351732a6-6d63-4ed8-8c94-a9de6b6b7938','photos','IMG_20150919_045108','IMG_20150919_045108.jpg','image/jpeg','private_media','private_media',1559514,'[]','{\"description\":\"Unser Zimmer in Sanyas house\",\"photo_date\":null,\"location\":\"Ubud\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',25,'2025-07-30 14:36:12','2025-08-01 18:22:53'),
(48,'App\\Models\\User',9,'a1ae267c-589b-4e62-a38c-33181eb30ffa','photos','IMG-20211206-WA0018','IMG-20211206-WA0018.jpg','image/jpeg','private_media','private_media',235910,'[]','{\"description\":\"Lea\",\"photo_date\":null,\"location\":null,\"photographer\":\"Lilith\",\"ignore_completeness\":false}','[]','[]',14,'2025-07-30 14:55:10','2025-07-30 14:55:10'),
(49,'App\\Models\\User',9,'c2504f7c-ed7c-43f2-9d80-00e7de2a5c48','photos','IMG-20211206-WA0023','IMG-20211206-WA0023.jpg','image/jpeg','private_media','private_media',118082,'[]','{\"description\":\"Lilith und Richard\",\"photo_date\":null,\"location\":null,\"photographer\":\"Selfi\",\"ignore_completeness\":false}','[]','[]',16,'2025-07-30 17:31:23','2025-07-30 17:31:23'),
(50,'App\\Models\\User',9,'057bcab8-e318-464e-9dc8-b49b1669bdaa','photos','IMG-20211206-WA0022','IMG-20211206-WA0022.jpg','image/jpeg','private_media','private_media',124604,'[]','{\"description\":\"Conny\",\"photo_date\":null,\"location\":\"Kirchzarten\",\"photographer\":\"Lilith\",\"ignore_completeness\":false}','[]','[]',17,'2025-07-30 17:57:28','2025-07-30 17:57:28'),
(51,'App\\Models\\User',9,'c93c5e0f-b1f2-495c-a5d0-2493377b09d5','photos','IMG-20211206-WA0025','IMG-20211206-WA0025.jpg','image/jpeg','private_media','private_media',213664,'[]','{\"description\":\"Lilith und Conny\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',18,'2025-07-30 17:58:59','2025-07-30 17:58:59'),
(52,'App\\Models\\User',9,'029d35b2-bda0-4afe-95fa-059cc45519b6','photos','IMG-20211206-WA0024','IMG-20211206-WA0024.jpg','image/jpeg','private_media','private_media',247796,'[]','{\"description\":\"Lilith und Richard beim Fr\\u00fchst\\u00fcck\",\"photo_date\":null,\"location\":null,\"photographer\":\"Lilith\",\"ignore_completeness\":false}','[]','[]',18,'2025-07-30 17:59:42','2025-07-30 17:59:42'),
(53,'App\\Models\\User',9,'5a78a7c4-a085-4e27-af0e-1cee33fdd906','photos','IMG-20211206-WA0026','IMG-20211206-WA0026.jpg','image/jpeg','private_media','private_media',183917,'[]','{\"description\":\"Die ganze Familie im Sandkasten\",\"photo_date\":null,\"location\":null,\"photographer\":null,\"ignore_completeness\":false}','[]','[]',19,'2025-07-30 18:00:35','2025-07-30 18:00:35'),
(54,'App\\Models\\User',9,'4f35b3fd-2f41-40b2-8ed3-39d159ba10fd','photos','IMG-20211206-WA0027','IMG-20211206-WA0027.jpg','image/jpeg','private_media','private_media',248773,'[]','{\"description\":\"Conny will es wissen\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',20,'2025-07-30 18:01:08','2025-07-30 18:01:08'),
(55,'App\\Models\\User',9,'6a302a04-6f17-41ed-a8d8-b89f26ab6fb9','photos','IMG-20211206-WA0029','IMG-20211206-WA0029.jpg','image/jpeg','private_media','private_media',217586,'[]','{\"description\":\"Lea\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',21,'2025-07-30 18:01:33','2025-07-30 18:01:33'),
(56,'App\\Models\\User',9,'91d81bd2-b149-4d15-ac8d-4aa5be131d06','photos','IMG-20211206-WA0028','IMG-20211206-WA0028.jpg','image/jpeg','private_media','private_media',528696,'[]','{\"description\":\"Lea und Conny\",\"photo_date\":null,\"location\":null,\"photographer\":null,\"ignore_completeness\":false}','[]','[]',22,'2025-07-30 18:02:27','2025-07-30 18:02:27'),
(57,'App\\Models\\User',9,'35e950d6-bce5-4aeb-b3b5-994521b43cec','photos','IMG-20211206-WA0030','IMG-20211206-WA0030.jpg','image/jpeg','private_media','private_media',693405,'[]','{\"description\":\"Conny und Cosi\",\"photo_date\":null,\"location\":null,\"photographer\":null,\"ignore_completeness\":false}','[]','[]',23,'2025-07-30 18:02:52','2025-07-30 18:02:52'),
(66,'App\\Models\\User',9,'7b0223a8-de0c-4bf0-8c98-baacedcb2443','photos','IMG_20150919_045146','IMG_20150919_045146.jpg','image/jpeg','private_media','private_media',715178,'[]','{\"description\":\"Ubud - Blick aus dem Fenster\",\"photo_date\":null,\"location\":\"Ubud\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',26,'2025-07-31 06:13:11','2025-07-31 06:13:11'),
(67,'App\\Models\\User',9,'fd921136-7258-48f2-b152-df729185a8b5','photos','IMG_20150919_105453','IMG_20150919_105453.jpg','image/jpeg','private_media','private_media',584785,'[]','{\"description\":\"Ubud Blick aus dem Fenster\",\"photo_date\":null,\"location\":\"Ubud\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',32,'2025-07-31 06:13:45','2025-07-31 06:13:45'),
(68,'App\\Models\\User',9,'fa236639-9783-4103-8636-513df6ef02fb','photos','IMG_20150919_061614','IMG_20150919_061614.jpg','image/jpeg','private_media','private_media',1519367,'[]','{\"description\":\"Restaurant in der N\\u00e4he des Affenzoos\",\"photo_date\":null,\"location\":\"Ubud\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',31,'2025-07-31 06:14:31','2025-07-31 06:14:31'),
(70,'App\\Models\\User',9,'17d357ff-2788-45ff-9d7a-7750689edd54','photos','IMG_20150919_061419','IMG_20150919_061419.jpg','image/jpeg','private_media','private_media',1298221,'[]','{\"description\":\"Restaurant\",\"photo_date\":null,\"location\":\"Ubud\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',28,'2025-08-01 11:17:53','2025-08-01 14:33:05'),
(74,'App\\Models\\User',9,'5068176b-c9ac-482c-b7a4-50efe98b1d8b','photos','IMG-20211206-WA0020','IMG-20211206-WA0020.jpg','image/jpeg','private_media','private_media',266897,'[]','{\"description\":\"Schnuller oder Waffel, das ist die Frage\",\"photo_date\":null,\"ignore_completeness\":false,\"location\":null,\"photographer\":\"ronald\"}','[]','[]',15,'2025-08-01 14:34:37','2025-08-01 14:34:37'),
(91,'App\\Models\\User',9,'dc8984de-b3da-4c1e-a2f5-d258498575f9','photos','DSCF2861','DSCF2861.JPG','image/jpeg','private_media','private_media',3050844,'[]','{\"description\":\"Tombs of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',48,'2025-08-02 05:56:10','2025-08-02 05:56:10'),
(92,'App\\Models\\User',9,'640187cc-1499-4867-b3db-501461071d36','photos','DSCF2860','DSCF2860.JPG','image/jpeg','private_media','private_media',2491471,'[]','{\"description\":\"Toms of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',47,'2025-08-02 05:57:16','2025-08-02 05:57:16'),
(93,'App\\Models\\User',9,'103a202c-0951-45b6-a773-11d5a6361ae1','photos','DSCF2859','DSCF2859.JPG','image/jpeg','private_media','private_media',2955808,'[]','{\"description\":\"Blick von der Villa in Richtung Meer.\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',46,'2025-08-02 05:58:11','2025-08-02 05:58:11'),
(94,'App\\Models\\User',9,'b2c7e2fb-aec5-4eee-9beb-173427f1ca7f','photos','DSCF2858','DSCF2858.JPG','image/jpeg','private_media','private_media',2601578,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',45,'2025-08-02 05:58:44','2025-08-02 05:58:44'),
(95,'App\\Models\\User',9,'92037564-bdd5-4687-a69a-e540a5360c46','photos','20210915_165934','20210915_165934.jpg','image/jpeg','private_media','private_media',4259414,'[]','{\"description\":\"Blick von der Stra\\u00dfe\",\"photo_date\":null,\"location\":\"Peyia\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',49,'2025-08-02 06:01:25','2025-08-05 06:17:21'),
(105,'App\\Models\\User',9,'8e85647b-f041-4716-96fd-daa027318969','photos','DSCF2893','DSCF2893.JPG','image/jpeg','private_media','private_media',2853733,'[]','{\"description\":\"Tombs of the Kings - eines der Gr\\u00e4ber\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',58,'2025-08-02 09:37:27','2025-08-02 09:37:27'),
(106,'App\\Models\\User',9,'afc4f98f-36de-49d1-9ffe-111f2de54756','photos','DSCF2892','DSCF2892.JPG','image/jpeg','private_media','private_media',3003864,'[]','{\"description\":\"Toms of the Kings\\r\\nGrabst\\u00e4tten\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',57,'2025-08-02 09:38:16','2025-08-02 09:38:16'),
(107,'App\\Models\\User',9,'1f1d5554-9c42-450c-abea-f7941c28f107','photos','DSCF2846','DSCF2846.JPG','image/jpeg','private_media','private_media',2586760,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',33,'2025-08-02 09:39:55','2025-08-02 09:39:55'),
(108,'App\\Models\\User',9,'5380c170-ff09-48ca-b50c-8100b6e01df4','photos','DSCF2888','DSCF2888.JPG','image/jpeg','private_media','private_media',2940290,'[]','{\"description\":\"Tombs of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',54,'2025-08-02 09:40:47','2025-08-02 09:40:47'),
(109,'App\\Models\\User',9,'1b63698d-d089-4466-adf6-f4c5d930106a','photos','DSCF2848','DSCF2848.JPG','image/jpeg','private_media','private_media',2907062,'[]','{\"description\":\"Sea caves Paphos\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',35,'2025-08-03 10:28:31','2025-08-03 10:28:31'),
(110,'App\\Models\\User',9,'0e427156-efac-45a1-90a7-57d15315f97d','photos','DSCF2891','DSCF2891.JPG','image/jpeg','private_media','private_media',2883566,'[]','{\"description\":\"Grabkammern in Tombs of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',56,'2025-08-03 10:29:15','2025-08-03 10:30:56'),
(111,'App\\Models\\User',9,'7f4c3866-9209-4117-afbc-60df2104cd53','photos','DSCF2847','DSCF2847.JPG','image/jpeg','private_media','private_media',2775155,'[]','{\"description\":\"Chlorakas\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',34,'2025-08-03 10:31:41','2025-08-03 10:31:41'),
(112,'App\\Models\\User',9,'bf128fdd-6855-4ec7-ae2d-d65a1fa3b2e7','photos','DSCF2856','DSCF2856.JPG','image/jpeg','private_media','private_media',2647999,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',43,'2025-08-03 10:32:04','2025-08-03 10:32:04'),
(113,'App\\Models\\User',9,'4d553c9b-0970-4e42-aaa9-917933970615','photos','DSCF2887','DSCF2887.JPG','image/jpeg','private_media','private_media',3066224,'[]','{\"description\":\"Tombs of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',52,'2025-08-03 10:33:04','2025-08-03 10:33:04'),
(114,'App\\Models\\User',9,'570c3048-67a8-41d9-b112-31c8e27cfd41','photos','DSCF2894','DSCF2894.JPG','image/jpeg','private_media','private_media',3496003,'[]','{\"description\":\"Grabkammer\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',53,'2025-08-03 10:33:31','2025-08-03 10:33:31'),
(115,'App\\Models\\User',9,'0b641038-4c1d-4e23-b592-bfd808353a24','photos','DSCF2886','DSCF2886.JPG','image/jpeg','private_media','private_media',2899726,'[]','{\"description\":\"Steinstapel im Toms of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',51,'2025-08-03 16:13:22','2025-08-03 16:13:22'),
(116,'App\\Models\\User',9,'60563ec9-6a0d-4722-9308-59d48346f45f','photos','DSCF2852','DSCF2852.JPG','image/jpeg','private_media','private_media',2847023,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',40,'2025-08-03 17:49:35','2025-08-03 17:49:35'),
(117,'App\\Models\\User',9,'03f663c8-d7ae-4bb7-80f6-efa21a43e0d4','photos','DSCF2857','DSCF2857.JPG','image/jpeg','private_media','private_media',2617731,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',44,'2025-08-03 17:49:56','2025-08-03 17:49:56'),
(118,'App\\Models\\User',9,'bde826d5-d063-497f-9ed5-432fe9b14537','photos','DSCF2854','DSCF2854.JPG','image/jpeg','private_media','private_media',2632154,'[]','{\"description\":\"Blick von Chlorakas\",\"photo_date\":null,\"location\":\"Chlorakas\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',41,'2025-08-03 17:50:31','2025-08-03 17:50:31'),
(119,'App\\Models\\User',9,'53ab32e3-19ff-4057-90a3-040c59405997','photos','DSCF2855','DSCF2855.JPG','image/jpeg','private_media','private_media',2712660,'[]','{\"description\":\"Chlorakas\",\"photo_date\":null,\"location\":\"Chlorakas\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',42,'2025-08-03 17:51:20','2025-08-03 17:51:20'),
(120,'App\\Models\\User',9,'490b1c51-bef4-4f31-a0b0-1a08a17e1a13','photos','DSCF2853','DSCF2853.JPG','image/jpeg','private_media','private_media',2787371,'[]','{\"description\":\"Chlorakas\",\"photo_date\":null,\"location\":null,\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',39,'2025-08-03 17:51:48','2025-08-03 17:51:48'),
(121,'App\\Models\\User',9,'f0d82cfb-f897-4770-808e-e22f8631dcc0','photos','DSCF2851','DSCF2851.JPG','image/jpeg','private_media','private_media',2771249,'[]','{\"description\":\"Aphrodite\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',37,'2025-08-03 17:52:17','2025-08-03 17:52:17'),
(122,'App\\Models\\User',9,'1fa56719-49fc-4c8a-bde0-21ad16f64236','photos','DSCF2850','DSCF2850.JPG','image/jpeg','private_media','private_media',3093632,'[]','{\"description\":\"Sea Caves\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',38,'2025-08-03 17:52:47','2025-08-03 17:52:47'),
(123,'App\\Models\\User',9,'432be646-755d-4a88-a440-ee548e10c234','photos','DSCF2849','DSCF2849.JPG','image/jpeg','private_media','private_media',2964247,'[]','{\"description\":\"Paphos\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',36,'2025-08-03 17:53:10','2025-08-03 17:53:10'),
(124,'App\\Models\\User',9,'de8ecfab-2a72-456b-91ae-b6e13f4159d2','photos','DSCF2890','DSCF2890.JPG','image/jpeg','private_media','private_media',2919334,'[]','{\"description\":\"eine Grabkammer\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',55,'2025-08-03 18:39:06','2025-08-05 01:49:03'),
(125,'App\\Models\\User',9,'231eb570-39e2-4979-968f-0e60ee6c7a18','photos','DSCF2885','DSCF2885.JPG','image/jpeg','private_media','private_media',2678655,'[]','{\"description\":\"Tombs of the Kings\",\"photo_date\":null,\"location\":\"Paphos\",\"photographer\":\"ronald\",\"ignore_completeness\":false}','[]','[]',50,'2025-08-03 18:42:14','2025-08-03 18:42:14');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_tag`
--

DROP TABLE IF EXISTS `media_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_tag` (
  `media_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`media_id`,`tag_id`),
  KEY `media_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `media_tag_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE,
  CONSTRAINT `media_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_tag`
--

LOCK TABLES `media_tag` WRITE;
/*!40000 ALTER TABLE `media_tag` DISABLE KEYS */;
INSERT INTO `media_tag` VALUES
(31,1),
(31,2),
(31,3),
(32,1),
(36,2),
(36,3),
(57,4),
(57,5),
(57,6),
(57,7),
(113,9),
(113,10),
(113,12);
/*!40000 ALTER TABLE `media_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000001_create_cache_table',1),
(2,'0001_01_01_000002_create_jobs_table',1),
(3,'2024_07_25_100000_create_families_table',1),
(4,'2024_07_25_100001_create_users_table',1),
(6,'2025_07_26_072346_add_requested_family_name_to_users_table',2),
(7,'2025_07_26_211751_create_settings_table',3),
(8,'2025_07_27_114531_create_media_table',4),
(9,'2025_07_30_075007_create_albums_table',5),
(10,'2025_07_30_075255_create_album_media_table',5),
(11,'2025_07_31_080305_create_tags_table',6),
(12,'2025_07_31_080314_create_media_tag_pivot_table',6),
(13,'2025_08_03_132512_create_family_media_pivot_table',7),
(14,'2025_08_07_065653_add_password_reset_fields_to_users_table',8),
(15,'2025_08_07_070512_add_last_seen_to_users_table',8),
(16,'2025_08_07_071540_add_last_seen_to_users_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('zfSLSaZTGPEURjXhXqkD6GIpxVrkIMmOnxZrZVWE',9,'192.168.10.30','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjJOZE9QS0NqRjI5U1ZrV3R4VTlpS1JVVDdNbEV4OGpybGhtY2dPUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9mYW1pbHlwb3J0YWwudGVzdDo4MDgwL21lZGlhLzEwNyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==',1754589105);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'welcome_title','Willkommen im Familienportal','2025-07-26 18:52:39','2025-07-26 18:52:39'),
(2,'welcome_subtitle','Der sichere Ort für deine Erinnerungen, die du mit anderen Teilen möchtest.\r\nDu kannst Bilder oder Texte erstellen/hochladen und damit deine Erfahrungen und Erinnerungen mit anderen Teilen.\r\nDabei bestimmst du selbst, wer von den vertretenen Familien darauf zugreifen darf.\r\nDer \"Leserkreis\" ist jederzeit veränderbar.\r\nAußenstehende haben keinen Zugriff, selbst wenn sie eine Linkadresse bekommen sollten.','2025-07-26 18:52:39','2025-07-27 05:36:43');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES
(1,'Johannes','johannes','2025-07-31 05:24:17','2025-07-31 05:24:17'),
(2,'Lucas','lucas','2025-07-31 05:26:00','2025-07-31 05:26:00'),
(3,'Luciana','luciana','2025-07-31 05:26:00','2025-07-31 05:26:00'),
(4,'Cosima','cosima','2025-07-31 06:15:52','2025-07-31 06:15:52'),
(5,'Cornelius','cornelius','2025-07-31 06:15:52','2025-07-31 06:15:52'),
(6,'Conny','conny','2025-07-31 06:15:52','2025-07-31 06:15:52'),
(7,'Cosi','cosi','2025-07-31 06:15:52','2025-07-31 06:15:52'),
(8,'Tanja','tanja','2025-08-02 05:57:16','2025-08-02 05:57:16'),
(9,'Julia','julia','2025-08-02 05:57:16','2025-08-02 05:57:16'),
(10,'Ty','ty','2025-08-02 05:57:16','2025-08-02 05:57:16'),
(11,'Gaby','gaby','2025-08-02 09:40:47','2025-08-02 09:40:47'),
(12,'Tanya','tanya','2025-08-03 10:33:04','2025-08-03 10:33:04');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `requested_family_name` varchar(255) DEFAULT NULL,
  `family_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `is_family_head` tinyint(1) NOT NULL DEFAULT 0,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_password_reset_token_unique` (`password_reset_token`),
  KEY `users_family_id_foreign` (`family_id`),
  CONSTRAINT `users_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(2,'Admin','admin@wearefamily.cy',NULL,'$2y$12$kugZYONyfyiC42lpK0SGgOMfIDWozTq53i6r9dtY.qj1kFpn.n7ES',NULL,NULL,'active',0,1,NULL,NULL,NULL,'2025-07-25 14:48:12','2025-07-25 14:48:12',NULL),
(9,'ronald','ronald.wernecke@yahoo.com',NULL,'$2y$12$m2B/zKZxzYr9OvH.CiuT9.qulWBEdm13mMb1yyK1Dz0J5IystV9hy',NULL,1,'active',0,0,NULL,NULL,NULL,'2025-07-26 14:58:32','2025-07-26 16:15:56',NULL),
(10,'gaby','gabriele.wernecke@yahoo.com',NULL,'$2y$12$SvWxh.b4tAGlnabNae9jiOx8X.PDc6CavTe9YWwzKgf3vAtbem0IC',NULL,1,'active',0,0,NULL,NULL,NULL,'2025-07-26 14:59:00','2025-07-26 16:16:00',NULL),
(12,'User1','user@wearefamily.cy',NULL,'$2y$12$owXNbKv3NfWiFnXbp4Crg.Sy/zSbtk1TmmDS6cPbOrQ.AJRudlFR.',NULL,2,'active',0,0,NULL,NULL,NULL,'2025-08-02 10:57:19','2025-08-02 10:57:52',NULL),
(13,'Robert','robert@ziegenwirt.de',NULL,'$2y$12$RF2xDmImy2WL5vKLmB9r0ublEGCqEpV5v8rUHLjsE5rnMtXa.bGuK',NULL,3,'active',0,0,NULL,NULL,NULL,'2025-08-03 10:35:33','2025-08-03 10:36:26',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-07 21:25:32
