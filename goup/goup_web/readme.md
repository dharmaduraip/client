# Installation

cp .env.example .env

composer install

mkdir -p storage/license

nano storage/license/{DOMAIN_NAME}.json

*Add the following text* 

{"accessKey": "123456"}

*Save and exit the editor*

sudo chmod -R 777 storage/

sudo chown -R www-data storage/

sudo chgrp -R www-data storage/

## Key Generate

php artisan key:generate

## Redis Installation

sudo apt update

sudo apt install redis-server

sudo nano /etc/redis/redis.conf

Change **supervised no** to **supervised systemd**

Change **maxmemory <bytes>** to **maxmemory 1536mb**

Change **maxmemory-policy noeviction** to **maxmemory-policy allkeys-random**

*Save and exit the editor*

sudo systemctl restart redis.service

## Base URL

Set Base URL of the api server in env

e.g: http://localhost:8001


Add VAPID_PUBLIC_KEY in env from API Server env file
