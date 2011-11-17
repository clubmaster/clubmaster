#!/bin/bash

phpunit -c app/phpunit.xml.dist
phpunit -c app/apiunit.xml
