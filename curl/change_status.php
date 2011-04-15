#!/bin/bash

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=1&status=2"

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=2&status=2"

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=3&status=2"

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=1&status=4"

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=2&status=4"

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/update/order \
  -d "order=3&status=4"
