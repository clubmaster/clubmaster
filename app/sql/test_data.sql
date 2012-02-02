-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: clubmaster_v2
-- ------------------------------------------------------
-- Server version       5.1.49-3-log

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

INSERT INTO club_user_location (location_name,location_id) VALUES
  ('Aalborg',1);

INSERT INTO club_user_group (group_id,group_name,group_type,gender,min_age,max_age,active_member) VALUES
  (null,'Senior','dynamic',null,18,45,1),
  (null,'Junior','dynamic',null,0,17,1),
  (null,'Members of honor','static',null,null,null,1),
  (null,'All Members, active','dynamic',null,null,null,1),
  (null,'All Members, inactive','dynamic',null,null,null,0);

INSERT INTO club_shop_category (id,category_id,category_name,description,location_id) VALUES
  (1,null,'Subscriptions','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (2,null,'Ticket coupon','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (3,null,'Food','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (4,null,'Liquid','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (5,null,'Sport equipment','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (6,null,'Other','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (7,5,'Bags','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2),
  (8,5,'Rackets','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis, dolor sed tempor feugiat, nibh erat volutpat sapien, ac aliquet urna tellus id urna. Mauris id risus eu ante euismod.',2);

INSERT INTO club_shop_product (id,product_name,description,price) VALUES
  (1,'1. md, subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',100),
  (2,'2. md, subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',175),
  (3,'Period subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',1000),
  (4,'Lifetime membership','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',5000),
  (5,'10 clip','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',100),
  (6,'20 clip','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',175),
  (7,'Tennis Balls','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',50),
  (8,'Club T-shirt','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',200),
  (9,'Easter subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',50),
  (10,'Subscription + 1Month + Renewal(A) + Location + Pauses','Lorem ipsum...',100),
  (11,'Subscription + 3Month + Renewal(A) + Start date','Lorem ipsum...',100),
  (12,'Subscription + Start date + Expire date','Lorem ipsum...',100),
  (13,'Subscription + Lifetime','Lorem ipsum...',100),
  (14,'Subscription + Start date + Expire date + Renewal(Y)','Lorem ipsum...',100),
  (15,'10 tickets + Renewal(A) + Location + Pauses','Lorem ipsum...',100),
  (16,'Subscription + 3Month + Renewal(A) + Start date in future','Lorem ipsum...',100),
  (17,'Subscription + 1Month + Start date + Renewal(Y)','Lorem ipsum...',100),
  (18,'Subscription + Start date + Expire date + Renewal(Y) + ealier this year','Lorem ipsum...',100),
  (19,'Daily subscription','Lorem ipsum...',100),
  (20,'10 min subscription','Lorem ipsum...',35),
  (21,'10 min subscription + pauses','Lorem ipsum...',35);

INSERT INTO club_shop_category_product (product_id,category_id) VALUES
  (1,1),
  (2,1),
  (3,1),
  (4,1),
  (5,2),
  (6,2),
  (7,5),
  (8,6),
  (9,1),
  (10,1),
  (11,1),
  (12,1),
  (13,1),
  (14,1),
  (15,2),
  (16,1),
  (17,1),
  (18,1),
  (19,1),
  (20,1),
  (21,1);

INSERT INTO club_shop_product_attribute (product_id,attribute,value) VALUES
  (1,'time_interval','1M'),
  (1,'allowed_pauses',3),
  (1,'location',1),
  (1,'team',1),
  (2,'time_interval','2M'),
  (2,'allowed_pauses',5),
  (2,'location',5),
  (3,'start_date','2011-04-01'),
  (3,'expire_date','2011-10-31'),
  (4,'auto_renewal',1),
  (5,'ticket',10),
  (5,'location',1),
  (5,'team',1),
  (6,'ticket',20),
  (6,'location',1),
  (9,'start_date','2011-04-16'),
  (9,'expire_date','2011-04-30'),
  (10,'time_interval','1M'),
  (10,'auto_renewal','A'),
  (10,'location',1),
  (10,'allowed_pauses',3),
  (11,'time_interval','3M'),
  (11,'auto_renewal','A'),
  (11,'start_date','2009-09-01'),
  (12,'start_date','2009-09-01'),
  (12,'expire_date','2013-12-01'),
  (13,'auto_renewal',1),
  (14,'start_date','2009-09-01'),
  (14,'expire_date','2011-12-01'),
  (14,'auto_renewal','Y'),
  (15,'ticket',10),
  (15,'auto_renewal','A'),
  (15,'location',1),
  (15,'allowed_pauses',3),
  (16,'time_interval','3M'),
  (16,'auto_renewal','A'),
  (16,'start_date','2012-09-01'),
  (17,'time_interval','1M'),
  (17,'start_date','2011-12-01'),
  (17,'auto_renewal','Y'),
  (18,'start_date','2009-04-01'),
  (18,'expire_date','2011-06-12'),
  (18,'auto_renewal','Y'),
  (19,'time_interval','1D'),
  (19,'auto_renewal','A'),
  (20,'time_interval','T10M'),
  (20,'auto_renewal','A'),
  (21,'time_interval','T10M'),
  (21,'auto_renewal','A'),
  (21,'allowed_pauses','2');
