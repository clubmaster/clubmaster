#!/bin/bash

echo
php app/check.php

echo
echo "  ####################################################"
echo "  #                                                  #"
echo "  # A System check has just been processed, please   #"
echo "  # use a few seconds that you meet all the          #"
echo "  # requirements.                                    #"
echo "  #                                                  #"
echo "  ####################################################"
echo
echo "  Press a key to continue..."
read

echo
echo "  ####################################################"
echo "  #                                                  #"
echo "  # INFO: If you already have created the database,  #"
echo "  # you can add the parameter \"drop\" to the        #"
echo "  # script. The database will be dropped.            #"
echo "  #                                                  #"
echo "  ####################################################"
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
chmod -R 777 app/cache app/logs
