LOCK TABLES `club_event_event` WRITE;
/*!40000 ALTER TABLE `club_event_event` DISABLE KEYS */;
INSERT INTO `club_event_event` VALUES (1,'Tournament','Senior Tournament',NULL,NULL,'2011-06-23 10:00:00','2011-06-23 19:00:00','2011-06-28 18:41:36','2011-06-28 18:41:36'),(2,'BBQ party','BBQ Party',NULL,NULL,'2011-07-03 19:00:00','2011-07-03 23:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37'),(3,'Junior Tournament','Junior Tournament',NULL,NULL,'2011-07-13 12:00:00','2011-07-13 17:00:00','2011-06-28 18:41:37','2011-06-28 18:41:37');
/*!40000 ALTER TABLE `club_event_event` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_shop_category` WRITE;
/*!40000 ALTER TABLE `club_shop_category` DISABLE KEYS */;
INSERT INTO `club_shop_category` VALUES (1,NULL,NULL,1,'Subscriptions','Subscriptions'),(2,NULL,NULL,1,'Ticket coupon','Ticket coupon'),(3,NULL,NULL,1,'Food','Food'),(4,NULL,NULL,1,'Liquid','Liquid'),(5,NULL,NULL,1,'Sport equipment','Sport equipment'),(6,NULL,NULL,1,'Other','Other'),(7,NULL,5,1,'Bags','Bags'),(8,NULL,5,1,'Rackets','Rackets');
/*!40000 ALTER TABLE `club_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_shop_product` WRITE;
/*!40000 ALTER TABLE `club_shop_product` DISABLE KEYS */;
INSERT INTO `club_shop_product` VALUES (1,1,'1. md, subscription','1. md, subscription','100.00',NULL),(2,1,'2. md, subscription','2. md, subscription','175.00',NULL),(3,1,'Period subscription','Period subscription','1000.00',NULL),(4,1,'Lifetime membership','Lifetime membership','5000.00',NULL),(5,1,'10 clip','10 clip','100.00',NULL),(6,1,'20 clip','20 clip','175.00',NULL),(7,1,'Tennis Balls','Tennis Balls','50.00',NULL),(8,1,'Club T-shirt','Club T-shirt','200.00',NULL),(9,1,'Easter subscription','Easter subscription','50.00',NULL);
/*!40000 ALTER TABLE `club_shop_product` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_shop_category_product` WRITE;
/*!40000 ALTER TABLE `club_shop_category_product` DISABLE KEYS */;
INSERT INTO `club_shop_category_product` VALUES (1,1),(2,1),(3,1),(4,1),(5,2),(6,2),(7,5),(8,6),(9,1);
/*!40000 ALTER TABLE `club_shop_category_product` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_shop_product_attribute` WRITE;
/*!40000 ALTER TABLE `club_shop_product_attribute` DISABLE KEYS */;
INSERT INTO `club_shop_product_attribute` VALUES (1,1,1,'1'),(2,1,7,'3'),(3,1,8,'1'),(4,1,5,'2011-06-01'),(5,2,1,'2'),(6,2,7,'5'),(7,2,8,'1'),(8,3,5,'2011-04-01'),(9,3,6,'2011-10-31'),(10,4,4,'1'),(11,5,2,'10'),(12,5,8,'1'),(13,6,2,'20'),(14,6,8,'1'),(15,9,5,'2011-04-16'),(16,9,6,'2011-04-30');
/*!40000 ALTER TABLE `club_shop_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_user_group` WRITE;
/*!40000 ALTER TABLE `club_user_group` DISABLE KEYS */;
INSERT INTO `club_user_group` VALUES (2,NULL,'Senior','dynamic',NULL,18,45,1),(3,NULL,'Junior','dynamic',NULL,0,17,1),(4,NULL,'Members of honor','static',NULL,NULL,NULL,1),(5,NULL,'DK - Members','dynamic',NULL,NULL,NULL,1),(6,NULL,'All Members','dynamic',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `club_user_group` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `club_user_location` WRITE;
/*!40000 ALTER TABLE `club_user_location` DISABLE KEYS */;
INSERT INTO `club_user_location` VALUES (2,NULL,'Denmark'),(3,2,'Aalborg'),(4,2,'Copenhagen'),(5,3,'Aalborg Tennis Club'),(6,3,'Gug Tennis Club');
/*!40000 ALTER TABLE `club_user_location` ENABLE KEYS */;
UNLOCK TABLES;
