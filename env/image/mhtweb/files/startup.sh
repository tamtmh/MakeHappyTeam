#!/bin/bash

#PHPUNIT
cd /var/www/html/app/Vendor
wget https://phar.phpunit.de/phpunit-5.7.27.phar -O phpunit.phar
chmod +x phpunit.phar

# Apacheの起動
/usr/sbin/httpd -D FOREGROUND
