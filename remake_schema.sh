#!/bin/bash

#rm src/Club/UserBundle/Entity/*
#rm src/Club/MailBundle/Entity/*
#rm src/Club/ShopBundle/Entity/*

#php app/console doctrine:generate:entities ClubUserBundle
#php app/console doctrine:generate:entities ClubMailBundle
#php app/console doctrine:generate:entities ClubShopBundle

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create

mysql -u root clubmaster_v2 < fixtures.sql
