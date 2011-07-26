#!/bin/bash

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
php app/console assets:install web

echo "Now you will be prompted for your MySQL password 3 times, in order to insert test data:"
mysql -u root -p clubmaster < app/sql/test_data.sql
mysql -u root -p clubmaster < app/sql/users_data.sql
mysql -u root -p clubmaster < app/sql/event_data.sql

php app/console cache:warmup

sudo chmod 777 -R app/logs app/cache app/spool
sudo chown www-data:www-data app/cache app/logs
