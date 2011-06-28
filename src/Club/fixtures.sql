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
-- Dumping data for table `club_event_event`
--

LOCK TABLES `club_event_event` WRITE;
/*!40000 ALTER TABLE `club_event_event` DISABLE KEYS */;
INSERT INTO `club_event_event` VALUES (1,'Tournament','Senior Tournament',NULL,NULL,'2011-06-23 10:00:00','2011-06-23 19:00:00','2011-06-28 18:41:36','2011-06-28 18:41:36'),(2,'BBQ party','BBQ Party',NULL,NULL,'2011-07-03 19:00:00','2011-07-03 23:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37'),(3,'Junior Tournament','Junior Tournament',NULL,NULL,'2011-07-13 12:00:00','2011-07-13 17:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37');
/*!40000 ALTER TABLE `club_event_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_group_location`
--

LOCK TABLES `club_group_location` WRITE;
/*!40000 ALTER TABLE `club_group_location` DISABLE KEYS */;
INSERT INTO `club_group_location` VALUES (4,1);
/*!40000 ALTER TABLE `club_group_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_shop_category`
--

LOCK TABLES `club_shop_category` WRITE;
/*!40000 ALTER TABLE `club_shop_category` DISABLE KEYS */;
INSERT INTO `club_shop_category` VALUES (1,NULL,NULL,1,'Subscriptions','Subscriptions'),(2,NULL,NULL,1,'Ticket coupon','Ticket coupon'),(3,NULL,NULL,1,'Food','Food'),(4,NULL,NULL,1,'Liquid','Liquid'),(5,NULL,NULL,1,'Sport equipment','Sport equipment'),(6,NULL,NULL,1,'Other','Other'),(7,NULL,5,1,'Bags','Bags'),(8,NULL,5,1,'Rackets','Rackets');
/*!40000 ALTER TABLE `club_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_shop_category_product`
--

LOCK TABLES `club_shop_category_product` WRITE;
/*!40000 ALTER TABLE `club_shop_category_product` DISABLE KEYS */;
INSERT INTO `club_shop_category_product` VALUES (1,1),(2,1),(3,1),(4,1),(5,2),(6,2),(7,5),(8,6),(9,1);
/*!40000 ALTER TABLE `club_shop_category_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_shop_product`
--

LOCK TABLES `club_shop_product` WRITE;
/*!40000 ALTER TABLE `club_shop_product` DISABLE KEYS */;
INSERT INTO `club_shop_product` VALUES (1,1,'1. md, subscription','1. md, subscription','100.00',NULL),(2,1,'2. md, subscription','2. md, subscription','175.00',NULL),(3,1,'Period subscription','Period subscription','1000.00',NULL),(4,1,'Lifetime membership','Lifetime membership','5000.00',NULL),(5,1,'10 clip','10 clip','100.00',NULL),(6,1,'20 clip','20 clip','175.00',NULL),(7,1,'Tennis Balls','Tennis Balls','50.00',NULL),(8,1,'Club T-shirt','Club T-shirt','200.00',NULL),(9,1,'Easter subscription','Easter subscription','50.00',NULL);
/*!40000 ALTER TABLE `club_shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_shop_product_attribute`
--

LOCK TABLES `club_shop_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_product_attribute` DISABLE KEYS */;
INSERT INTO `club_shop_product_attribute` VALUES (1,1,1,'1'),(2,1,7,'3'),(3,1,8,'1'),(4,1,5,'2011-06-01'),(5,2,1,'2'),(6,2,7,'5'),(7,2,8,'1'),(8,3,5,'2011-04-01'),(9,3,6,'2011-10-31'),(10,4,4,'1'),(11,5,2,'10'),(12,5,8,'1'),(13,6,2,'20'),(14,6,8,'1'),(15,9,5,'2011-04-16'),(16,9,6,'2011-04-30');
/*!40000 ALTER TABLE `club_shop_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_group`
--

LOCK TABLES `club_user_group` WRITE;
/*!40000 ALTER TABLE `club_user_group` DISABLE KEYS */;
INSERT INTO `club_user_group` VALUES (1,NULL,'Senior','dynamic',NULL,18,45,1),(2,NULL,'Junior','dynamic',NULL,0,17,1),(3,NULL,'Members of honor','static',NULL,NULL,NULL,1),(4,NULL,'DK - Members','dynamic',NULL,NULL,NULL,1),(5,NULL,'All Members','dynamic',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `club_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_location`
--

LOCK TABLES `club_user_location` WRITE;
/*!40000 ALTER TABLE `club_user_location` DISABLE KEYS */;
INSERT INTO `club_user_location` VALUES (1,NULL,1,'Denmark'),(2,1,1,'Aalborg'),(3,1,1,'Copenhagen'),(4,2,1,'Aalborg Tennis Club'),(5,2,1,'Gug Tennis Club');
/*!40000 ALTER TABLE `club_user_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_location_config`
--

LOCK TABLES `club_user_location_config` WRITE;
/*!40000 ALTER TABLE `club_user_location_config` DISABLE KEYS */;
INSERT INTO `club_user_location_config` VALUES (1,1,1,'localhost'),(2,1,2,'localhost'),(3,1,3,'localhost'),(4,1,4,'localhost'),(5,1,5,'localhost'),(6,2,1,'25'),(7,2,2,'25'),(8,2,3,'25'),(9,2,4,'25'),(10,2,5,'25'),(11,3,1,NULL),(12,3,2,NULL),(13,3,3,NULL),(14,3,4,NULL),(15,3,5,NULL),(16,4,1,NULL),(17,4,2,NULL),(18,4,3,NULL),(19,4,4,NULL),(20,4,5,NULL),(21,5,1,'5001'),(22,5,2,'5001'),(23,5,3,'5001'),(24,5,4,'5001'),(25,5,5,'5001'),(26,6,1,'3001'),(27,6,2,'3001'),(28,6,3,'3001'),(29,6,4,'3001'),(30,6,5,'3001'),(31,7,1,'en_UK'),(32,7,2,'en_UK'),(33,7,3,'en_UK'),(34,7,4,'en_UK'),(35,7,5,'en_UK');
/*!40000 ALTER TABLE `club_user_location_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_profile`
--

LOCK TABLES `club_user_profile` WRITE;
/*!40000 ALTER TABLE `club_user_profile` DISABLE KEYS */;
INSERT INTO `club_user_profile` VALUES (1,1,'Shari','Cobb','female','1950-01-01'),(2,2,'Victoria','Martin','female','1950-01-01'),(3,3,'Felipe','Lee','female','1950-01-01'),(4,4,'Norma','Zimmerman','male','1950-01-01'),(5,5,'Jake','Valdez','male','1950-01-01'),(6,6,'Leah','Maxwell','female','1950-01-01'),(7,7,'Lindsey','Drake','female','1950-01-01'),(8,8,'Leticia','Webb','female','1950-01-01'),(9,9,'Tina','Briggs','female','1950-01-01'),(10,10,'Toby','Allison','male','1950-01-01'),(11,11,'Michele','Spencer','female','1950-01-01');
/*!40000 ALTER TABLE `club_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_profile_address`
--

LOCK TABLES `club_user_profile_address` WRITE;
/*!40000 ALTER TABLE `club_user_profile_address` DISABLE KEYS */;
INSERT INTO `club_user_profile_address` VALUES (1,1,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(2,2,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(3,3,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(4,4,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(5,5,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(6,6,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(7,7,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(8,8,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(9,9,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(10,10,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1),(11,11,1,'Vesterbro 115',NULL,'9000','Aalborg',NULL,'home',1);
/*!40000 ALTER TABLE `club_user_profile_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_user`
--

LOCK TABLES `club_user_user` WRITE;
/*!40000 ALTER TABLE `club_user_user` DISABLE KEYS */;
INSERT INTO `club_user_user` VALUES (1,1,NULL,NULL,1,'WdjbF8U+1sKTwQWLfN8gCNOL9gcoTvHhWxpSnZjyfBUfTmnDS7ZY7NV8VleFyb6oDoUKsCK83Ha1d2lYFpKU9g==',NULL,NULL,0,'sha512','iw04lxn8npc08kgs4owk8c00wkgcwk4',0,0,NULL,'2011-06-28 18:41:28','2011-06-28 18:41:28'),(2,2,NULL,NULL,2,'Yu6uYD/x6Leo7ko1rQY/MlZ67uZVkXX+G9O/24hKUc9L2EE1W6Gybfrg67a+plPzK3qCAlF0R42ptS710spVjA==',NULL,NULL,0,'sha512','lsl3s08q2wgoowgo4844o0gcgswg8wc',0,0,NULL,'2011-06-28 18:41:29','2011-06-28 18:41:29'),(3,3,NULL,NULL,3,'YTRZi+5jfq4Cxqwd7/mbqFoBeGKzfjESeddR3fXS9Iy1e3sfVr++4OQ5RHsRejxZ3dxneUWirukBOqSB4ycWEg==',NULL,NULL,0,'sha512','qbq3pwvg4e8wso04ko4o8g840s804gs',0,0,NULL,'2011-06-28 18:41:30','2011-06-28 18:41:30'),(4,4,NULL,NULL,4,'Gld0xorTEQNdxmSdck/gaHrdi8sDGiealSAC/gTbJ138k/UV4ozDTYgk4DFIVvyiHBwzBvhDXqMohblnKK0bYA==',NULL,NULL,0,'sha512','oc6j4fq8q7kog0swgwo8gg4w4ok4cwc',0,0,NULL,'2011-06-28 18:41:30','2011-06-28 18:41:30'),(5,5,NULL,NULL,5,'gGGdhZc978Ux8Tdl761IE29oHQSVw5U+8dyuVJ6LDVtAFp2ERZCN0Yz8TzKCGtK1OpnWvl6f6BQZk7NMyby9Yw==',NULL,NULL,0,'sha512','1yhrhn2qydc00ososswggo0c4sw0w4w',0,0,NULL,'2011-06-28 18:41:31','2011-06-28 18:41:31'),(6,6,NULL,NULL,6,'Ze0w4KegHXHUnbfDlGP8VAKRiHHGY1lLUPmq+FFZLVl9zNe6T6J+0DTrtuNnB2ZXJNPn/n9METOgeIPWPWlzdQ==',NULL,NULL,0,'sha512','6sazbagbs6os04cg40wssggggs40wgc',0,0,NULL,'2011-06-28 18:41:32','2011-06-28 18:41:32'),(7,7,NULL,NULL,7,'tjASNdagC7QIw6u9IbMo4uyVB2077dS55SanOEBsapktLX5BrbGfE5ufT5lbhT5raSy9BMXVloF054KFO+MPKg==',NULL,NULL,0,'sha512','3lq3smwnx668s8ckowswgk40cscwwcw',0,0,NULL,'2011-06-28 18:41:32','2011-06-28 18:41:32'),(8,8,NULL,NULL,8,'eUgMWfEjqG6O0ea1eM4nX6qSqBW2xTaKGUZjn5b1xvedmAPeNnEe5SjWxhS/6eazbYsZ3KO7VzhtUfKqC/73Iw==',NULL,NULL,0,'sha512','temc4vjmkfkswg8wow80kw00g088og0',0,0,NULL,'2011-06-28 18:41:33','2011-06-28 18:41:33'),(9,9,NULL,NULL,9,'BIxD8MzQ4vXSrnsgWiJh/GTCYK9miShEr0Rff5zJeXJAcy/EfkcqMzPTCLP1H1/rSF31gTm6EjrHGT5Q6VB8hw==',NULL,NULL,0,'sha512','2t5gyzisvw004cscs4kcgwgocssgwck',0,0,NULL,'2011-06-28 18:41:34','2011-06-28 18:41:34'),(10,10,1,1,10,'aGSi3SJawyqWEQJrmaNOVFgfcgp3Uygwp1Z3At9o+6Nu4bb8lBnwaZXn+QPxTBiRe3S0bEiqvzStFBu1yFXGwQ==',NULL,NULL,0,'sha512','9crins8pwi048ckcsc08ccwosg8g4kg',0,0,NULL,'2011-06-28 18:41:34','2011-06-28 18:42:50'),(11,11,NULL,NULL,11,'34ZB7WIELhqAjAc1hTIvMdTnmbh5lNtRmHRfe2tIeYeiox79THrC+E/gYrfygnBozAgry0OcIj8ygExB7GKmrw==',NULL,NULL,0,'sha512','c8go5e4x8a8sgk88gkw44gok4cccos8',0,0,NULL,'2011-06-28 18:41:35','2011-06-28 18:41:35');
/*!40000 ALTER TABLE `club_user_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `club_user_user_role`
--

LOCK TABLES `club_user_user_role` WRITE;
/*!40000 ALTER TABLE `club_user_user_role` DISABLE KEYS */;
INSERT INTO `club_user_user_role` VALUES (10,1);
/*!40000 ALTER TABLE `club_user_user_role` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-28 18:51:34
