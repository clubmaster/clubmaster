#!/bin/bash

VERSION=`cat src/Club/UserBundle/Helper/Version.php  | grep "protected $version" | cut -d"'" -f2 | cut -d"-" -f1`
BUILD_PATH=/tmp/clubmaster_${VERSION}

if [ -d "${BUILD_PATH}" ]; then
  rm -rf ${BUILD_PATH}
fi

echo -n "Run unit tests (YES|no)"
read a

if [ "$a" == "no" ]; then
    unittest=0
else
    unittest=1
fi

if [ ${unittest} -eq 1 ]; then
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
    echo "Tests was good"
fi

echo "Starting to build package."
mkdir ${BUILD_PATH}

php app/console assetic:dump

TRUNK_PATH=`pwd`

cp -r ${TRUNK_PATH}/* ${BUILD_PATH}

sed -i 's/\-dev//' ${BUILD_PATH}/src/Club/UserBundle/Helper/Version.php
rm -rf ${BUILD_PATH}/bin
rm -rf ${BUILD_PATH}/app/sql
rm -rf ${BUILD_PATH}/app/cache/*
rm -rf ${BUILD_PATH}/app/logs/*
rm -rf ${BUILD_PATH}/app/sessions/*
rm -rf ${BUILD_PATH}/composer.*
rm -rf ${BUILD_PATH}/app/phpunit.xml.dist
rm -rf ${BUILD_PATH}/web/uploads/*

find ${BUILD_PATH} -name .git | xargs rm -rf
find ${BUILD_PATH} -name .gitkeep | xargs rm -rf
find ${BUILD_PATH} -name .gitignore | xargs rm -rf

touch ${BUILD_PATH}/app/installer

cat > ${BUILD_PATH}/app/config/parameters.yml <<EOF
parameters:
    database_driver:   pdo_mysql
    database_host:     localhost
    database_port:     ~
    database_name:     clubmaster
    database_user:     root
    database_password: ~

    mailer_transport:  smtp
    mailer_host:       localhost
    mailer_user:       ~
    mailer_password:   ~

    locale:            en
    secret:            ThisTokenIsNotSoSecretChangeIt
EOF

cd /tmp
tar czf clubmaster_${VERSION}.tgz clubmaster_${VERSION}

rm -rf app/installer
rm -rf ${BUILD_PATH}
