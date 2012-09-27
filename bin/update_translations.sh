#!/bin/bash

dirs=`ls src/Club/`

for d in $dirs; do

    echo ${d} | grep Bundle

    if [ $? -eq 0 ]; then
        mkdir -p src/Club/${d}/Resources/translations
        php app/console translation:update --output-format=xlf --force da Club${d}
    fi
done

mkdir -p src/Club/Payment/CashBundle/Resources/translations
php app/console translation:update --output-format=xlf --force da ClubPaymentCashBundle

