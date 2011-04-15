#!/bin/bash

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create

mysql -u root clubmaster_v2 < fixtures.sql

sh curl/add_user.sh
sh curl/add_order.sh
curl/change_status.php
