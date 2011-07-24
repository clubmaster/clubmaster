#!/bin/sh

VERSION=`cat src/Club/UserBundle/Helper/Version.php  | grep "protected $version" | cut -d"'" -f2`
BUILD_PATH=/tmp/clubmaster_${VERSION}

if [ -d "${BUILD_PATH}" ]; then
  rm -rf ${BUILD_PATH}
fi

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
mysqldump -u root clubmaster_v2 > src/Club/Docs/sql/install.sql
sed -i 's/clubmaster_v2/clubmaster/' src/Club/Docs/sql/install.sql

mkdir ${BUILD_PATH}

TRUNK_PATH=`pwd`

cp -r ${TRUNK_PATH} ${BUILD_PATH}
cp src/Club/Docs/README ${BUILD_PATH}
cp bin/install.sh ${BUILD_PATH}

rm -rf ${BUILD_PATH}/bin
rm -rf ${BUILD_PATH}/deps
rm -rf ${BUILD_PATH}/deps.lock
rm -rf ${BUILD_PATH}/app/cache/*
rm -rf ${BUILD_PATH}/app/phpunit.xml.dist
rm -rf ${BUILD_PATH}/app/logs/*
rm -rf ${BUILD_PATH}/web/index_dev.php
rm -rf ${BUILD_PATH}/src/Club/fixtures.sql
rm -rf ${BUILD_PATH}/src/Club/users_data.sql
rm -rf ${BUILD_PATH}/src/Club/build.sh
rm -rf ${BUILD_PATH}/src/Club/TODO.txt
rm -rf ${BUILD_PATH}/src/Club/remake_schema.sh

find ${BUILD_PATH} -name .git | xargs rm -rf
find ${BUILD_PATH} -name .gitkeep | xargs rm -rf
find ${BUILD_PATH} -name .gitignore | xargs rm -rf

touch ${BUILD_PATH}/app/installer

mkdir ${BUILD_PATH}/app/sql
cp src/Club/Docs/sql/install.sql ${BUILD_PATH}/app/sql

cat > ${BUILD_PATH}/app/config/parameters.ini <<EOF
[parameters]
    database_driver   = pdo_mysql
    database_host     = localhost
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

rm -rf ${BUILD_PATH}
