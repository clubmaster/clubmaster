#!/bin/bash

./bin/remake_schema.sh
phpunit -c app/phpunit.xml.dist
phpunit -c app/apiunit.xml
