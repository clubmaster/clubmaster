#!/bin/bash

cat app/config/parameters.yml | grep locale | grep en &> /dev/null
if [ "$?" !=  "0" ]; then
  echo "Installer is not on english"
  exit
fi

touch app/installer

sudo rm -rf app/cache/*
sudo chmod 777 app/logs app/cache

php app/console doctrine:database:drop --force
php app/console doctrine:database:create

phpunit -c app/installunit.xml

php app/console doctrine:schema:update --force
php app/console assets:install web

MYSQL_PASSWORD=""
MYSQL_DATABASE=clubmaster

if [ "${MYSQL_PASSWORD}" != "" ]; then
  MYSQL_PASSWORD="-p"${MYSQL_PASSWORD}
fi

mysql -u root ${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/test_data.sql

phpunit -c app/remakeunit.xml

sudo chmod 777 -R app/logs app/cache
sudo chown www-data:www-data app/cache app/logs

rm app/installer
mkdir -p web/uploads
chmod 777 -R web/uploads
