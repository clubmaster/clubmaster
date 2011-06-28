#!/bin/bash

for name in $(cat curl/names.csv); do
  firstname=`echo ${name} | cut -d"," -f1`
  lastname=`echo ${name} | cut -d"," -f2`
  gender=`echo ${name} | cut -d"," -f3`
  day_of_birth=`echo ${name} | cut -d"," -f4`

  curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/user \
    -d "first_name=${firstname}&last_name=${lastname}&gender=${gender}&day_of_birth=${day_of_birth}&street=Vesterbro 115&postal_code=9000&city=Aalborg&country=Denmark"
done
