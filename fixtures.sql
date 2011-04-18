INSERT INTO club_role (role_name) VALUES
  ('ROLE_ADMIN'),
  ('ROLE_USER');

INSERT INTO club_shop_tax (tax_name,rate) VALUES
  ('Tax free',0),
  ('Danish tax','25');

INSERT INTO club_shop_order_status (status_name,is_complete) VALUES
  ('Pending',0),
  ('Processing',0),
  ('Preparing',0),
  ('Delivered',1);

INSERT INTO club_shop_shipping (shipping_name,description,price) VALUES
  ('Fri fragt','Fri fragt',0);

INSERT INTO club_shop_currency (currency_name,code,symbol_left,symbol_right,decimal_places,value) VALUES
  ('Danish Krone','DKK',null,'DK',2,1);

INSERT INTO club_language (name,code,locale,charset,date_format_short,date_format_long,time_format,text_direction,numeric_separator_decimal,numeric_separator_thousands,currency_id) VALUES
  ('Danish','da_DK','da_DK.UTF-8,da_DK,danish','utf-8','%d/%m/%Y','%A %d %B, %Y','%H:%i:%s','ltr',',','.',1);

INSERT INTO club_shop_payment_method (payment_method_name) VALUES
  ('Kontant'),
  ('Kredit kort'),
  ('Bankoverførsel');

INSERT INTO club_shop_category (id,category_id,category_name,description) VALUES
  (1,null,'Abonnementer','Abonnementer'),
  (2,null,'Klippekort','Klippekort'),
  (3,null,'Mad','Mad'),
  (4,null,'Drikke','Drikke'),
  (5,null,'Sportsudstyr','Sportsudstyr'),
  (6,null,'Andet','Andet'),
  (7,5,'Tasker','Tasker'),
  (8,5,'Ketcher','Ketcher');

INSERT INTO club_shop_product (product_name,description,price,tax_id) VALUES
  ('1. md, subscription','1. md, subscription',100,2),
  ('2. md, subscription','2. md, subscription',100,2),
  ('1. season subscription','1. season subscription',1000,2),
  ('2. seasons subscription','2. season subscription',1700,2),
  ('Lifetime membership','Lifetime membership',5000,2),
  ('10 clip','10 clip',100,2),
  ('20 clip','20 clip',175,2),
  ('Tennis Balls','Tennis Balls',50,2),
  ('Club t-shirt','Club t-shirt',200,2),
  ('Easter subscription','Easter subscription',50,2);

INSERT INTO product_category (product_id,category_id) VALUES
  (1,1),
  (2,1),
  (3,1),
  (4,1),
  (5,1),
  (6,2),
  (7,2),
  (8,5),
  (9,6);

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

INSERT INTO club_shop_attribute (attribute_name) VALUES
  ('Month'),
  ('Ticket'),
  ('AutoRenewal'),
  ('Lifetime'),
  ('Season'),
  ('StartDate'),
  ('ExpireDate'),
  ('AllowedPauses');

INSERT INTO club_shop_product_attribute (product_id,attribute_id,value) VALUES
  (1,1,1),
  (2,1,2),
  (3,5,1),
  (4,5,2),
  (5,4,1),
  (6,2,10),
  (7,2,20),
  (1,6,'2011-06-01'),
  (7,6,'2011-06-01'),
  (10,6,'2011-04-16'),
  (10,7,'2011-04-30');
