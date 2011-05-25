#!/bin/bash

sudo chmod -R 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create

mysql -u root clubmaster_v2 < fixtures.sql

sh curl/add_user.sh
sh curl/add_order.sh
sh curl/change_status.php
sh curl/add_user_role.sh

echo ""

sudo chmod -R 777 app/logs app/cache
