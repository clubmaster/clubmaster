ALTER TABLE club_user_user ADD status TINYINT(1) NOT NULL;
ALTER TABLE club_user_profile_company CHANGE cvr vat VARCHAR(255) NOT NULL;
ALTER TABLE club_shop_product ADD status INT NOT NULL, ADD priority INT NOT NULL, CHANGE quantity quantity INT NOT NULL;
ALTER TABLE club_shop_order_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL;
ALTER TABLE club_shop_cart_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL;
ALTER TABLE club_event_event ADD price NUMERIC(10, 2) NOT NULL;
ALTER TABLE club_booking_field ADD field_layout LONGTEXT DEFAULT NULL, ADD same_layout_every_day TINYINT(1) NOT NULL

UPDATE club_shop_product SET status=1;
UPDATE club_user_user SET enabled=1, status=1;
