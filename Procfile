web: vendor/bin/heroku-php-apache2 public/
release: composer dump-autoload;php artisan optimize:clear;php artisan migrate:fresh --force --seed
