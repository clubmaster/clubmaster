#!/bin/bash

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/user \
  -d "first_name=Michael Holm&last_name=Kristensen"
