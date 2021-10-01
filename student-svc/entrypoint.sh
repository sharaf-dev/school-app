#!/bin/bash

echo "sleep for 12 seconds"
sleep 12

php artisan db:create

php artisan migrate --seed

exec apache2-foreground
