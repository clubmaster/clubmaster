#!/bin/bash

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console doctrine:fixtures:load

mysql -u root clubmaster_v2 < fixtures.sql

echo ""

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache
sudo chown www-data.www-data -R app/cache app/logs

sh curl/add_user.sh
sh curl/add_user_role.sh
sh curl/add_event.sh

sudo chmod 777 app/logs app/cache
