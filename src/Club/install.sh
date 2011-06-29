#!/bin/bash

if [[ "$1" == drop ]]; then
  php app/console doctrine:database:drop --force
  sudo rm -rf app/cache/* app/logs/*
fi

php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
chmod -R 777 app/cache app/logs
