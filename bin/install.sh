#!/bin/bash

chmod -R 777 app/cache app/logs
echo
php app/check.php

echo
echo "****************************************************"
echo "*                                                  *"
echo "* INFO: If you already have created the database,  *"
echo "* you can add the parameter \"drop\" to the        *"
echo "* script. The database will be dropped.            *"
echo "*                                                  *"
echo "****************************************************"
echo
echo "  Press a key to continue..."
read

if [[ "$1" == drop ]]; then
  php app/console doctrine:database:drop --force
  sudo rm -rf app/cache/* app/logs/*
fi

php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load
chmod -R 777 app/cache app/logs web/uploads

echo
echo
echo "*********************************************************"
echo "*                                                       *"
echo "* ATTENTION:                                            *"
echo "*   Now you can progress with the online configuration. *"
echo "*   Open your browser and locate the file web/check.php *"
echo "*                                                       *"
echo "*********************************************************"
echo
