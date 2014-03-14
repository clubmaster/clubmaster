ALTER TABLE club_user_user ADD status TINYINT(1) NOT NULL;
ALTER TABLE club_shop_product ADD status INT NOT NULL
UPDATE club_shop_product SET status=1;
UPDATE club_user_user SET enabled=1, status=1;
