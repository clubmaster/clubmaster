#!/bin/bash

if [ -z $1 ]; then
  echo "You has to parse UserId as an argument."
  exit
fi

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/ban/user/$1
