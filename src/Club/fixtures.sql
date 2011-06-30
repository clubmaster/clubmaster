INSERT INTO club_event_event (event_name, description, price, max_attends, start_date, stop_date, created_at, updated_at) VALUES
('BBQ Party','BBQ Party',null,null,'2011-07-12 12:00:00','2011-07-12 18:00:00',now(),now()),
('Senior Tournament','Senior Tournament',100,30,'2011-07-24 09:00:00','2011-07-27 18:00:00',now(),now()),
('Kids day','Kids day',200,null,'2011-08-05 12:00:00','2011-08-05 18:00:00',now(),now());

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
  (1,null,'Subscriptions','Subscriptions',2),
  (2,null,'Ticket coupon','Ticket coupon',2),
  (3,null,'Food','Food',2),
  (4,null,'Liquid','Liquid',2),
  (5,null,'Sport equipment','Sport equipment',2),
  (6,null,'Other','Other',2),
  (7,5,'Bags','Bags',2),
  (8,5,'Rackets','Rackets',2);

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
