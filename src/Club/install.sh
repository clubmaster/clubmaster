#!/bin/bash

echo
echo "  ####################################################"
echo "  #                                                  #"
echo "  # This script might require root access, depending #"
echo "  # on wheather the web user has written files in    #"
echo "  # the cache dir                                    #"
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
