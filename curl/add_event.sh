#!/bin/bash

DATE=`date +"%Y-%m-%d" --date="5 day ago"`
curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/event \
  -d "event_name=Tournament&description=Senior Tournament&start_date=${DATE} 10:00:00&stop_date=${DATE} 19:00:00"

DATE=`date +"%Y-%m-%d" --date="5 day"`
curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/event \
  -d "event_name=BBQ party&description=BBQ Party&start_date=${DATE} 19:00:00&stop_date=${DATE} 23:00:00"

DATE=`date +"%Y-%m-%d" --date="15 day"`
curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/event \
  -d "event_name=Junior Tournament&description=Junior Tournament&start_date=${DATE} 12:00:00&stop_date=${DATE} 17:00:00"
