#!/bin/bash

php artisan db:create

php artisan migrate --seed

exec apache2-foreground
