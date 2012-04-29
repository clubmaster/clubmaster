#!/bin/bash

touch app/installer

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
phpunit -c app/installunit.xml
php app/console assets:install web

MYSQL_PASSWORD="Ig5IiAu9"
MYSQL_DATABASE=clubmaster_dev

if [ "${MYSQL_PASSWORD}" != "" ]; then
  MYSQL_PASSWORD="-p"${MYSQL_PASSWORD}
fi

mysql -u root ${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/test_data.sql
mysql -u root ${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/event_data.sql
mysql -u root ${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/test_fields.sql

phpunit -c app/ src/Club/TeamBundle/Tests/Controller/0AdminTeamControllerTest.php
phpunit -c app/ src/Club/TeamBundle/Tests/Controller/1AdminScheduleControllerTest.php
phpunit -c app/ src/Club/ShopBundle/Tests/Controller/AdminCouponControllerTest.php
phpunit -c app/ src/Club/ShopBundle/Tests/Controller/CheckoutControllerTest.php

sudo chmod 777 -R app/logs app/cache
sudo chown www-data:www-data app/cache app/logs
