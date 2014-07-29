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

php app/console assets:install web
php app/console assetic:dump

MYSQL_USERNAME=`grep database_user app/config/parameters.yml | cut -d":" -f2 | sed "s/ //g"`
MYSQL_PASSWORD=`grep database_password app/config/parameters.yml | cut -d":" -f2 | sed "s/ //g"`
MYSQL_DATABASE=`grep database_name app/config/parameters.yml | cut -d":" -f2 | sed "s/ //g"`

if [ "${MYSQL_PASSWORD}" == "~" ]; then
  MYSQL_PASSWORD=""
fi

if [ "${MYSQL_PASSWORD}" != "" ]; then
  MYSQL_PASSWORD="-p"${MYSQL_PASSWORD}
fi

mysql -u ${MYSQL_USERNAME} ${MYSQL_PASSWORD} ${MYSQL_DATABASE} < app/sql/test_data.sql

phpunit -c app/remakeunit.xml

sudo chmod 777 -R app/logs app/cache
sudo chown www-data:www-data app/cache app/logs

rm app/installer
mkdir -p web/uploads
sudo chmod 777 -R web/uploads
