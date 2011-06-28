INSERT INTO club_user_location (location_name,currency_id,location_id) VALUES
  ('Denmark',1,null),
  ('Aalborg',1,1),
  ('Copenhagen',1,1),
  ('Aalborg Tennis Club',1,2),
  ('Gug Tennis Club',1,2);

INSERT INTO club_user_location_config (location_id,config_id,value) VALUES
  (1,1,'localhost'),
  (2,1,'localhost'),
  (3,1,'localhost'),
  (4,1,'localhost'),
  (5,1,'localhost'),
  (1,2,25),
  (2,2,25),
  (3,2,25),
  (4,2,25),
  (5,2,25),
  (1,3,null),
  (2,3,null),
  (3,3,null),
  (4,3,null),
  (5,3,null),
  (1,4,null),
  (2,4,null),
  (3,4,null),
  (4,4,null),
  (5,4,null),
  (1,5,'5001'),
  (2,5,'5001'),
  (3,5,'5001'),
  (4,5,'5001'),
  (5,5,'5001'),
  (1,6,'3001'),
  (2,6,'3001'),
  (3,6,'3001'),
  (4,6,'3001'),
  (5,6,'3001'),
  (1,7,'en_UK'),
  (2,7,'en_UK'),
  (3,7,'en_UK'),
  (4,7,'en_UK'),
  (5,7,'en_UK');

INSERT INTO club_user_group (group_id,group_name,group_type,gender,min_age,max_age,is_active_member) VALUES
  (null,'Senior','dynamic',null,18,45,1),
  (null,'Junior','dynamic',null,0,17,1),
  (null,'Members of honor','static',null,null,null,1),
  (null,'DK - Members','dynamic',null,null,null,1),
  (null,'All Members','dynamic',null,null,null,0);

INSERT INTO club_group_location (group_id,location_id) VALUES
  (4,1);

INSERT INTO club_shop_category (id,category_id,category_name,description,location_id) VALUES
  (1,null,'Subscriptions','Subscriptions',1),
  (2,null,'Ticket coupon','Ticket coupon',1),
  (3,null,'Food','Food',1),
  (4,null,'Liquid','Liquid',1),
  (5,null,'Sport equipment','Sport equipment',1),
  (6,null,'Other','Other',1),
  (7,5,'Bags','Bags',1),
  (8,5,'Rackets','Rackets',1);

INSERT INTO club_shop_product (id,product_name,description,price,vat_id) VALUES
  (1,'1. md, subscription','1. md, subscription',100,1),
  (2,'2. md, subscription','2. md, subscription',175,1),
  (3,'Period subscription','Period subscription',1000,1),
  (4,'Lifetime membership','Lifetime membership',5000,1),
  (5,'10 clip','10 clip',100,1),
  (6,'20 clip','20 clip',175,1),
  (7,'Tennis Balls','Tennis Balls',50,1),
  (8,'Club T-shirt','Club T-shirt',200,1),
  (9,'Easter subscription','Easter subscription',50,1);

INSERT INTO club_shop_category_product (product_id,category_id) VALUES
  (1,1),
  (2,1),
  (3,1),
  (4,1),
  (5,2),
  (6,2),
  (7,5),
  (8,6),
  (9,1);

INSERT INTO club_shop_variant_group (variant_group_name) VALUES
  ('Color'),
  ('Size');

INSERT INTO club_shop_variant_value (variant_group_id,value) VALUES
  (1,'Green'),
  (1,'Orange'),
  (1,'Yellow'),
  (2,'Small'),
  (2,'Medium'),
  (2,'Large'),
  (2,'XLarge');

INSERT INTO product_variantgroup (product_id,variantgroup_id) VALUES
  (8,1),
  (9,2);

INSERT INTO club_shop_product_attribute (product_id,attribute_id,value) VALUES
  (1,1,1),
  (1,7,3),
  (1,8,1),
  (1,5,'2011-06-01'),
  (2,1,2),
  (2,7,5),
  (2,8,1),
  (3,5,'2011-04-01'),
  (3,6,'2011-10-31'),
  (4,4,1),
  (5,2,10),
  (5,8,1),
  (6,2,20),
  (6,8,1),
  (9,5,'2011-04-16'),
  (9,6,'2011-04-30');
