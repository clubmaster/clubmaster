-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: clubmaster_v2
-- ------------------------------------------------------
-- Server version	5.1.49-3-log

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
-- Table structure for table `club_account_account`
--

DROP TABLE IF EXISTS `club_account_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_account_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_account_account`
--

LOCK TABLES `club_account_account` WRITE;
/*!40000 ALTER TABLE `club_account_account` DISABLE KEYS */;
INSERT INTO `club_account_account` VALUES (1,'Cash In Bash','1010','asset'),(2,'VAT','3001','income'),(3,'Income','5001','income');
/*!40000 ALTER TABLE `club_account_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_account_ledger`
--

DROP TABLE IF EXISTS `club_account_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_account_ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2BFEDA1C9B6B5FBA` (`account_id`),
  KEY `IDX_2BFEDA1CA76ED395` (`user_id`),
  CONSTRAINT `club_account_ledger_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`),
  CONSTRAINT `club_account_ledger_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `club_account_account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_account_ledger`
--

LOCK TABLES `club_account_ledger` WRITE;
/*!40000 ALTER TABLE `club_account_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_account_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_event_attend`
--

DROP TABLE IF EXISTS `club_event_attend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_event_attend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DF53999A76ED395` (`user_id`),
  KEY `IDX_2DF5399971F7E88B` (`event_id`),
  CONSTRAINT `club_event_attend_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `club_event_event` (`id`),
  CONSTRAINT `club_event_attend_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_event_attend`
--

LOCK TABLES `club_event_attend` WRITE;
/*!40000 ALTER TABLE `club_event_attend` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_event_attend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_event_event`
--

DROP TABLE IF EXISTS `club_event_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_event_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `max_attends` int(11) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `stop_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_event_event`
--

LOCK TABLES `club_event_event` WRITE;
/*!40000 ALTER TABLE `club_event_event` DISABLE KEYS */;
INSERT INTO `club_event_event` VALUES (1,'Tournament','Senior Tournament',NULL,NULL,'2011-06-23 10:00:00','2011-06-23 19:00:00','2011-06-28 18:41:36','2011-06-28 18:41:36'),(2,'BBQ party','BBQ Party',NULL,NULL,'2011-07-03 19:00:00','2011-07-03 23:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37'),(3,'Junior Tournament','Junior Tournament',NULL,NULL,'2011-07-13 12:00:00','2011-07-13 17:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37');
/*!40000 ALTER TABLE `club_event_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_group_location`
--

DROP TABLE IF EXISTS `club_group_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_group_location` (
  `group_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`location_id`),
  KEY `IDX_9B1F7567FE54D947` (`group_id`),
  KEY `IDX_9B1F756764D218E` (`location_id`),
  CONSTRAINT `club_group_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_group_location_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_group_location`
--

LOCK TABLES `club_group_location` WRITE;
/*!40000 ALTER TABLE `club_group_location` DISABLE KEYS */;
INSERT INTO `club_group_location` VALUES (4,1);
/*!40000 ALTER TABLE `club_group_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_log_log`
--

DROP TABLE IF EXISTS `club_log_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_log_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `event` varchar(255) NOT NULL,
  `log` longtext NOT NULL,
  `log_type` varchar(255) NOT NULL,
  `severity` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ED92E49CA76ED395` (`user_id`),
  CONSTRAINT `club_log_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_log_log`
--

LOCK TABLES `club_log_log` WRITE;
/*!40000 ALTER TABLE `club_log_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_log_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_mail`
--

DROP TABLE IF EXISTS `club_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_mail`
--

LOCK TABLES `club_mail` WRITE;
/*!40000 ALTER TABLE `club_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_mail_attachment`
--

DROP TABLE IF EXISTS `club_mail_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_mail_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B28A0199C8776F01` (`mail_id`),
  CONSTRAINT `club_mail_attachment_ibfk_1` FOREIGN KEY (`mail_id`) REFERENCES `club_mail` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_mail_attachment`
--

LOCK TABLES `club_mail_attachment` WRITE;
/*!40000 ALTER TABLE `club_mail_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_mail_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_mail_queue`
--

DROP TABLE IF EXISTS `club_mail_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_mail_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `error_message` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_mail_queue`
--

LOCK TABLES `club_mail_queue` WRITE;
/*!40000 ALTER TABLE `club_mail_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_mail_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_attribute`
--

DROP TABLE IF EXISTS `club_shop_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_attribute`
--

LOCK TABLES `club_shop_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_attribute` DISABLE KEYS */;
INSERT INTO `club_shop_attribute` VALUES (1,'Month'),(2,'Ticket'),(3,'AutoRenewal'),(4,'Lifetime'),(5,'StartDate'),(6,'ExpireData'),(7,'AllowedPauses'),(8,'Location');
/*!40000 ALTER TABLE `club_shop_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_cart`
--

DROP TABLE IF EXISTS `club_shop_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_address_id` int(11) DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `billing_address_id` int(11) DEFAULT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_value` decimal(10,0) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vat_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6558CE2A4887F3F8` (`shipping_id`),
  KEY `IDX_6558CE2A64D218E` (`location_id`),
  KEY `IDX_6558CE2A5AA1164F` (`payment_method_id`),
  KEY `IDX_6558CE2AA76ED395` (`user_id`),
  KEY `IDX_6558CE2A87EABF7` (`customer_address_id`),
  KEY `IDX_6558CE2A4D4CFF2B` (`shipping_address_id`),
  KEY `IDX_6558CE2A79D0C0E4` (`billing_address_id`),
  CONSTRAINT `club_shop_cart_ibfk_7` FOREIGN KEY (`billing_address_id`) REFERENCES `club_shop_cart_address` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_1` FOREIGN KEY (`shipping_id`) REFERENCES `club_shop_shipping` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_3` FOREIGN KEY (`payment_method_id`) REFERENCES `club_shop_payment_method` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_5` FOREIGN KEY (`customer_address_id`) REFERENCES `club_shop_cart_address` (`id`),
  CONSTRAINT `club_shop_cart_ibfk_6` FOREIGN KEY (`shipping_address_id`) REFERENCES `club_shop_cart_address` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_cart`
--

LOCK TABLES `club_shop_cart` WRITE;
/*!40000 ALTER TABLE `club_shop_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_cart_address`
--

DROP TABLE IF EXISTS `club_shop_cart_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_cart_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `cvr` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `suburl` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_cart_address`
--

LOCK TABLES `club_shop_cart_address` WRITE;
/*!40000 ALTER TABLE `club_shop_cart_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_cart_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_cart_product`
--

DROP TABLE IF EXISTS `club_shop_cart_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_cart_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `vat` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2990D3F4584665A` (`product_id`),
  KEY `IDX_E2990D3F1AD5CDBF` (`cart_id`),
  CONSTRAINT `club_shop_cart_product_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `club_shop_cart` (`id`) ON DELETE CASCADE,
  CONSTRAINT `club_shop_cart_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_cart_product`
--

LOCK TABLES `club_shop_cart_product` WRITE;
/*!40000 ALTER TABLE `club_shop_cart_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_cart_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_cart_product_attribute`
--

DROP TABLE IF EXISTS `club_shop_cart_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_cart_product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_product_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7BA168E025EE16A8` (`cart_product_id`),
  CONSTRAINT `club_shop_cart_product_attribute_ibfk_1` FOREIGN KEY (`cart_product_id`) REFERENCES `club_shop_cart_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_cart_product_attribute`
--

LOCK TABLES `club_shop_cart_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_cart_product_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_cart_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_category`
--

DROP TABLE IF EXISTS `club_shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6033A5E33DA5256D` (`image_id`),
  KEY `IDX_6033A5E312469DE2` (`category_id`),
  KEY `IDX_6033A5E364D218E` (`location_id`),
  CONSTRAINT `club_shop_category_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_shop_category_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `club_shop_image` (`id`),
  CONSTRAINT `club_shop_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `club_shop_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_category`
--

LOCK TABLES `club_shop_category` WRITE;
/*!40000 ALTER TABLE `club_shop_category` DISABLE KEYS */;
INSERT INTO `club_shop_category` VALUES (1,NULL,NULL,1,'Subscriptions','Subscriptions'),(2,NULL,NULL,1,'Ticket coupon','Ticket coupon'),(3,NULL,NULL,1,'Food','Food'),(4,NULL,NULL,1,'Liquid','Liquid'),(5,NULL,NULL,1,'Sport equipment','Sport equipment'),(6,NULL,NULL,1,'Other','Other'),(7,NULL,5,1,'Bags','Bags'),(8,NULL,5,1,'Rackets','Rackets');
/*!40000 ALTER TABLE `club_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_category_product`
--

DROP TABLE IF EXISTS `club_shop_category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_category_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `IDX_A41239D54584665A` (`product_id`),
  KEY `IDX_A41239D512469DE2` (`category_id`),
  CONSTRAINT `club_shop_category_product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `club_shop_category` (`id`),
  CONSTRAINT `club_shop_category_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_category_product`
--

LOCK TABLES `club_shop_category_product` WRITE;
/*!40000 ALTER TABLE `club_shop_category_product` DISABLE KEYS */;
INSERT INTO `club_shop_category_product` VALUES (1,1),(2,1),(3,1),(4,1),(5,2),(6,2),(7,5),(8,6),(9,1);
/*!40000 ALTER TABLE `club_shop_category_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_image`
--

DROP TABLE IF EXISTS `club_shop_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_image`
--

LOCK TABLES `club_shop_image` WRITE;
/*!40000 ALTER TABLE `club_shop_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order`
--

DROP TABLE IF EXISTS `club_shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_id` int(11) DEFAULT NULL,
  `shipping_id` int(11) DEFAULT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_address_id` int(11) DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `billing_address_id` int(11) DEFAULT NULL,
  `order_memo` varchar(255) DEFAULT NULL,
  `note` longtext,
  `currency` varchar(255) NOT NULL,
  `currency_value` decimal(10,0) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vat_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7BF987275AA1164F` (`payment_method_id`),
  KEY `IDX_7BF987274887F3F8` (`shipping_id`),
  KEY `IDX_7BF98727D7707B45` (`order_status_id`),
  KEY `IDX_7BF98727A76ED395` (`user_id`),
  KEY `IDX_7BF9872787EABF7` (`customer_address_id`),
  KEY `IDX_7BF987274D4CFF2B` (`shipping_address_id`),
  KEY `IDX_7BF9872779D0C0E4` (`billing_address_id`),
  CONSTRAINT `club_shop_order_ibfk_7` FOREIGN KEY (`billing_address_id`) REFERENCES `club_shop_order_address` (`id`),
  CONSTRAINT `club_shop_order_ibfk_1` FOREIGN KEY (`payment_method_id`) REFERENCES `club_shop_payment_method` (`id`),
  CONSTRAINT `club_shop_order_ibfk_2` FOREIGN KEY (`shipping_id`) REFERENCES `club_shop_shipping` (`id`),
  CONSTRAINT `club_shop_order_ibfk_3` FOREIGN KEY (`order_status_id`) REFERENCES `club_shop_order_status` (`id`),
  CONSTRAINT `club_shop_order_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`),
  CONSTRAINT `club_shop_order_ibfk_5` FOREIGN KEY (`customer_address_id`) REFERENCES `club_shop_order_address` (`id`),
  CONSTRAINT `club_shop_order_ibfk_6` FOREIGN KEY (`shipping_address_id`) REFERENCES `club_shop_order_address` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order`
--

LOCK TABLES `club_shop_order` WRITE;
/*!40000 ALTER TABLE `club_shop_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_address`
--

DROP TABLE IF EXISTS `club_shop_order_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `cvr` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `suburl` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7B9BA8C08D9F6D38` (`order_id`),
  CONSTRAINT `club_shop_order_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `club_shop_order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_address`
--

LOCK TABLES `club_shop_order_address` WRITE;
/*!40000 ALTER TABLE `club_shop_order_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_product`
--

DROP TABLE IF EXISTS `club_shop_order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `vat` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A59FC3EC4584665A` (`product_id`),
  KEY `IDX_A59FC3EC8D9F6D38` (`order_id`),
  CONSTRAINT `club_shop_order_product_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `club_shop_order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `club_shop_order_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_product`
--

LOCK TABLES `club_shop_order_product` WRITE;
/*!40000 ALTER TABLE `club_shop_order_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_product_attribute`
--

DROP TABLE IF EXISTS `club_shop_order_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_product_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F841C600F65E9B0F` (`order_product_id`),
  CONSTRAINT `club_shop_order_product_attribute_ibfk_1` FOREIGN KEY (`order_product_id`) REFERENCES `club_shop_order_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_product_attribute`
--

LOCK TABLES `club_shop_order_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_order_product_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_product_variant`
--

DROP TABLE IF EXISTS `club_shop_order_product_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_product_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_product_id` int(11) DEFAULT NULL,
  `variant` varchar(255) NOT NULL,
  `variant_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F8765F98F65E9B0F` (`order_product_id`),
  CONSTRAINT `club_shop_order_product_variant_ibfk_1` FOREIGN KEY (`order_product_id`) REFERENCES `club_shop_order_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_product_variant`
--

LOCK TABLES `club_shop_order_product_variant` WRITE;
/*!40000 ALTER TABLE `club_shop_order_product_variant` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order_product_variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_status`
--

DROP TABLE IF EXISTS `club_shop_order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  `is_cancelled` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_status`
--

LOCK TABLES `club_shop_order_status` WRITE;
/*!40000 ALTER TABLE `club_shop_order_status` DISABLE KEYS */;
INSERT INTO `club_shop_order_status` VALUES (1,'Pending',0,0,0),(2,'Processing',0,0,0),(3,'Preparing',0,0,0),(4,'Delivered',1,0,0),(5,'Cancelled',0,1,0);
/*!40000 ALTER TABLE `club_shop_order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_order_status_history`
--

DROP TABLE IF EXISTS `club_shop_order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_order_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CEBA5866D7707B45` (`order_status_id`),
  KEY `IDX_CEBA58668D9F6D38` (`order_id`),
  CONSTRAINT `club_shop_order_status_history_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `club_shop_order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `club_shop_order_status_history_ibfk_1` FOREIGN KEY (`order_status_id`) REFERENCES `club_shop_order_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_order_status_history`
--

LOCK TABLES `club_shop_order_status_history` WRITE;
/*!40000 ALTER TABLE `club_shop_order_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_order_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_payment_method`
--

DROP TABLE IF EXISTS `club_shop_payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(255) NOT NULL,
  `page` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_payment_method`
--

LOCK TABLES `club_shop_payment_method` WRITE;
/*!40000 ALTER TABLE `club_shop_payment_method` DISABLE KEYS */;
INSERT INTO `club_shop_payment_method` VALUES (1,'Cash','<h2>Thank you</h2><p>Your order has been successful completed.</p><p>We will complete your order as soon as we receive the payment.</p>');
/*!40000 ALTER TABLE `club_shop_payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_product`
--

DROP TABLE IF EXISTS `club_shop_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vat_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AACDEC77B5B63A6B` (`vat_id`),
  CONSTRAINT `club_shop_product_ibfk_1` FOREIGN KEY (`vat_id`) REFERENCES `club_shop_vat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_product`
--

LOCK TABLES `club_shop_product` WRITE;
/*!40000 ALTER TABLE `club_shop_product` DISABLE KEYS */;
INSERT INTO `club_shop_product` VALUES (1,1,'1. md, subscription','1. md, subscription','100.00',NULL),(2,1,'2. md, subscription','2. md, subscription','175.00',NULL),(3,1,'Period subscription','Period subscription','1000.00',NULL),(4,1,'Lifetime membership','Lifetime membership','5000.00',NULL),(5,1,'10 clip','10 clip','100.00',NULL),(6,1,'20 clip','20 clip','175.00',NULL),(7,1,'Tennis Balls','Tennis Balls','50.00',NULL),(8,1,'Club T-shirt','Club T-shirt','200.00',NULL),(9,1,'Easter subscription','Easter subscription','50.00',NULL);
/*!40000 ALTER TABLE `club_shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_product_attribute`
--

DROP TABLE IF EXISTS `club_shop_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7D097C3E4584665A` (`product_id`),
  KEY `IDX_7D097C3EB6E62EFA` (`attribute_id`),
  CONSTRAINT `club_shop_product_attribute_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `club_shop_attribute` (`id`),
  CONSTRAINT `club_shop_product_attribute_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_product_attribute`
--

LOCK TABLES `club_shop_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_product_attribute` DISABLE KEYS */;
INSERT INTO `club_shop_product_attribute` VALUES (1,1,1,'1'),(2,1,7,'3'),(3,1,8,'1'),(4,1,5,'2011-06-01'),(5,2,1,'2'),(6,2,7,'5'),(7,2,8,'1'),(8,3,5,'2011-04-01'),(9,3,6,'2011-10-31'),(10,4,4,'1'),(11,5,2,'10'),(12,5,8,'1'),(13,6,2,'20'),(14,6,8,'1'),(15,9,5,'2011-04-16'),(16,9,6,'2011-04-30');
/*!40000 ALTER TABLE `club_shop_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_shipping`
--

DROP TABLE IF EXISTS `club_shop_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_shipping`
--

LOCK TABLES `club_shop_shipping` WRITE;
/*!40000 ALTER TABLE `club_shop_shipping` DISABLE KEYS */;
INSERT INTO `club_shop_shipping` VALUES (1,'Free shipping','Free shipping','0.00');
/*!40000 ALTER TABLE `club_shop_shipping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_special`
--

DROP TABLE IF EXISTS `club_shop_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_special` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_35ECD7394584665A` (`product_id`),
  CONSTRAINT `club_shop_special_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_special`
--

LOCK TABLES `club_shop_special` WRITE;
/*!40000 ALTER TABLE `club_shop_special` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_special` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_subscription`
--

DROP TABLE IF EXISTS `club_shop_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_69CFA5468D9F6D38` (`order_id`),
  KEY `IDX_69CFA546A76ED395` (`user_id`),
  CONSTRAINT `club_shop_subscription_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`),
  CONSTRAINT `club_shop_subscription_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `club_shop_order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_subscription`
--

LOCK TABLES `club_shop_subscription` WRITE;
/*!40000 ALTER TABLE `club_shop_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_subscription_attribute`
--

DROP TABLE IF EXISTS `club_shop_subscription_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_subscription_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_idx` (`subscription_id`,`attribute_name`),
  KEY `IDX_37D9A20F9A1887DC` (`subscription_id`),
  CONSTRAINT `club_shop_subscription_attribute_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `club_shop_subscription` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_subscription_attribute`
--

LOCK TABLES `club_shop_subscription_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_subscription_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_subscription_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_subscription_location`
--

DROP TABLE IF EXISTS `club_shop_subscription_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_subscription_location` (
  `subscription_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`subscription_id`,`location_id`),
  KEY `IDX_2AD5EE3E9A1887DC` (`subscription_id`),
  KEY `IDX_2AD5EE3E64D218E` (`location_id`),
  CONSTRAINT `club_shop_subscription_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`) ON DELETE CASCADE,
  CONSTRAINT `club_shop_subscription_location_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `club_shop_subscription` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_subscription_location`
--

LOCK TABLES `club_shop_subscription_location` WRITE;
/*!40000 ALTER TABLE `club_shop_subscription_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_subscription_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_subscription_pause`
--

DROP TABLE IF EXISTS `club_shop_subscription_pause`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_subscription_pause` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_554C89199A1887DC` (`subscription_id`),
  CONSTRAINT `club_shop_subscription_pause_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `club_shop_subscription` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_subscription_pause`
--

LOCK TABLES `club_shop_subscription_pause` WRITE;
/*!40000 ALTER TABLE `club_shop_subscription_pause` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_subscription_pause` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_transaction`
--

DROP TABLE IF EXISTS `club_shop_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_status_id` int(11) DEFAULT NULL,
  `transaction_code` varchar(255) NOT NULL,
  `transaction_return_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C1341A2028D09BFE` (`transaction_status_id`),
  CONSTRAINT `club_shop_transaction_ibfk_1` FOREIGN KEY (`transaction_status_id`) REFERENCES `club_shop_transaction_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_transaction`
--

LOCK TABLES `club_shop_transaction` WRITE;
/*!40000 ALTER TABLE `club_shop_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_transaction_status`
--

DROP TABLE IF EXISTS `club_shop_transaction_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_transaction_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_transaction_status`
--

LOCK TABLES `club_shop_transaction_status` WRITE;
/*!40000 ALTER TABLE `club_shop_transaction_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_shop_transaction_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_variant_group`
--

DROP TABLE IF EXISTS `club_shop_variant_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_variant_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variant_group_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_variant_group`
--

LOCK TABLES `club_shop_variant_group` WRITE;
/*!40000 ALTER TABLE `club_shop_variant_group` DISABLE KEYS */;
INSERT INTO `club_shop_variant_group` VALUES (1,'Color'),(2,'Size');
/*!40000 ALTER TABLE `club_shop_variant_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_variant_value`
--

DROP TABLE IF EXISTS `club_shop_variant_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_variant_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variant_group_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D52A963618498CF` (`variant_group_id`),
  CONSTRAINT `club_shop_variant_value_ibfk_1` FOREIGN KEY (`variant_group_id`) REFERENCES `club_shop_variant_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_variant_value`
--

LOCK TABLES `club_shop_variant_value` WRITE;
/*!40000 ALTER TABLE `club_shop_variant_value` DISABLE KEYS */;
INSERT INTO `club_shop_variant_value` VALUES (1,1,'Green'),(2,1,'Orange'),(3,1,'Yellow'),(4,2,'Small'),(5,2,'Medium'),(6,2,'Large'),(7,2,'XLarge');
/*!40000 ALTER TABLE `club_shop_variant_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_shop_vat`
--

DROP TABLE IF EXISTS `club_shop_vat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_shop_vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vat_name` varchar(255) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_vat`
--

LOCK TABLES `club_shop_vat` WRITE;
/*!40000 ALTER TABLE `club_shop_vat` DISABLE KEYS */;
INSERT INTO `club_shop_vat` VALUES (1,'Tax free','0');
/*!40000 ALTER TABLE `club_shop_vat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_task_task`
--

DROP TABLE IF EXISTS `club_task_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_task_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `event` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_run_at` datetime DEFAULT NULL,
  `next_run_at` datetime NOT NULL,
  `task_interval` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_task_task`
--

LOCK TABLES `club_task_task` WRITE;
/*!40000 ALTER TABLE `club_task_task` DISABLE KEYS */;
INSERT INTO `club_task_task` VALUES (1,'Update dynamic groups',1,0,'onGroupTask','2011-06-28 18:41:17','2011-06-28 18:41:28','2011-06-28 18:41:28','2011-06-28 19:41:28','+1 hour'),(2,'Cleanup logs',1,0,'onLogTask','2011-06-28 18:41:17','2011-06-28 18:41:28','2011-06-28 18:41:28','2011-06-28 19:41:28','+1 hour'),(3,'Renewal memberships',1,0,'onAutoRenewalTask','2011-06-28 18:41:17','2011-06-28 18:41:28','2011-06-28 18:41:28','2011-06-28 19:41:28','+1 hour'),(4,'Cleanup login logs',1,0,'onLoginAttemptTask','2011-06-28 18:41:17','2011-06-28 18:41:28','2011-06-28 18:41:28','2011-06-28 19:41:28','+1 hour');
/*!40000 ALTER TABLE `club_task_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_attribute`
--

DROP TABLE IF EXISTS `club_user_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_attribute`
--

LOCK TABLES `club_user_attribute` WRITE;
/*!40000 ALTER TABLE `club_user_attribute` DISABLE KEYS */;
INSERT INTO `club_user_attribute` VALUES (1,'min_age'),(2,'max_age'),(3,'gender'),(4,'postal_code'),(5,'city'),(6,'country'),(7,'is_active'),(8,'has_ticket'),(9,'has_subscription'),(10,'location');
/*!40000 ALTER TABLE `club_user_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_ban`
--

DROP TABLE IF EXISTS `club_user_ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  `note` longtext,
  PRIMARY KEY (`id`),
  KEY `IDX_8A531BC7A76ED395` (`user_id`),
  CONSTRAINT `club_user_ban_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_ban`
--

LOCK TABLES `club_user_ban` WRITE;
/*!40000 ALTER TABLE `club_user_ban` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_ban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_config`
--

DROP TABLE IF EXISTS `club_user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6F2A6CCA95D1CAA6` (`config_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_config`
--

LOCK TABLES `club_user_config` WRITE;
/*!40000 ALTER TABLE `club_user_config` DISABLE KEYS */;
INSERT INTO `club_user_config` VALUES (5,'account_default_income'),(6,'account_default_vat'),(7,'default_language'),(1,'smtp_host'),(4,'smtp_password'),(2,'smtp_port'),(3,'smtp_username');
/*!40000 ALTER TABLE `club_user_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_country`
--

DROP TABLE IF EXISTS `club_user_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_country`
--

LOCK TABLES `club_user_country` WRITE;
/*!40000 ALTER TABLE `club_user_country` DISABLE KEYS */;
INSERT INTO `club_user_country` VALUES (1,'Denmark'),(2,'Sweden'),(3,'Norway'),(4,'Germany'),(5,'Finland');
/*!40000 ALTER TABLE `club_user_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_currency`
--

DROP TABLE IF EXISTS `club_user_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol_left` varchar(255) DEFAULT NULL,
  `symbol_right` varchar(255) DEFAULT NULL,
  `decimal_places` varchar(255) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_currency`
--

LOCK TABLES `club_user_currency` WRITE;
/*!40000 ALTER TABLE `club_user_currency` DISABLE KEYS */;
INSERT INTO `club_user_currency` VALUES (1,'Danish Krone','DKK',NULL,'DK','2','1');
/*!40000 ALTER TABLE `club_user_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_filter`
--

DROP TABLE IF EXISTS `club_user_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `filter_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4641CABA76ED395` (`user_id`),
  CONSTRAINT `club_user_filter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_filter`
--

LOCK TABLES `club_user_filter` WRITE;
/*!40000 ALTER TABLE `club_user_filter` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_filter_attribute`
--

DROP TABLE IF EXISTS `club_user_filter_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_filter_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C0591B7CB6E62EFA` (`attribute_id`),
  KEY `IDX_C0591B7CD395B25E` (`filter_id`),
  CONSTRAINT `club_user_filter_attribute_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `club_user_filter` (`id`),
  CONSTRAINT `club_user_filter_attribute_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `club_user_attribute` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_filter_attribute`
--

LOCK TABLES `club_user_filter_attribute` WRITE;
/*!40000 ALTER TABLE `club_user_filter_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_filter_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_forgot_password`
--

DROP TABLE IF EXISTS `club_user_forgot_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_forgot_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8173F9A7A76ED395` (`user_id`),
  CONSTRAINT `club_user_forgot_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_forgot_password`
--

LOCK TABLES `club_user_forgot_password` WRITE;
/*!40000 ALTER TABLE `club_user_forgot_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_forgot_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_group`
--

DROP TABLE IF EXISTS `club_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_type` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `min_age` int(11) DEFAULT NULL,
  `max_age` int(11) DEFAULT NULL,
  `is_active_member` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C6C4F170FE54D947` (`group_id`),
  CONSTRAINT `club_user_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_group`
--

LOCK TABLES `club_user_group` WRITE;
/*!40000 ALTER TABLE `club_user_group` DISABLE KEYS */;
INSERT INTO `club_user_group` VALUES (1,NULL,'Senior','dynamic',NULL,18,45,1),(2,NULL,'Junior','dynamic',NULL,0,17,1),(3,NULL,'Members of honor','static',NULL,NULL,NULL,1),(4,NULL,'DK - Members','dynamic',NULL,NULL,NULL,1),(5,NULL,'All Members','dynamic',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `club_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_language`
--

DROP TABLE IF EXISTS `club_user_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_language`
--

LOCK TABLES `club_user_language` WRITE;
/*!40000 ALTER TABLE `club_user_language` DISABLE KEYS */;
INSERT INTO `club_user_language` VALUES (1,'English','en_UK'),(2,'Danish','da_DK');
/*!40000 ALTER TABLE `club_user_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_location`
--

DROP TABLE IF EXISTS `club_user_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `location_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3D42B7F64D218E` (`location_id`),
  KEY `IDX_3D42B7F38248176` (`currency_id`),
  CONSTRAINT `club_user_location_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `club_user_currency` (`id`),
  CONSTRAINT `club_user_location_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_location`
--

LOCK TABLES `club_user_location` WRITE;
/*!40000 ALTER TABLE `club_user_location` DISABLE KEYS */;
INSERT INTO `club_user_location` VALUES (1,NULL,1,'Denmark'),(2,1,1,'Aalborg'),(3,1,1,'Copenhagen'),(4,2,1,'Aalborg Tennis Club'),(5,2,1,'Gug Tennis Club');
/*!40000 ALTER TABLE `club_user_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_location_config`
--

DROP TABLE IF EXISTS `club_user_location_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_location_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3432EBBF24DB0683` (`config_id`),
  KEY `IDX_3432EBBF64D218E` (`location_id`),
  CONSTRAINT `club_user_location_config_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_user_location_config_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `club_user_config` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_location_config`
--

LOCK TABLES `club_user_location_config` WRITE;
/*!40000 ALTER TABLE `club_user_location_config` DISABLE KEYS */;
INSERT INTO `club_user_location_config` VALUES (1,1,1,'localhost'),(2,1,2,'localhost'),(3,1,3,'localhost'),(4,1,4,'localhost'),(5,1,5,'localhost'),(6,2,1,'25'),(7,2,2,'25'),(8,2,3,'25'),(9,2,4,'25'),(10,2,5,'25'),(11,3,1,NULL),(12,3,2,NULL),(13,3,3,NULL),(14,3,4,NULL),(15,3,5,NULL),(16,4,1,NULL),(17,4,2,NULL),(18,4,3,NULL),(19,4,4,NULL),(20,4,5,NULL),(21,5,1,'5001'),(22,5,2,'5001'),(23,5,3,'5001'),(24,5,4,'5001'),(25,5,5,'5001'),(26,6,1,'3001'),(27,6,2,'3001'),(28,6,3,'3001'),(29,6,4,'3001'),(30,6,5,'3001'),(31,7,1,'en_UK'),(32,7,2,'en_UK'),(33,7,3,'en_UK'),(34,7,4,'en_UK'),(35,7,5,'en_UK');
/*!40000 ALTER TABLE `club_user_location_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_login_attempt`
--

DROP TABLE IF EXISTS `club_user_login_attempt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_login_attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `login_failed` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_login_attempt`
--

LOCK TABLES `club_user_login_attempt` WRITE;
/*!40000 ALTER TABLE `club_user_login_attempt` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_login_attempt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_profile`
--

DROP TABLE IF EXISTS `club_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `day_of_birth` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A3EE1CF5A76ED395` (`user_id`),
  CONSTRAINT `club_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile`
--

LOCK TABLES `club_user_profile` WRITE;
/*!40000 ALTER TABLE `club_user_profile` DISABLE KEYS */;
INSERT INTO `club_user_profile` VALUES (1,1,'Shari','Cobb','female','1950-01-01'),(2,2,'Victoria','Martin','female','1950-01-01'),(3,3,'Felipe','Lee','female','1950-01-01'),(4,4,'Norma','Zimmerman','male','1950-01-01'),(5,5,'Jake','Valdez','male','1950-01-01'),(6,6,'Leah','Maxwell','female','1950-01-01'),(7,7,'Lindsey','Drake','female','1950-01-01'),(8,8,'Leticia','Webb','female','1950-01-01'),(9,9,'Tina','Briggs','female','1950-01-01'),(10,10,'Toby','Allison','male','1950-01-01'),(11,11,'Michele','Spencer','female','1950-01-01');
/*!40000 ALTER TABLE `club_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_profile_address`
--

DROP TABLE IF EXISTS `club_user_profile_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_profile_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `suburl` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `contact_type` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_753AFDDCCCFA12B8` (`profile_id`),
  KEY `IDX_753AFDDCF92F3E70` (`country_id`),
  CONSTRAINT `club_user_profile_address_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `club_user_country` (`id`),
  CONSTRAINT `club_user_profile_address_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `club_user_profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile_address`
--

LOCK TABLES `club_user_profile_address` WRITE;
/*!40000 ALTER TABLE `club_user_profile_address` DISABLE KEYS */;
INSERT INTO `club_user_profile_address` VALUES (1,1,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(2,2,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(3,3,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(4,4,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(5,5,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(6,6,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(7,7,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(8,8,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(9,9,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(10,10,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(11,11,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1);
/*!40000 ALTER TABLE `club_user_profile_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_profile_company`
--

DROP TABLE IF EXISTS `club_user_profile_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_profile_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `cvr` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_37CB9B12CCFA12B8` (`profile_id`),
  CONSTRAINT `club_user_profile_company_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `club_user_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile_company`
--

LOCK TABLES `club_user_profile_company` WRITE;
/*!40000 ALTER TABLE `club_user_profile_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_profile_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_profile_email`
--

DROP TABLE IF EXISTS `club_user_profile_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_profile_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `contact_type` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_607BB7F3CCFA12B8` (`profile_id`),
  CONSTRAINT `club_user_profile_email_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `club_user_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile_email`
--

LOCK TABLES `club_user_profile_email` WRITE;
/*!40000 ALTER TABLE `club_user_profile_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_profile_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_profile_phone`
--

DROP TABLE IF EXISTS `club_user_profile_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_profile_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `number` varchar(255) NOT NULL,
  `contact_type` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C3A65C5ACCFA12B8` (`profile_id`),
  CONSTRAINT `club_user_profile_phone_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `club_user_profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile_phone`
--

LOCK TABLES `club_user_profile_phone` WRITE;
/*!40000 ALTER TABLE `club_user_profile_phone` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_profile_phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_role`
--

DROP TABLE IF EXISTS `club_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_role`
--

LOCK TABLES `club_user_role` WRITE;
/*!40000 ALTER TABLE `club_user_role` DISABLE KEYS */;
INSERT INTO `club_user_role` VALUES (1,'ROLE_ADMIN');
/*!40000 ALTER TABLE `club_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_user`
--

DROP TABLE IF EXISTS `club_user_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `member_number` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `algorithm` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_581B3A66CCFA12B8` (`profile_id`),
  KEY `IDX_581B3A6682F1BAF4` (`language_id`),
  KEY `IDX_581B3A6664D218E` (`location_id`),
  CONSTRAINT `club_user_user_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_user_user_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `club_user_profile` (`id`),
  CONSTRAINT `club_user_user_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `club_user_language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_user`
--

LOCK TABLES `club_user_user` WRITE;
/*!40000 ALTER TABLE `club_user_user` DISABLE KEYS */;
INSERT INTO `club_user_user` VALUES (1,1,NULL,NULL,1,'WdjbF8U+1sKTwQWLfN8gCNOL9gcoTvHhWxpSnZjyfBUfTmnDS7ZY7NV8VleFyb6oDoUKsCK83Ha1d2lYFpKU9g==',NULL,NULL,0,'sha512','iw04lxn8npc08kgs4owk8c00wkgcwk4',0,0,NULL,'2011-06-28 18:41:28','2011-06-28 18:41:28'),(2,2,NULL,NULL,2,'Yu6uYD/x6Leo7ko1rQY/MlZ67uZVkXX+G9O/24hKUc9L2EE1W6Gybfrg67a+plPzK3qCAlF0R42ptS710spVjA==',NULL,NULL,0,'sha512','lsl3s08q2wgoowgo4844o0gcgswg8wc',0,0,NULL,'2011-06-28 18:41:29','2011-06-28 18:41:29'),(3,3,NULL,NULL,3,'YTRZi+5jfq4Cxqwd7/mbqFoBeGKzfjESeddR3fXS9Iy1e3sfVr++4OQ5RHsRejxZ3dxneUWirukBOqSB4ycWEg==',NULL,NULL,0,'sha512','qbq3pwvg4e8wso04ko4o8g840s804gs',0,0,NULL,'2011-06-28 18:41:30','2011-06-28 18:41:30'),(4,4,NULL,NULL,4,'Gld0xorTEQNdxmSdck/gaHrdi8sDGiealSAC/gTbJ138k/UV4ozDTYgk4DFIVvyiHBwzBvhDXqMohblnKK0bYA==',NULL,NULL,0,'sha512','oc6j4fq8q7kog0swgwo8gg4w4ok4cwc',0,0,NULL,'2011-06-28 18:41:30','2011-06-28 18:41:30'),(5,5,NULL,NULL,5,'gGGdhZc978Ux8Tdl761IE29oHQSVw5U+8dyuVJ6LDVtAFp2ERZCN0Yz8TzKCGtK1OpnWvl6f6BQZk7NMyby9Yw==',NULL,NULL,0,'sha512','1yhrhn2qydc00ososswggo0c4sw0w4w',0,0,NULL,'2011-06-28 18:41:31','2011-06-28 18:41:31'),(6,6,NULL,NULL,6,'Ze0w4KegHXHUnbfDlGP8VAKRiHHGY1lLUPmq+FFZLVl9zNe6T6J+0DTrtuNnB2ZXJNPn/n9METOgeIPWPWlzdQ==',NULL,NULL,0,'sha512','6sazbagbs6os04cg40wssggggs40wgc',0,0,NULL,'2011-06-28 18:41:32','2011-06-28 18:41:32'),(7,7,NULL,NULL,7,'tjASNdagC7QIw6u9IbMo4uyVB2077dS55SanOEBsapktLX5BrbGfE5ufT5lbhT5raSy9BMXVloF054KFO+MPKg==',NULL,NULL,0,'sha512','3lq3smwnx668s8ckowswgk40cscwwcw',0,0,NULL,'2011-06-28 18:41:32','2011-06-28 18:41:32'),(8,8,NULL,NULL,8,'eUgMWfEjqG6O0ea1eM4nX6qSqBW2xTaKGUZjn5b1xvedmAPeNnEe5SjWxhS/6eazbYsZ3KO7VzhtUfKqC/73Iw==',NULL,NULL,0,'sha512','temc4vjmkfkswg8wow80kw00g088og0',0,0,NULL,'2011-06-28 18:41:33','2011-06-28 18:41:33'),(9,9,NULL,NULL,9,'BIxD8MzQ4vXSrnsgWiJh/GTCYK9miShEr0Rff5zJeXJAcy/EfkcqMzPTCLP1H1/rSF31gTm6EjrHGT5Q6VB8hw==',NULL,NULL,0,'sha512','2t5gyzisvw004cscs4kcgwgocssgwck',0,0,NULL,'2011-06-28 18:41:34','2011-06-28 18:41:34'),(10,10,NULL,NULL,10,'aGSi3SJawyqWEQJrmaNOVFgfcgp3Uygwp1Z3At9o+6Nu4bb8lBnwaZXn+QPxTBiRe3S0bEiqvzStFBu1yFXGwQ==',NULL,NULL,0,'sha512','9crins8pwi048ckcsc08ccwosg8g4kg',0,0,NULL,'2011-06-28 18:41:34','2011-06-28 18:41:35'),(11,11,NULL,NULL,11,'34ZB7WIELhqAjAc1hTIvMdTnmbh5lNtRmHRfe2tIeYeiox79THrC+E/gYrfygnBozAgry0OcIj8ygExB7GKmrw==',NULL,NULL,0,'sha512','c8go5e4x8a8sgk88gkw44gok4cccos8',0,0,NULL,'2011-06-28 18:41:35','2011-06-28 18:41:35');
/*!40000 ALTER TABLE `club_user_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_user_group`
--

DROP TABLE IF EXISTS `club_user_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_user_group` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `IDX_37734BAFFE54D947` (`group_id`),
  KEY `IDX_37734BAFA76ED395` (`user_id`),
  CONSTRAINT `club_user_user_group_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`),
  CONSTRAINT `club_user_user_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_user_group`
--

LOCK TABLES `club_user_user_group` WRITE;
/*!40000 ALTER TABLE `club_user_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_user_note`
--

DROP TABLE IF EXISTS `club_user_user_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_user_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `note` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_796D8BEAA76ED395` (`user_id`),
  CONSTRAINT `club_user_user_note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_user_note`
--

LOCK TABLES `club_user_user_note` WRITE;
/*!40000 ALTER TABLE `club_user_user_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_user_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_user_role`
--

DROP TABLE IF EXISTS `club_user_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_E1B9FB94A76ED395` (`user_id`),
  KEY `IDX_E1B9FB94D60322AC` (`role_id`),
  CONSTRAINT `club_user_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `club_user_role` (`id`),
  CONSTRAINT `club_user_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_user_role`
--

LOCK TABLES `club_user_user_role` WRITE;
/*!40000 ALTER TABLE `club_user_user_role` DISABLE KEYS */;
INSERT INTO `club_user_user_role` VALUES (10,1);
/*!40000 ALTER TABLE `club_user_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_whois_online`
--

DROP TABLE IF EXISTS `club_user_whois_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_whois_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_whois_online`
--

LOCK TABLES `club_user_whois_online` WRITE;
/*!40000 ALTER TABLE `club_user_whois_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_whois_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_product`
--

DROP TABLE IF EXISTS `group_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_product` (
  `group_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`product_id`),
  KEY `IDX_554A50A1FE54D947` (`group_id`),
  KEY `IDX_554A50A14584665A` (`product_id`),
  CONSTRAINT `group_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_product_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_product`
--

LOCK TABLES `group_product` WRITE;
/*!40000 ALTER TABLE `group_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_role`
--

DROP TABLE IF EXISTS `group_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_role` (
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`role_id`),
  KEY `IDX_7E33D11AFE54D947` (`group_id`),
  KEY `IDX_7E33D11AD60322AC` (`role_id`),
  CONSTRAINT `group_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `club_user_role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_role_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_role`
--

LOCK TABLES `group_role` WRITE;
/*!40000 ALTER TABLE `group_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_mail`
--

DROP TABLE IF EXISTS `location_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_mail` (
  `location_id` int(11) NOT NULL,
  `mail_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`mail_id`),
  KEY `IDX_D122190864D218E` (`location_id`),
  KEY `IDX_D1221908C8776F01` (`mail_id`),
  CONSTRAINT `location_mail_ibfk_2` FOREIGN KEY (`mail_id`) REFERENCES `club_mail` (`id`) ON DELETE CASCADE,
  CONSTRAINT `location_mail_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_mail`
--

LOCK TABLES `location_mail` WRITE;
/*!40000 ALTER TABLE `location_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `location_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_group`
--

DROP TABLE IF EXISTS `mail_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_group` (
  `mail_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`,`group_id`),
  KEY `IDX_5903E6AAC8776F01` (`mail_id`),
  KEY `IDX_5903E6AAFE54D947` (`group_id`),
  CONSTRAINT `mail_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mail_group_ibfk_1` FOREIGN KEY (`mail_id`) REFERENCES `club_mail` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_group`
--

LOCK TABLES `mail_group` WRITE;
/*!40000 ALTER TABLE `mail_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_location`
--

DROP TABLE IF EXISTS `mail_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_location` (
  `mail_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`,`location_id`),
  KEY `IDX_83494883C8776F01` (`mail_id`),
  KEY `IDX_8349488364D218E` (`location_id`),
  CONSTRAINT `mail_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mail_location_ibfk_1` FOREIGN KEY (`mail_id`) REFERENCES `club_mail` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_location`
--

LOCK TABLES `mail_location` WRITE;
/*!40000 ALTER TABLE `mail_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_user`
--

DROP TABLE IF EXISTS `mail_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_user` (
  `mail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`,`user_id`),
  KEY `IDX_20E84520C8776F01` (`mail_id`),
  KEY `IDX_20E84520A76ED395` (`user_id`),
  CONSTRAINT `mail_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `club_user_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mail_user_ibfk_1` FOREIGN KEY (`mail_id`) REFERENCES `club_mail` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_user`
--

LOCK TABLES `mail_user` WRITE;
/*!40000 ALTER TABLE `mail_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variantgroup`
--

DROP TABLE IF EXISTS `product_variantgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variantgroup` (
  `product_id` int(11) NOT NULL,
  `variantgroup_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`variantgroup_id`),
  KEY `IDX_52B980204584665A` (`product_id`),
  KEY `IDX_52B98020E5B9157C` (`variantgroup_id`),
  CONSTRAINT `product_variantgroup_ibfk_2` FOREIGN KEY (`variantgroup_id`) REFERENCES `club_shop_variant_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_variantgroup_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `club_shop_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variantgroup`
--

LOCK TABLES `product_variantgroup` WRITE;
/*!40000 ALTER TABLE `product_variantgroup` DISABLE KEYS */;
INSERT INTO `product_variantgroup` VALUES (8,1),(9,2);
/*!40000 ALTER TABLE `product_variantgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_group`
--

DROP TABLE IF EXISTS `role_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_group` (
  `role_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`group_id`),
  KEY `IDX_9A1CACEAD60322AC` (`role_id`),
  KEY `IDX_9A1CACEAFE54D947` (`group_id`),
  CONSTRAINT `role_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_group_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `club_user_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_group`
--

LOCK TABLES `role_group` WRITE;
/*!40000 ALTER TABLE `role_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-28 18:41:53
