UPDATE club_shop_product SET quantity='-1';
ALTER TABLE club_shop_product CHANGE quantity quantity INT NOT NULL;
ALTER TABLE club_user_profile_company CHANGE cvr vat VARCHAR(255) NOT NULL;
ALTER TABLE club_shop_cart_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL;
ALTER TABLE club_shop_order_address CHANGE cvr vat VARCHAR(255) DEFAULT NULL
