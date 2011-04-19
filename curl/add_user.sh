#!/bin/bash

for name in $(cat curl/names.csv); do
  firstname=`echo ${name} | cut -d"," -f1`
  lastname=`echo ${name} | cut -d"," -f2`
  gender=`echo ${name} | cut -d"," -f3`

  curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/user \
    -d "first_name=${firstname}&last_name=${lastname}&gender=${gender}"
done
