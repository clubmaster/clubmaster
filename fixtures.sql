INSERT INTO club_role (role_name) VALUES
  ('ROLE_ADMIN'),
  ('ROLE_USER');

INSERT INTO club_shop_tax (tax_name,rate) VALUES
  ('Tax free',0),
  ('Danish tax','25');

INSERT INTO club_shop_order_status (status_name) VALUES
  ('Pending'),
  ('Processing'),
  ('Preparing'),
  ('Delivered');

INSERT INTO club_shop_shipping (shipping_name,description,price) VALUES
  ('Fri fragt','Fri fragt',0);

INSERT INTO club_shop_category (id,category_id,category_name,description) VALUES
  (1,null,'Abonnementer','Abonnementer'),
  (2,null,'Klippekort','Klippekort'),
  (3,null,'Mad','Mad'),
  (4,null,'Drikke','Drikke'),
  (5,null,'Sportsudstyr','Sportsudstyr'),
  (6,null,'Andet','Andet'),
  (7,5,'Tasker','Tasker'),
  (8,5,'Ketcher','Ketcher');

INSERT INTO club_shop_payment_method (payment_method_name) VALUES
  ('Kontant'),
  ('Kredit kort'),
  ('Bankoverførsel');

INSERT INTO club_shop_product (product_name,description,price,tax_id) VALUES
  ('1 md.','1 md.',100,2),
  ('2 md.','2 md.',150,2),
  ('10 bolde','10 bolde',50,2);

INSERT INTO product_category (product_id,category_id) VALUES
  (1,1),
  (2,1),
  (3,5);

INSERT INTO club_shop_currency (currency_name,code,symbol_left,symbol_right,decimal_places,value) VALUES
  ('Danish Krone','DKK',null,'DK',2,1);

INSERT INTO club_language (name,code,locale,charset,date_format_short,date_format_long,time_format,text_direction,numeric_separator_decimal,numeric_separator_thousands,currency_id) VALUES
  ('Danish','da_DK','da_DK.UTF-8,da_DK,danish','utf-8','%d/%m/%Y','%A %d %B, %Y','%H:%i:%s','ltr',',','.',1);
