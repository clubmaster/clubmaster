#!/bin/bash

rm src/Club/UserBundle/Entity/*
rm src/Club/MailBundle/Entity/*
rm src/Club/ShopBundle/Entity/*

php app/console doctrine:generate:entities ClubUser
php app/console doctrine:generate:entities ClubMail
php app/console doctrine:generate:entities ClubShop

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
