#!/usr/bin/env bash

/etc/rc.d/init.d/php-fpm start
/etc/rc.d/init.d/nginx start

if [ $# -eq 0 ]; then
    /bin/bash
fi
