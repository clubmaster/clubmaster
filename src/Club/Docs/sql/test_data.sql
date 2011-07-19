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

INSERT INTO club_event_event (event_name, description, price, max_attends, start_date, stop_date, created_at, updated_at) VALUES
('BBQ Party','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dignissim leo ac ligula auctor molestie. Maecenas egestas mollis velit et adipiscing. Aliquam venenatis leo vitae metus congue suscipit. Nunc viverra suscipit pharetra. Integer eu nibh quis elit gravida imperdiet. Nunc dapibus convallis ipsum, ut sodales orci ultricies eget. Vivamus convallis condimentum ullamcorper. Nullam ac nisi orci, sit amet volutpat velit. Cras quis vestibulum mauris. Morbi sit amet tortor in diam suscipit aliquet at quis libero. Vestibulum mauris lacus, ultrices sollicitudin vulputate dignissim, ultrices sed tellus. Integer in gravida eros. Quisque non vestibulum tellus. Suspendisse dictum pharetra eros quis consectetur. Sed pharetra rutrum sodales. Suspendisse potenti. Nam a sapien lacus.</p>
<p>Aenean dignissim nisi sit amet nisl ultricies vel volutpat dui bibendum. Integer cursus vulputate elit, eu faucibus diam pulvinar nec. Praesent et nulla nisl, nec interdum sapien. Integer vel sapien et risus ultrices pulvinar eget quis enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque eget tortor sit amet enim rhoncus facilisis non eget est. In hac habitasse platea dictumst. Nunc et nisi lectus. Etiam dictum nisi sodales nunc porttitor ullamcorper. Ut leo tellus, sagittis id volutpat et, sagittis sed diam. Vestibulum venenatis bibendum augue vitae suscipit. Mauris vulputate, augue in scelerisque iaculis, metus orci suscipit purus, eget ornare eros libero ut mi. Fusce sem quam, commodo in semper eu, pulvinar nec metus. Nunc justo diam, laoreet molestie venenatis a, porttitor non tellus. Vivamus vulputate, ligula in tempor viverra, purus turpis dapibus quam, vel eleifend mauris mauris a magna. In hac habitasse platea dictumst. Suspendisse in velit augue.</p>',null,null,'2011-07-12 12:00:00','2011-07-12 18:00:00',now(),now()),
('Senior Tournament','<p>Nunc fermentum dignissim orci rhoncus feugiat. In ullamcorper ligula ac enim congue bibendum. In hendrerit metus nec neque sollicitudin at tempus nisl hendrerit. Integer rutrum urna quis diam consequat blandit. Donec eget libero eros, nec consectetur magna. In sed est nulla. Praesent ornare lorem dui. Fusce pulvinar augue at mauris sollicitudin faucibus. Morbi mollis sagittis nisl ac tincidunt. Curabitur a erat eu risus mattis lacinia eget eu eros.</p>
<p>Proin purus mauris, fringilla eu eleifend quis, tincidunt in felis. Donec ut erat leo. Cras fermentum ultricies ipsum quis ultricies. Proin ut nulla eu libero congue suscipit aliquet eu nunc. Donec elementum, velit sit amet aliquam mattis, justo risus malesuada mauris, ac tempor urna sapien eu lacus. Maecenas mollis, leo quis facilisis bibendum, sem justo pellentesque justo, tristique sagittis justo libero non ipsum. Sed non elit justo. Morbi vitae elit augue, ut blandit massa. Nunc et dolor elit. Donec et magna sem. Quisque bibendum ligula quis sem laoreet fringilla. Suspendisse a nibh neque, consequat sollicitudin nisi. Proin vel fringilla mauris. Integer pellentesque ultricies auctor. Aenean eget risus sed ligula dapibus pellentesque vel euismod nisi. Aenean volutpat magna ut justo vehicula ultricies volutpat sem malesuada. Nullam egestas pulvinar rhoncus. Vivamus eget tellus turpis. Etiam faucibus, lorem et suscipit cursus, nunc eros viverra nulla, at tristique urna leo vel lorem. Nullam ipsum tortor, laoreet in semper nec, pulvinar in mauris.</p>',100,30,'2011-07-24 09:00:00','2011-07-27 18:00:00',now(),now()),
('Kids day','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent molestie nisi non tellus ornare rhoncus. Nam fermentum purus ut massa fermentum rutrum. Curabitur pretium neque quis est facilisis pulvinar. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam eget enim orci. Donec massa mauris, elementum sed suscipit vel, vestibulum sit amet dolor. Etiam pellentesque justo at nisl hendrerit vulputate. Sed imperdiet, mauris eget vulputate consectetur, ligula mauris mollis justo, nec tincidunt arcu nunc et neque. Sed cursus, dolor vitae fermentum consectetur, urna nisl volutpat metus, mollis pellentesque purus risus non lacus. Ut nec lectus dapibus mi venenatis blandit. Cras eros diam, gravida at vulputate quis, tincidunt et mi. Phasellus hendrerit placerat tellus sed mattis. Proin eget ligula congue magna accumsan ultrices. Cras vitae magna non nibh dapibus euismod eget id est. Vivamus turpis erat, aliquam ut varius id, porttitor eu massa. Nullam condimentum condimentum tempus. Morbi mattis libero felis.</p>',200,null,'2011-08-05 12:00:00','2011-08-05 18:00:00',now(),now());

INSERT INTO club_user_location (location_name,location_id) VALUES
  ('Denmark',1),
  ('Aalborg',2),
  ('Copenhagen',2),
  ('Aalborg Tennis Club',3),
  ('Gug Tennis Club',3);

INSERT INTO club_user_group (group_id,group_name,group_type,gender,min_age,max_age,is_active_member) VALUES
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

INSERT INTO club_shop_product (id,product_name,description,price,vat_id) VALUES
  (1,'1. md, subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',100,1),
  (2,'2. md, subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',175,1),
  (3,'Period subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',1000,1),
  (4,'Lifetime membership','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',5000,1),
  (5,'10 clip','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',100,1),
  (6,'20 clip','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',175,1),
  (7,'Tennis Balls','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',50,1),
  (8,'Club T-shirt','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',200,1),
  (9,'Easter subscription','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique est eu nulla iaculis ac sodales lorem accumsan. Nulla aliquam hendrerit mollis. Aliquam erat volutpat. Vestibulum metus est, volutpat eu condimentum id, vulputate sed lectus. Ut luctus laoreet rhoncus. Cras mattis hendrerit dignissim. Integer neque eros, pellentesque luctus tristique quis, tincidunt non libero. Vestibulum scelerisque, magna ac posuere dapibus, elit ligula viverra magna, vitae convallis purus quam a orci. Donec fermentum convallis molestie. Etiam leo augue, sollicitudin vel tristique vestibulum, iaculis in purus. Mauris bibendum, nunc eu sollicitudin pharetra, augue lacus dictum risus, eget gravida velit leo vitae magna. Curabitur quis nisl at mi egestas ultricies.
Nunc facilisis hendrerit mi, non scelerisque enim vehicula sed. Donec viverra, dolor eget egestas aliquet, odio ante luctus odio, id consectetur elit mauris sit amet turpis. Phasellus ac lectus mi, eu vestibulum diam. Cras pulvinar, odio vehicula rhoncus sodales, arcu libero rutrum sem, ac lacinia nisl nibh et lorem. Donec metus mi, cursus ut accumsan a, varius id enim. Aliquam blandit aliquet mauris nec vestibulum. Aenean placerat tempor gravida. Proin id rhoncus justo. Praesent tincidunt elit ut sapien dapibus eu interdum arcu tincidunt. Fusce nec nunc risus. Curabitur sed nulla leo, quis tincidunt nulla. Nulla facilisi. Suspendisse cursus velit in massa bibendum molestie.
Praesent scelerisque aliquam purus, vitae accumsan erat bibendum ut. Curabitur accumsan vestibulum felis, lacinia tempus ligula interdum ac. Morbi vehicula varius diam quis tincidunt. Nulla bibendum laoreet dolor, a feugiat ligula convallis sit amet. Donec mattis quam et libero hendrerit faucibus. Quisque gravida tempus egestas. Curabitur dolor est, facilisis in posuere vitae, dictum nec enim. Cras nec orci ut eros dignissim porttitor vel sit amet urna. Nunc quis erat sit amet tortor tincidunt sagittis. In malesuada odio ac elit facilisis eu condimentum risus gravida. Morbi orci risus, rhoncus vitae mattis sit.',50,1),
  (10,'Subscription + 1Month + Renewal(A) + Location + Pauses','Lorem ipsum...',100,1),
  (11,'Subscription + 3Month + Renewal(A) + Start date','Lorem ipsum...',100,1),
  (12,'Subscription + 3Month + Start date + Expire date','Lorem ipsum...',100,1),
  (13,'Subscription + Lifetime','Lorem ipsum...',100,1),
  (14,'Subscription + Start date + Expire date + Renewal(Y)','Lorem ipsum...',100,1),
  (15,'10 tickets + Renewal(A) + Location + Pauses','Lorem ipsum...',100,1);

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
  (15,2);

INSERT INTO club_shop_product_attribute (product_id,attribute_id,value) VALUES
  (1,1,1),
  (1,7,3),
  (1,8,1),
  (2,1,2),
  (2,7,5),
  (2,8,5),
  (3,5,'2011-04-01'),
  (3,6,'2011-10-31'),
  (4,4,1),
  (5,2,10),
  (5,8,1),
  (6,2,20),
  (6,8,1),
  (9,5,'2011-04-16'),
  (9,6,'2011-04-30'),
  (10,1,1),
  (10,3,'A'),
  (10,8,1),
  (10,7,3),
  (11,1,3),
  (11,3,'A'),
  (11,5,'2011-09-01'),
  (12,1,3),
  (12,5,'2011-09-01'),
  (12,6,'2011-12-01'),
  (13,4,1),
  (14,5,'2011-09-01'),
  (14,6,'2011-12-01'),
  (14,3,'Y'),
  (15,2,10),
  (15,3,'A'),
  (15,8,1),
  (15,7,3);

INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('1','1','1','2011-07-02 09:50:15');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('6','1','1','2011-07-01 10:41:07');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('11','1','1','2011-07-04 22:38:55');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('16','1','1','2011-06-30 21:08:12');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('21','1','1','2011-06-30 16:09:47');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('26','1','1','2011-07-03 02:24:42');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('31','1','1','2011-07-02 00:19:04');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('36','1','1','2011-07-06 08:31:35');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('41','1','1','2011-06-30 12:09:13');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('46','1','1','2011-07-05 04:16:59');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('51','1','1','2011-07-05 03:36:45');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('56','1','1','2011-07-04 09:54:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('61','1','1','2011-07-04 19:29:57');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('66','1','1','2011-07-04 05:08:07');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('71','1','1','2011-07-02 17:13:25');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('76','1','1','2011-07-04 11:20:49');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('81','1','1','2011-06-30 23:30:02');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('86','1','1','2011-07-03 21:10:22');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('91','1','1','2011-07-04 17:21:36');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('96','1','1','2011-07-06 22:16:55');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('101','1','1','2011-07-03 12:46:48');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('106','1','1','2011-07-04 04:35:26');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('111','1','1','2011-07-01 19:34:22');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('116','1','1','2011-07-02 08:04:37');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('121','1','1','2011-07-03 04:32:17');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('126','1','1','2011-07-01 00:49:51');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('131','1','1','2011-07-02 09:52:40');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('136','1','1','2011-07-02 08:26:34');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('141','1','1','2011-07-03 12:43:54');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('146','1','1','2011-07-06 06:59:30');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('151','1','1','2011-07-01 18:00:29');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('156','1','1','2011-06-30 14:20:18');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('161','1','1','2011-07-01 05:27:49');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('166','1','1','2011-07-03 16:52:54');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('171','1','1','2011-07-04 06:01:57');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('176','1','1','2011-07-06 18:56:49');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('181','1','1','2011-06-30 06:36:01');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('186','1','1','2011-07-02 11:52:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('191','1','1','2011-06-30 09:17:18');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('196','1','1','2011-07-05 10:27:26');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('201','1','1','2011-07-01 20:53:56');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('206','1','1','2011-06-30 13:30:25');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('211','1','1','2011-07-03 19:44:13');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('216','1','1','2011-07-02 06:40:56');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('221','1','1','2011-07-06 23:28:36');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('226','1','1','2011-07-05 02:46:50');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('231','1','1','2011-07-03 01:26:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('236','1','1','2011-06-30 11:18:09');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('241','1','1','2011-07-06 02:20:39');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('246','1','1','2011-07-02 03:36:01');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('251','1','1','2011-07-04 00:05:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('256','1','1','2011-06-30 15:31:22');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('261','1','1','2011-06-30 13:14:14');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('266','1','1','2011-07-03 08:56:14');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('271','1','1','2011-07-03 21:35:29');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('276','1','1','2011-07-05 15:37:55');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('281','1','1','2011-07-01 01:16:50');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('286','1','1','2011-07-04 13:57:32');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('291','1','1','2011-07-03 09:40:08');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('296','1','1','2011-06-30 14:43:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('301','1','1','2011-06-30 09:10:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('306','1','1','2011-07-06 10:11:04');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('311','1','1','2011-07-06 01:37:41');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('316','1','1','2011-07-06 06:21:20');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('321','1','1','2011-07-02 03:12:10');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('326','1','1','2011-07-06 06:35:56');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('331','1','1','2011-06-30 21:00:44');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('336','1','1','2011-07-04 09:30:45');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('341','1','1','2011-07-05 23:39:50');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('346','1','1','2011-07-03 13:02:17');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('351','1','1','2011-07-03 16:15:52');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('356','1','1','2011-07-02 12:09:29');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('361','1','1','2011-07-05 17:56:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('366','1','1','2011-07-05 23:20:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('371','1','1','2011-07-01 23:39:56');

INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('2','2','1','2011-07-05 01:44:12');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('6','2','1','2011-07-04 02:29:50');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('10','2','0','2011-07-02 08:25:13');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('14','2','1','2011-07-06 19:03:29');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('18','2','1','2011-07-02 04:35:53');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('22','2','1','2011-06-30 21:56:55');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('26','2','0','2011-06-30 09:33:14');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('30','2','0','2011-07-01 17:20:45');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('34','2','0','2011-07-02 16:52:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('38','2','1','2011-06-30 14:39:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('42','2','0','2011-07-03 02:13:47');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('46','2','1','2011-07-06 02:39:28');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('50','2','1','2011-07-05 09:08:51');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('54','2','0','2011-07-03 18:13:19');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('58','2','0','2011-06-30 09:39:06');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('62','2','0','2011-07-02 20:15:27');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('66','2','1','2011-07-01 01:54:21');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('70','2','1','2011-07-06 17:14:09');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('74','2','0','2011-07-05 12:06:16');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('78','2','0','2011-07-06 23:01:33');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('82','2','0','2011-07-02 02:23:56');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('86','2','1','2011-07-04 17:58:13');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('90','2','1','2011-07-06 14:33:33');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('94','2','0','2011-07-02 19:44:39');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('98','2','1','2011-07-02 00:13:41');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('102','2','1','2011-07-06 07:25:23');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('106','2','0','2011-07-05 09:51:32');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('110','2','0','2011-07-02 00:27:18');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('114','2','0','2011-07-02 08:52:23');
INSERT INTO `club_event_attend` (`user_id`,`event_id`,`paid`,`created_at`) VALUES ('118','2','1','2011-07-02 16:26:31');
