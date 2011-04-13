#!/bin/bash

curl http://localhost/clubmaster_v2/web/app_dev.php/rest/add/order \
  -d "order_memo=JegVilGerneBareBestille&payment_method=1&shipping=1&user=1&currency=1&products=1,2,3"
