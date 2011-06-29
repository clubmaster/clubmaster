#!/bin/sh

VERSION=`cat UserBundle/Helper/Version.php  | grep "protected $version" | cut -d"'" -f2`
BUILD_PATH=/tmp/${VERSION}

if [ -d "${BUILD_PATH}" ]; then
  rm -rf /tmp/${VERSION}
fi

mkdir ${BUILD_PATH}

TRUNK_PATH=`pwd`/../../

cp -r ${TRUNK_PATH} ${BUILD_PATH}
cp README ${BUILD_PATH}

rm -rf ${BUILD_PATH}/app/cache/*
rm -rf ${BUILD_PATH}/app/logs/*
rm -rf ${BUILD_PATH}/bin
rm -rf ${BUILD_PATH}/deps
rm -rf ${BUILD_PATH}/deps.lock

find ${BUILD_PATH} -name .git | xargs rm -rf
find ${BUILD_PATH} -name .gitkeep | xargs rm -rf
find ${BUILD_PATH} -name .gitignore | xargs rm -rf

cd /tmp
tar czf clubmaster_${VERSION}.tgz ${VERSION}
