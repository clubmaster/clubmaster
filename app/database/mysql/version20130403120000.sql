UPDATE club_shop_product SET quantity='-1';
ALTER TABLE club_user_profile_company CHANGE cvr vat VARCHAR(255) NOT NULL;
ALTER TABLE club_shop_cart_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL;
ALTER TABLE club_shop_product CHANGE quantity quantity INT NOT NULL;
ALTER TABLE club_shop_order_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL;
ALTER TABLE club_event_event ADD price VARCHAR(255) NOT NULL;
ALTER TABLE club_booking_field ADD field_layout LONGTEXT DEFAULT NULL, ADD same_layout_every_day TINYINT(1) NOT NULL;
ALTER TABLE club_shop_product ADD priority INT NOT NULL;
ALTER TABLE club_event_event CHANGE price price NUMERIC(10, 2) NOT NULL;

