#!/usr/bin/env bash

systemctl start nginx.service
systemctl start php-fpm.service

if [ $# -eq 0 ]; then
    /bin/bash
fi
