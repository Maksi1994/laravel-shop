-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: shop_2
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.10.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `basket_product`
--

DROP TABLE IF EXISTS `basket_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basket_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `basket_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `basket_product_basket_id_foreign` (`basket_id`),
  KEY `basket_product_product_id_foreign` (`product_id`),
  CONSTRAINT `basket_product_basket_id_foreign` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `basket_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket_product`
--

LOCK TABLES `basket_product` WRITE;
/*!40000 ALTER TABLE `basket_product` DISABLE KEYS */;
INSERT INTO `basket_product` VALUES (10,27,4,5648,NULL,NULL),(11,27,1,21,NULL,NULL);
/*!40000 ALTER TABLE `basket_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baskets`
--

DROP TABLE IF EXISTS `baskets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baskets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `baskets_customer_id_foreign` (`customer_id`),
  CONSTRAINT `baskets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baskets`
--

LOCK TABLES `baskets` WRITE;
/*!40000 ALTER TABLE `baskets` DISABLE KEYS */;
INSERT INTO `baskets` VALUES (27,11,'2019-01-27 13:20:27','2019-01-27 13:20:27');
/*!40000 ALTER TABLE `baskets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'aaa','2018-11-25 13:21:40','2018-11-25 13:21:40',0),(4,'aaaa','2018-11-25 13:21:57','2019-01-27 15:58:06',2),(18,'ababab','2018-11-25 13:49:02','2018-11-25 13:49:02',2),(19,'trainers','2019-02-02 10:40:28','2019-02-02 10:40:28',2);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `estimate` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_product_id_foreign` (`product_id`),
  CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Another asdtext',11,1,1,'2019-01-13 18:28:55','2019-01-13 20:28:10');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_11_17_121750_create_users_roles_table',1),(4,'2018_11_17_121822_create_products_table',1),(5,'2018_11_17_121957_create_product_categories_table',1),(6,'2018_11_17_140043_devide_user_name',2),(7,'2018_11_29_205322_create_promotions_table',3),(8,'2018_11_29_205352_create_pivot_promotions_table',3),(9,'2018_11_29_220351_remane_product_promotions_table',4),(16,'2018_12_02_133701_create_orders_table',5),(17,'2018_12_02_135208_correction_order_table',5),(18,'2018_12_02_135642_create_product_order_table',5),(19,'2018_12_02_150611_change_order_product_pivot_table',5),(43,'2016_06_01_000001_create_oauth_auth_codes_table',6),(44,'2016_06_01_000002_create_oauth_access_tokens_table',6),(45,'2016_06_01_000003_create_oauth_refresh_tokens_table',6),(46,'2016_06_01_000004_create_oauth_clients_table',6),(47,'2016_06_01_000005_create_oauth_personal_access_clients_table',6),(48,'2018_12_08_202626_create_params_table',6),(49,'2018_12_08_202646_create_params_values_table',6),(50,'2018_12_16_203022_add_price_column',6),(55,'2018_12_21_204207_add_additional_column_to_order_pivot_table',7),(56,'2019_01_05_160309_add_parent_id_column',7),(59,'2019_01_13_161308_add_comments_table',8),(60,'2019_01_13_171835_add_constraints',8),(61,'2019_01_20_170308_basket_table',9),(62,'2019_01_20_170327_basket_product_table',9),(63,'2019_01_28_151329_return_to_default_null',10),(64,'2019_02_03_161849_add_order_products_constraint',11),(65,'2019_02_16_184953_define_product_image_as_nullable',12),(66,'2019_02_17_141359_create_promotions_types_table',13),(67,'2019_02_23_191452_add_user_id_constraint',13),(68,'2019_02_23_203509_add_columns_to_user',14),(69,'2019_02_24_214835_add_promotion_type_for_product',15),(71,'2019_03_10_195147_create_params_product_value_pivot_table',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('22f3a9fc2628de325d2cbdd117da3bf12324b68cbfc1fb2d534fea898dc7bd7dca495e3cc014a694',11,1,'Personal Access Token','[]',0,'2019-01-20 13:47:10','2019-01-20 13:47:10','2019-01-27 15:47:10'),('3d57a525a2e7e5b8ff7c7d361487473c6a43f68d969cd5b4f37448ea8298220706865ce4bf7df8b8',11,1,'Personal Access Token','[]',0,'2019-01-20 13:41:52','2019-01-20 13:41:52','2019-01-27 15:41:52'),('4a0691865acb3768dfe213556bd0fcf3667d79dfe651599de4a743efb8d93628d12a78e5a3e1d4ee',11,1,'Personal Access Token','[]',0,'2019-01-20 13:42:03','2019-01-20 13:42:03','2019-01-27 15:42:03'),('54a7b0ee7f8caa9161bf9b5b747e58cce8768659301eb1fde4e6660834ef58b6fe6e2037a18e7ca9',11,1,'Personal Access Token','[]',0,'2019-01-31 21:13:52','2019-01-31 21:13:52','2019-02-07 23:13:52'),('5dda9b519aa857b13d73fbf40b50ce055948e63fb4c72682e32c599853124aadb878843ce9b6a2c1',11,1,'Personal Access Token','[]',0,'2019-02-02 10:36:56','2019-02-02 10:36:56','2019-02-09 12:36:56'),('62932fc3ba6ec445951e5d2fb6972085d8ebea843eaa688975a9f6991b53b42f6b98a3ae17204035',11,1,'Personal Access Token','[]',0,'2019-01-20 13:41:07','2019-01-20 13:41:07','2019-01-27 15:41:07'),('74152d5c3a010dbd19a95c4e72ad5fbf963e9f2514d904060e2267b30a54e89ad2b0cf9cc9f92385',11,1,'Personal Access Token','[]',0,'2019-01-20 13:38:37','2019-01-20 13:38:37','2019-01-27 15:38:37'),('7d04107c6abe24953235240ec017ac99ee37264c9f667b2c356dc1ed51ff18504907964dbd24ce27',11,1,'Personal Access Token','[]',0,'2019-02-24 16:46:15','2019-02-24 16:46:15','2019-03-03 18:46:15'),('8081931c8594c9530fdb9642f62498100535dcf427f9fc284c7e7a1e20084b6ff6062dba453c9778',11,1,'Personal Access Token','[]',0,'2019-01-20 13:24:50','2019-01-20 13:24:50','2019-01-27 15:24:50'),('85645c193188202a8f65bee09425a907fece31b1a83849ac0a76a236629de3108e1f7f5502be5a70',11,1,'Personal Access Token','[]',0,'2019-01-20 13:45:30','2019-01-20 13:45:30','2019-01-27 15:45:30'),('87c62f6d78fb247e1f1dbb28ff3101a836524ec61b4243b9537c8b53314955f17389ff28f3de2f80',11,1,'Personal Access Token','[]',0,'2019-01-20 13:06:01','2019-01-20 13:06:01','2019-01-27 15:06:01'),('8938ae4259ddddf682cf3eb2a752861610802fe6f30b78fa753fb3f2a45a94c90774ec34253b3674',11,1,'Personal Access Token','[]',0,'2019-02-09 19:38:09','2019-02-09 19:38:09','2019-02-16 21:38:09'),('8a16f2f4e41482a0d54fef6991bc81d0a6ad52fdbb9c599034dd3ddcc76c6b465cf5aba527238c59',11,1,'Personal Access Token','[]',0,'2019-01-13 21:48:37','2019-01-13 21:48:37','2020-01-13 23:48:37'),('8b19006189c424146ff8f103befce91e67e56ebf1500caac5fda8a5cd10dee1b0bd542274aeb098b',11,1,'Personal Access Token','[]',0,'2019-01-20 13:40:41','2019-01-20 13:40:41','2019-01-27 15:40:41'),('8ddba190ce45ba35009593d307314b721957bc8065a6b686ca6292676a7e2f23f710274017c1a3dd',11,1,'Personal Access Token','[]',0,'2019-02-16 16:37:21','2019-02-16 16:37:21','2019-02-23 18:37:22'),('90380170c94f6f2f1c28af1654793d1efd52d9054592a1e1b02959674289b153d625e1ad1df85eb3',11,1,'Personal Access Token','[]',0,'2019-02-14 19:04:56','2019-02-14 19:04:56','2019-02-21 21:04:56'),('97629ab8742454dfd7b6be37d295bc5d4db979845863cc6eb95c8b0ac0cfc57446aff8d9b94d9886',11,1,'Personal Access Token','[]',0,'2019-01-20 13:22:58','2019-01-20 13:22:58','2019-01-27 15:22:58'),('9c4c69354c2c7e9abdba27f0309d75772d87377aa7b35095f2e8571d983c3364e33f8c618705cfab',11,1,'Personal Access Token','[]',0,'2019-03-02 17:09:15','2019-03-02 17:09:15','2019-03-09 19:09:15'),('9d8c7ccb89985a9a942259501e0760b4d7e50bd42c5bc459737798aa9fb29b88c4d224a72d51c557',11,1,'Personal Access Token','[]',0,'2019-01-20 13:17:33','2019-01-20 13:17:33','2019-01-27 15:17:33'),('9e33e6be905901b3181bf8cd964d776ed3eeb3104ad3873653543f0d460bb241a0446de50d7e9941',11,1,'Personal Access Token','[]',0,'2019-01-20 13:40:07','2019-01-20 13:40:07','2019-01-27 15:40:07'),('ae4c180475222a8df73c6bb4f8c1b87eb88900b5d4ea4a3e3a7a07bdf5f1b4b30b360f92e9630f75',11,1,'Personal Access Token','[]',0,'2019-02-16 16:37:22','2019-02-16 16:37:22','2019-02-23 18:37:22'),('bcbafa2b4e489ebc7ac8affe8349fb1180e74794b4a378850318ea067017eb35dafccaaf20d95a33',11,1,'Personal Access Token','[]',0,'2019-01-13 18:28:12','2019-01-13 18:28:12','2020-01-13 20:28:12'),('bd40768ad8682263135cf37ae6510e4ba71810293b848dc1e59902a260f1de55ea32f04a44dbfc97',11,1,'Personal Access Token','[]',0,'2019-01-13 21:48:54','2019-01-13 21:48:54','2020-01-13 23:48:54'),('c13e6d6c57513ed91dd9435a650e6cd693eb89d2cc5f2f24f23c20a73bba3d53e5ad7fea912969b0',11,1,'Personal Access Token','[]',0,'2019-01-20 13:42:35','2019-01-20 13:42:35','2019-01-27 15:42:35'),('c82e124e9d61687f850f620e5254c858e611da615da5625f1016453dbd36e570efa960f163ccdd62',11,1,'Personal Access Token','[]',0,'2019-01-20 13:26:22','2019-01-20 13:26:22','2019-01-27 15:26:22'),('ccb02c0065b2bb9a3e467c3da3eefd9a701df2088924241119c5cfc5ddc2d2c6f8b4483a2278ead2',11,1,'Personal Access Token','[]',0,'2019-01-20 12:34:54','2019-01-20 12:34:54','2019-01-27 14:34:54'),('e251fe9962702391e1411dc268c69527b319745321d44b3203d840158ae9573913c6e8c5751a2629',11,1,'Personal Access Token','[]',0,'2019-01-20 13:45:09','2019-01-20 13:45:09','2019-01-27 15:45:09');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','qcuYn6rUWkM3JOUA4URr67cEk7AJBr1pIfawpdLx','http://localhost',1,0,0,'2019-01-13 18:28:08','2019-01-13 18:28:08'),(2,NULL,'Laravel Password Grant Client','Mi8gXH8uoXy8lTS38RwV5wh0TJP4SKed4fM7hNgP','http://localhost',0,1,0,'2019-01-13 18:28:08','2019-01-13 18:28:08');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2019-01-13 18:28:08','2019-01-13 18:28:08');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_order_id_foreign` (`order_id`),
  CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (1,1,1,2,NULL,NULL,'w-25',10.00),(3,5,1,10,NULL,NULL,'w-25',0.00),(4,6,1,10,NULL,NULL,'w-25',1.00),(6,1,4,15,NULL,NULL,'KKK',100.00);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `city_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,'2018-12-20 19:55:08','2018-12-20 19:55:08'),(3,1,1,'2018-12-20 19:56:23','2018-12-20 19:56:23'),(5,1,1,'2018-12-20 19:57:59','2018-12-20 19:57:59'),(6,1,1,'2018-12-20 19:58:09','2018-12-20 19:58:09'),(7,1,1,'2018-12-21 19:14:34','2018-12-21 19:14:34'),(8,1,1,'2018-12-21 19:14:49','2018-12-21 19:14:49'),(9,1,1,'2018-12-21 19:15:15','2018-12-21 19:15:15'),(10,1,1,'2018-12-21 19:15:48','2018-12-21 19:15:48'),(11,1,1,'2018-12-21 19:16:02','2018-12-21 19:16:02'),(12,1,1,'2018-12-21 19:16:41','2018-12-21 19:16:41'),(13,1,1,'2018-12-21 19:17:04','2018-12-21 19:17:04'),(14,1,1,'2018-12-21 19:18:46','2018-12-21 19:18:46'),(15,1,1,'2018-12-21 19:18:56','2018-12-21 19:18:56'),(16,1,1,'2018-12-21 19:19:39','2018-12-21 19:19:39'),(17,1,1,'2018-12-21 19:20:13','2018-12-21 19:20:13'),(18,1,1,'2018-12-21 19:21:22','2018-12-21 19:21:22'),(19,1,1,'2018-12-21 19:22:29','2018-12-21 19:22:29'),(20,1,1,'2018-12-21 19:22:50','2018-12-21 19:22:50'),(21,1,1,'2018-12-21 19:23:06','2018-12-21 19:23:06'),(22,1,1,'2018-12-21 19:24:06','2018-12-21 19:24:06'),(23,1,1,'2018-12-21 19:25:31','2018-12-21 19:25:31'),(24,1,1,'2018-12-21 19:25:34','2018-12-21 19:25:34'),(25,1,1,'2018-12-21 19:25:53','2018-12-21 19:25:53'),(26,1,1,'2018-12-21 19:26:19','2018-12-21 19:26:19'),(27,1,1,'2018-12-21 19:26:26','2018-12-21 19:26:26'),(28,1,1,'2018-12-21 19:26:34','2018-12-21 19:26:34'),(29,1,1,'2018-12-21 19:28:00','2018-12-21 19:28:00'),(30,1,1,'2018-12-21 19:28:14','2018-12-21 19:28:14'),(31,1,1,'2018-12-21 19:29:01','2018-12-21 19:29:01'),(32,1,1,'2018-12-21 19:29:42','2018-12-21 19:29:42'),(33,1,1,'2018-12-21 19:31:06','2018-12-21 19:31:06'),(34,1,1,'2018-12-21 19:32:10','2018-12-21 19:32:10'),(35,1,1,'2018-12-21 19:32:54','2018-12-21 19:32:54'),(36,1,1,'2018-12-21 19:33:07','2018-12-21 19:33:07'),(37,1,1,'2018-12-21 19:33:20','2018-12-21 19:33:20'),(38,1,1,'2018-12-21 19:35:24','2018-12-21 19:35:24'),(39,1,1,'2018-12-21 19:35:59','2018-12-21 19:35:59'),(40,1,1,'2018-12-21 19:36:22','2018-12-21 19:36:22'),(41,1,1,'2018-12-21 19:37:06','2018-12-21 19:37:06'),(42,1,1,'2018-12-21 19:37:20','2018-12-21 19:37:20'),(43,1,1,'2018-12-21 19:37:25','2018-12-21 19:37:25'),(44,1,1,'2018-12-21 19:37:45','2018-12-21 19:37:45'),(45,1,1,'2018-12-21 19:38:11','2018-12-21 19:38:11'),(46,1,1,'2018-12-21 19:39:36','2018-12-21 19:39:36'),(48,1,1,'2018-12-22 07:47:51','2018-12-22 07:47:51');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param_product_value`
--

DROP TABLE IF EXISTS `param_product_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `param_product_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `param_id` int(10) unsigned NOT NULL,
  `value_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `param_product_value_param_id_foreign` (`param_id`),
  KEY `param_product_value_value_id_foreign` (`value_id`),
  KEY `param_product_value_product_id_foreign` (`product_id`),
  CONSTRAINT `param_product_value_param_id_foreign` FOREIGN KEY (`param_id`) REFERENCES `params` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `param_product_value_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `param_product_value_value_id_foreign` FOREIGN KEY (`value_id`) REFERENCES `values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `param_product_value`
--

LOCK TABLES `param_product_value` WRITE;
/*!40000 ALTER TABLE `param_product_value` DISABLE KEYS */;
INSERT INTO `param_product_value` VALUES (1,1,1,1,NULL,NULL),(2,1,2,1,NULL,NULL);
/*!40000 ALTER TABLE `param_product_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `params`
--

DROP TABLE IF EXISTS `params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `params` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `params_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `params`
--

LOCK TABLES `params` WRITE;
/*!40000 ALTER TABLE `params` DISABLE KEYS */;
INSERT INTO `params` VALUES (1,'clothe_size',NULL,NULL);
/*!40000 ALTER TABLE `params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_promotion`
--

DROP TABLE IF EXISTS `product_promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_promotion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `promotion_type_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_promotion_promotion_type_id_foreign` (`promotion_type_id`),
  CONSTRAINT `product_promotion_promotion_type_id_foreign` FOREIGN KEY (`promotion_type_id`) REFERENCES `promotions_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_promotion`
--

LOCK TABLES `product_promotion` WRITE;
/*!40000 ALTER TABLE `product_promotion` DISABLE KEYS */;
INSERT INTO `product_promotion` VALUES (5,1,1,'9999-12-31',NULL,NULL,1),(6,2,1,'9999-12-31',NULL,NULL,1);
/*!40000 ALTER TABLE `product_promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'222',NULL,2,'2018-11-18 19:33:08','2019-02-02 16:19:29',7.00),(4,'Trainers',NULL,NULL,'2018-11-25 08:33:21','2018-11-25 08:33:21',6.47),(5,'Trainers',NULL,NULL,'2018-11-25 08:33:22','2018-11-25 08:33:22',0.00),(6,'Trainers',NULL,NULL,'2018-11-25 08:33:23','2018-11-25 08:33:23',0.00),(7,'Trainers',NULL,NULL,'2018-11-25 08:33:23','2018-11-25 08:33:23',0.00),(8,'Trainers',NULL,2,'2018-11-25 08:33:24','2019-02-16 16:38:46',200.00),(9,'Trainers',NULL,NULL,'2018-11-25 08:33:24','2018-11-25 08:33:24',0.00),(10,'Trainers',NULL,NULL,'2018-11-25 08:33:25','2018-11-25 08:33:25',0.00),(11,'Trainers',NULL,NULL,'2018-11-25 08:33:25','2018-11-25 08:33:25',0.00),(12,'Trainers',NULL,NULL,'2018-11-25 08:33:26','2018-11-25 08:33:26',0.00),(13,'Trainers',NULL,NULL,'2018-11-25 08:33:26','2018-11-25 08:33:26',0.00),(14,'Trainers',NULL,NULL,'2018-11-25 08:33:27','2018-11-25 08:33:27',0.00),(15,'Trainers',NULL,NULL,'2018-11-25 08:33:27','2018-11-25 08:33:27',0.00),(16,'Trainers',NULL,NULL,'2018-11-25 08:33:28','2018-11-25 08:33:28',0.00),(17,'Trainers',NULL,NULL,'2018-11-25 08:33:28','2018-11-25 08:33:28',0.00),(18,'Trainers',NULL,NULL,'2018-11-25 08:33:29','2018-11-25 08:33:29',0.00),(19,'Trainers',NULL,NULL,'2018-11-25 08:33:29','2018-11-25 08:33:29',0.00),(21,'Trainers',NULL,NULL,'2018-11-25 08:33:30','2018-11-25 08:33:30',0.00),(22,'Trainers',NULL,NULL,'2018-11-25 08:33:31','2018-11-25 08:33:31',0.00),(23,'Trainers',NULL,NULL,'2018-11-25 13:41:25','2018-11-25 13:41:25',0.00),(27,'asd',NULL,18,'2018-12-23 18:03:38','2018-12-23 18:03:38',0.00),(28,'asd',NULL,18,'2018-12-23 18:05:11','2018-12-23 18:05:11',0.00),(29,'asd',NULL,18,'2018-12-23 18:05:29','2018-12-23 18:05:29',0.00),(30,'kkk',NULL,18,'2018-12-23 18:06:44','2018-12-23 18:06:44',0.00),(31,'aaa',NULL,18,'2018-12-23 18:07:41','2018-12-23 18:07:41',0.00),(32,'B BB',NULL,18,'2018-12-23 18:08:18','2018-12-23 20:11:58',0.00),(33,'asd',NULL,18,'2018-12-29 19:13:53','2018-12-29 19:13:53',0.00),(34,'asd',NULL,18,'2018-12-29 19:13:53','2018-12-29 19:13:53',0.00),(37,'aaa',NULL,18,'2018-12-29 19:48:21','2018-12-29 19:48:21',0.00),(38,'aaa',NULL,18,'2018-12-29 19:49:44','2019-02-03 13:50:12',1.00),(39,'aaa',NULL,18,'2018-12-29 19:56:54','2018-12-29 19:56:54',0.00),(40,'aaa',NULL,18,'2018-12-29 19:58:34','2018-12-29 19:58:34',0.00),(41,'aaa',NULL,18,'2018-12-29 19:59:27','2018-12-29 19:59:27',0.00),(42,'fff',NULL,18,'2018-12-29 20:00:12','2018-12-29 20:00:12',0.00),(43,'fff',NULL,18,'2018-12-29 20:01:23','2018-12-29 20:01:23',0.00),(44,'fff',NULL,18,'2018-12-29 20:03:55','2018-12-29 20:03:55',0.00),(45,'fff',NULL,18,'2018-12-29 20:10:35','2018-12-29 20:10:35',0.00),(46,'fff',NULL,18,'2018-12-29 20:12:45','2018-12-29 20:12:45',0.00),(47,'fff',NULL,18,'2018-12-29 20:12:59','2018-12-29 20:12:59',0.00),(49,'aaa2','shop/products/1546127530.jpeg',18,'2018-12-29 21:22:29','2018-12-29 21:52:13',0.00);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promotions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions`
--

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
INSERT INTO `promotions` VALUES (1,'ababab','image.png','2018-11-29 19:52:49','2018-11-29 19:52:49'),(3,'abaasdasdbab','image.png','2018-11-29 19:53:04','2018-11-29 19:53:04');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions_types`
--

DROP TABLE IF EXISTS `promotions_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotions_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promotions_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions_types`
--

LOCK TABLES `promotions_types` WRITE;
/*!40000 ALTER TABLE `promotions_types` DISABLE KEYS */;
INSERT INTO `promotions_types` VALUES (1,'FREE DELIVERY',NULL,NULL);
/*!40000 ALTER TABLE `promotions_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'regular_user',NULL,NULL),(2,'admin',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_blocked` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'mak55755@gmail.com',NULL,'$2y$10$gNHZRbzLyVrf0BRQgP72j.olyvVhhMybTuelAsgh/bstNH/hGEBXK',NULL,NULL,'2018-11-17 13:16:23','2019-02-23 18:48:08','Maxim','Karpinka',0),(2,'mak55755@gmai1l.com',NULL,'$2y$10$g.l3e9LmT44yCqobRoDUwuMoexhM9mcePsnRYRMCXL4cgwYkzicNW',NULL,NULL,'2018-11-17 13:23:49','2018-11-17 13:23:49','Maxim','Karpinka',NULL),(3,'maqwdk55755@gmai1l.com',NULL,'$2y$10$W2Q5QN9tXS2MXtELNOdjLeUBKwkvvAT6EKkJOLOjAGCZ3QmC5egfi',NULL,NULL,'2018-11-17 13:23:56','2018-11-17 13:23:56','Maxim','Karpinka',NULL),(4,'maqdwdk55755@gmai1l.com',NULL,'$2y$10$R0Xjfb/zCPlxbrczTmJgzORiBUrDubIR6mv4BcJvW4Fd8qZqidmKK',NULL,NULL,'2018-11-17 13:26:00','2018-11-17 13:26:00','Madddxim','Karpinka',NULL),(5,'maqdawdk55755@gmai1l.com',NULL,'$2y$10$cCGNa8ZTOJ.uN2LPa9TsxOIKDvdNHZrx110WiZoCwohrKiY3vgeAC',NULL,NULL,'2018-11-17 13:27:02','2019-02-23 18:47:37','Madddxim','Karpinka',0),(6,'maqdasdawdk55755@gmai1l.com',NULL,'$2y$10$ul8PtAxXhAFImw43rhHsge68WBobisJEVL.kmrOXmcsLhGGYamoMu',NULL,NULL,'2018-11-17 13:28:03','2018-11-17 13:28:03','Madddxim','Karpinka',NULL),(7,'nata@gmai1l.com',NULL,'$2y$10$HrVuQRNjqfretA9QcF5sZ.KJeaXarZtYT9mo2/sFlUHrqKwd8xV9a',NULL,NULL,'2018-11-17 13:28:14','2018-11-17 13:28:14','Madddxim','Karpinka',NULL),(9,'nataa@gmai1l.com',NULL,'$2y$10$CkVGigJkxXlJ39aKJKCZeuG7lYadfmWOXpbjEuAwrQa8JgsqI4yym',NULL,NULL,'2018-11-17 13:30:21','2018-11-17 13:30:21','Madddxim','Karpinka',NULL),(10,'nataaa@gmai1l.com',NULL,'$2y$10$LrEZUNy8fnYiLEBVgZh/KuuQSJ5tixZPGd9mgloJLZ6d1O/hKNlGq',NULL,NULL,'2018-11-17 13:31:27','2018-11-17 13:31:27','Madddxim','Karpinka',NULL),(11,'someEmail@gmail.com',NULL,'$2y$10$HgNL73pfNK7Y3qnO1NVUx.aTkzhpDtyI02OXgkHFKNrqpF86tjA1a',2,NULL,'2019-01-12 18:26:38','2019-01-12 18:26:38','Maxim','Karpinka',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `values`
--

DROP TABLE IF EXISTS `values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `param_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `values`
--

LOCK TABLES `values` WRITE;
/*!40000 ALTER TABLE `values` DISABLE KEYS */;
INSERT INTO `values` VALUES (1,'s',1,NULL,NULL),(2,'l',1,NULL,NULL),(3,'m',1,NULL,NULL),(4,'xl',1,NULL,NULL);
/*!40000 ALTER TABLE `values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'shop_2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-16 18:47:13
