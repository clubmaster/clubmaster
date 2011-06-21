INSERT INTO club_user_filter (filter_name) VALUES
  ('All women'),
  ('All from Denmark');

INSERT INTO club_user_attribute (attribute_name) VALUES
  ('min_age'),
  ('max_age'),
  ('gender'),
  ('postal_code'),
  ('city'),
  ('country'),
  ('is_active'),
  ('has_ticket'),
  ('has_subscription'),
  ('location');

INSERT INTO club_user_filter_attribute (filter_id,attribute_id,value) VALUES
  (1,3,'female'),
  (2,6,1);

INSERT INTO club_task_task (task_name,enabled,locked,created_at,updated_at,last_run_at,next_run_at,task_interval,event) VALUES
  ('Update dynamic groups',1,0,NOW(),NOW(),NULL,'1970-01-01 00:00:00','+1 hour','onGroupTask'),
  ('Cleanup logs',1,0,NOW(),NOW(),NULL,'1970-01-01 00:00:00','+1 hour','onLogTask'),
  ('Renewal memberships',1,0,NOW(),NOW(),NULL,'1970-01-01 00:00:00','+1 hour','onAutoRenewalTask'),
  ('Cleanup login logs',1,0,NOW(),NOW(),NULL,'1970-01-01 00:00:00','+1 hour','onLoginAttemptTask');

INSERT INTO club_account_account (account_name,account_number,account_type) VALUES
  ('Cash In Bank','1010','asset'),
  ('VAT','3001','income'),
  ('Income','5001','income');

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

INSERT INTO club_user_role (role_name) VALUES
  ('ROLE_ADMIN');

INSERT INTO club_shop_vat (vat_name,rate) VALUES
  ('Vat free',0),
  ('Danish vat','25');

INSERT INTO club_shop_order_status (status_name,is_accepted,is_cancelled,priority) VALUES
  ('Pending',0,0,1),
  ('Processing',0,0,2),
  ('Preparing',0,0,3),
  ('Delivered',1,0,4),
  ('Cancelled',0,1,5);

INSERT INTO club_shop_shipping (shipping_name,description,price) VALUES
  ('Fri fragt','Fri fragt',0);

INSERT INTO club_user_language (name,code) VALUES
  ('English','en_UK'),
  ('Danish','da_DK');

INSERT INTO club_shop_payment_method (payment_method_name,page) VALUES
  ('Check / Money order','<p>Tillykke din order er blevet gennemført</p>'),
  ('Credit card','<p>Tillykke din order er blevet gennemført</p>'),
  ('Wire transfer','<p>Tillykke din order er blevet gennemført</p>');

INSERT INTO club_shop_category (id,category_id,category_name,description,location_id) VALUES
  (1,null,'Subscriptions','Subscriptions',1),
  (2,null,'Ticket coupon','Ticket coupon',1),
  (3,null,'Food','Food',1),
  (4,null,'Liquid','Liquid',1),
  (5,null,'Sport equipment','Sport equipment',1),
  (6,null,'Other','Other',1),
  (7,5,'Bags','Bags',1),
  (8,5,'Rackets','Rackets',1);

INSERT INTO club_shop_product (product_name,description,price,vat_id) VALUES
  ('1. md, subscription','1. md, subscription',100,2),
  ('2. md, subscription','2. md, subscription',175,2),
  ('Period subscription','Period subscription',1000,2),
  ('Lifetime membership','Lifetime membership',5000,2),
  ('10 clip','10 clip',100,2),
  ('20 clip','20 clip',175,2),
  ('Tennis Balls','Tennis Balls',50,2),
  ('Club T-shirt','Club T-shirt',200,2),
  ('Easter subscription','Easter subscription',50,2);

INSERT INTO club_shop_category_product (product_id,category_id) VALUES
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
  ('StartDate'),
  ('ExpireDate'),
  ('AllowedPauses'),
  ('Location');

INSERT INTO club_shop_product_attribute (product_id,attribute_id,value) VALUES
  (1,1,1),
  (1,7,3),
  (1,8,1),
  (1,5,'2011-06-01'),
  (2,1,2),
  (1,7,5),
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
