#!/usr/bin/env bash
set -ex
 
echo -e "${BASIC_AUTH_USERNAME}:$(perl -le 'print crypt($ENV{"BASIC_AUTH_PASSWORD"}, rand(0xffffffff));')" > /app/.htpasswd
