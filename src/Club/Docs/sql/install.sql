-- MySQL dump 10.13  Distrib 5.1.57, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: clubmaster
-- ------------------------------------------------------
-- Server version	5.1.57-3

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_event_event`
--

LOCK TABLES `club_event_event` WRITE;
/*!40000 ALTER TABLE `club_event_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_event_event` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_category`
--

LOCK TABLES `club_shop_category` WRITE;
/*!40000 ALTER TABLE `club_shop_category` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_product`
--

LOCK TABLES `club_shop_product` WRITE;
/*!40000 ALTER TABLE `club_shop_product` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_product_attribute`
--

LOCK TABLES `club_shop_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_product_attribute` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_variant_group`
--

LOCK TABLES `club_shop_variant_group` WRITE;
/*!40000 ALTER TABLE `club_shop_variant_group` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_shop_variant_value`
--

LOCK TABLES `club_shop_variant_value` WRITE;
/*!40000 ALTER TABLE `club_shop_variant_value` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_task_task`
--

LOCK TABLES `club_task_task` WRITE;
/*!40000 ALTER TABLE `club_task_task` DISABLE KEYS */;
INSERT INTO `club_task_task` VALUES (1,'Update dynamic groups',1,0,'onGroupTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour'),(2,'Cleanup logs',1,0,'onLogTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour'),(3,'Renewal memberships',1,0,'onAutoRenewalTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour'),(4,'Cleanup login logs',1,0,'onLoginAttemptTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour'),(5,'Cleanup ban logs',1,0,'onBanTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour'),(6,'Send emails',1,0,'onMailTask','2011-07-04 11:33:36','2011-07-04 11:33:36',NULL,'2011-07-04 11:33:36','+1 hour');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_attribute`
--

LOCK TABLES `club_user_attribute` WRITE;
/*!40000 ALTER TABLE `club_user_attribute` DISABLE KEYS */;
INSERT INTO `club_user_attribute` VALUES (1,'name'),(2,'member_number'),(3,'min_age'),(4,'max_age'),(5,'gender'),(6,'postal_code'),(7,'city'),(8,'country'),(9,'is_active'),(10,'has_ticket'),(11,'has_subscription'),(12,'location');
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
INSERT INTO `club_user_config` VALUES (1,'account_default_income'),(2,'account_default_vat'),(4,'default_currency'),(3,'default_language'),(5,'default_location'),(6,'email_sender_address'),(7,'email_sender_name');
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
  `value` decimal(10,5) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_currency`
--

LOCK TABLES `club_user_currency` WRITE;
/*!40000 ALTER TABLE `club_user_currency` DISABLE KEYS */;
INSERT INTO `club_user_currency` VALUES (1,'US Dollar','USD','$',NULL,'2','1.00000',0,'2011-07-04 11:33:36','2011-07-04 11:33:36'),(2,'Euro','EUR','€',NULL,'2','1.00000',0,'2011-07-04 11:33:36','2011-07-04 11:33:36'),(3,'Danish Krone','DKK',NULL,'DK','2','1.00000',0,'2011-07-04 11:33:36','2011-07-04 11:33:36');
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
  `is_active_member` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C6C4F170FE54D947` (`group_id`),
  CONSTRAINT `club_user_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_group`
--

LOCK TABLES `club_user_group` WRITE;
/*!40000 ALTER TABLE `club_user_group` DISABLE KEYS */;
INSERT INTO `club_user_group` VALUES (1,NULL,'Super Administrators','static',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `club_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_group_location`
--

DROP TABLE IF EXISTS `club_user_group_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_group_location` (
  `group_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`location_id`),
  KEY `IDX_4CDF5D9BFE54D947` (`group_id`),
  KEY `IDX_4CDF5D9B64D218E` (`location_id`),
  CONSTRAINT `club_user_group_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`),
  CONSTRAINT `club_user_group_location_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_group_location`
--

LOCK TABLES `club_user_group_location` WRITE;
/*!40000 ALTER TABLE `club_user_group_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `club_user_group_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club_user_group_role`
--

DROP TABLE IF EXISTS `club_user_group_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_user_group_role` (
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`role_id`),
  KEY `IDX_C6422528FE54D947` (`group_id`),
  KEY `IDX_C6422528D60322AC` (`role_id`),
  CONSTRAINT `club_user_group_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `club_user_role` (`id`),
  CONSTRAINT `club_user_group_role_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `club_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_group_role`
--

LOCK TABLES `club_user_group_role` WRITE;
/*!40000 ALTER TABLE `club_user_group_role` DISABLE KEYS */;
INSERT INTO `club_user_group_role` VALUES (1,1);
/*!40000 ALTER TABLE `club_user_group_role` ENABLE KEYS */;
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
  `location_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3D42B7F64D218E` (`location_id`),
  CONSTRAINT `club_user_location_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_location`
--

LOCK TABLES `club_user_location` WRITE;
/*!40000 ALTER TABLE `club_user_location` DISABLE KEYS */;
INSERT INTO `club_user_location` VALUES (1,NULL,'ClubMaster');
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
  `location_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `config` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_idx` (`location_id`,`config`),
  KEY `IDX_3432EBBF64D218E` (`location_id`),
  CONSTRAINT `club_user_location_config_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `club_user_location` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_location_config`
--

LOCK TABLES `club_user_location_config` WRITE;
/*!40000 ALTER TABLE `club_user_location_config` DISABLE KEYS */;
INSERT INTO `club_user_location_config` VALUES (1,1,'1','account_default_income'),(2,1,'1','account_default_vat'),(3,1,'1','default_language'),(4,1,'1','default_currency'),(5,1,'2','default_location'),(6,1,'noreply@clubmaster.dk','email_sender_address'),(7,1,'ClubMaster','email_sender_name');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile`
--

LOCK TABLES `club_user_profile` WRITE;
/*!40000 ALTER TABLE `club_user_profile` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_profile_address`
--

LOCK TABLES `club_user_profile_address` WRITE;
/*!40000 ALTER TABLE `club_user_profile_address` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_role`
--

LOCK TABLES `club_user_role` WRITE;
/*!40000 ALTER TABLE `club_user_role` DISABLE KEYS */;
INSERT INTO `club_user_role` VALUES (1,'ROLE_SUPER_ADMIN'),(2,'ROLE_ADMIN');
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
  `activation_code` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club_user_user`
--

LOCK TABLES `club_user_user` WRITE;
/*!40000 ALTER TABLE `club_user_user` DISABLE KEYS */;
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
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20110630004000'),('20110630105810');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `product_variantgroup` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-07-04 11:34:40
