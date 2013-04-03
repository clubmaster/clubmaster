UPDATE club_shop_product SET quantity='-1';
ALTER TABLE club_shop_product CHANGE quantity quantity INT NOT NULL;
