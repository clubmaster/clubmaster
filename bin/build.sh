#!/bin/sh

VERSION=`cat src/Club/UserBundle/Helper/Version.php  | grep "protected $version" | cut -d"'" -f2 | cut -d"-" -f1`
BUILD_PATH=/tmp/clubmaster_${VERSION}

if [ -d "${BUILD_PATH}" ]; then
  rm -rf ${BUILD_PATH}
fi

touch app/installer
./bin/remake_schema.sh
phpunit -c app

if [ $? -ne 0 ]; then
  exit
fi

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
SQL_DUMP_FILE=`mktemp`
chmod 644 ${SQL_DUMP_FILE}
mysqldump -u root clubmaster > ${SQL_DUMP_FILE}

mkdir ${BUILD_PATH}

TRUNK_PATH=`pwd`

cp -r ${TRUNK_PATH}/* ${BUILD_PATH}
cp bin/install.sh ${BUILD_PATH}

rm -rf ${BUILD_PATH}/bin
rm -rf ${BUILD_PATH}/deps
rm -rf ${BUILD_PATH}/app/cache/*
rm -rf ${BUILD_PATH}/app/logs/*
rm -rf ${BUILD_PATH}/app/spool/.*.message
rm -rf ${BUILD_PATH}/app/sql/*
rm -rf ${BUILD_PATH}/deps.lock
rm -rf ${BUILD_PATH}/app/phpunit.xml.dist
rm -rf ${BUILD_PATH}/web/index_dev.php

cp ${SQL_DUMP_FILE} ${BUILD_PATH}/app/sql/install.sql

rm ${SQL_DUMP_FILE}
find ${BUILD_PATH} -name .git | xargs rm -rf
find ${BUILD_PATH} -name .gitkeep | xargs rm -rf
find ${BUILD_PATH} -name .gitignore | xargs rm -rf

touch ${BUILD_PATH}/app/installer

cat > ${BUILD_PATH}/app/config/parameters.ini <<EOF
[parameters]
    database_driver   = pdo_mysql
    database_host     = localhost
    database_port     =
    database_name     = clubmaster
    database_user     = root
    database_password =
    mailer_transport  = sendmail
    mailer_host       =
    mailer_user       =
    mailer_password   =
    locale            = en
    secret            = ChangeMeToSomethingRandom
EOF

cd /tmp
tar czf clubmaster_${VERSION}.tgz clubmaster_${VERSION}

rm -f app/installer
rm -rf ${BUILD_PATH}
