#!/bin/bash

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
php app/console assets:install web

MYSQL_PASSWORD=
MYSQL_DATABASE=clubmaster

mysql -u root -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/test_data.sql
mysql -u root -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/users_data.sql
mysql -u root -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/event_data.sql
mysql -u root -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/team_data.sql

php app/console cache:warmup

sudo chmod 777 -R app/logs app/cache
sudo chown www-data:www-data app/cache app/logs
