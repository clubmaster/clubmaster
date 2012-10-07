#!/bin/sh

VERSION=`cat src/Club/UserBundle/Helper/Version.php  | grep "protected $version" | cut -d"'" -f2 | cut -d"-" -f1`
BUILD_PATH=/tmp/clubmaster_${VERSION}

if [ -d "${BUILD_PATH}" ]; then
  rm -rf ${BUILD_PATH}
fi

echo "Testing remake_schema"
./bin/remake_schema.sh
if [ $? -ne 0 ]; then
  exit
fi

echo "Testing all other"
phpunit -c app/phpunit.xml.dist
if [ $? -ne 0 ]; then
  exit
fi

echo "Testing API"
phpunit -c app/apiunit.xml
if [ $? -ne 0 ]; then
  exit
fi

php app/console assetic:dump

echo "Everything OK, continue to build package."
mkdir ${BUILD_PATH}

TRUNK_PATH=`pwd`

cp -r ${TRUNK_PATH}/* ${BUILD_PATH}

sed -i 's/\-dev//' ${BUILD_PATH}/src/Club/UserBundle/Helper/Version.php
rm -rf ${BUILD_PATH}/bin
rm -rf ${BUILD_PATH}/deps
rm -rf ${BUILD_PATH}/app/sql
rm -rf ${BUILD_PATH}/app/cache/*
rm -rf ${BUILD_PATH}/app/logs/*
rm -rf ${BUILD_PATH}/deps.lock
rm -rf ${BUILD_PATH}/app/phpunit.xml.dist
rm -rf ${BUILD_PATH}/web/uploads/*

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
    secret            = ThisTokenIsNotSoSecretChangeIt
EOF

cd /tmp
tar czf clubmaster_${VERSION}.tgz clubmaster_${VERSION}

rm -rf app/installer
rm -rf ${BUILD_PATH}
