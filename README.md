# Pulupalsta

* http://palsta.pulu.org/en
* http://dev.palsta.pulu.org/app_dev.php/fi
* https://github.com/lassiheikkinen/pulupalsta

## Requirements

* PHP 5.3.3
* PostgreSQL
* php app/check.php

## Installation

```
git clone https://github.com/lassiheikkinen/pulupalsta.git palsta.pulu.org
cd palsta.pulu.org
curl -sS https://getcomposer.org/installer | php
vim app/config/parameters.yml
php composer.phar install --no-dev --optimize-autoloader; php app/console cache:clear --env=prod --no-debug; php app/console assetic:dump --env=prod --no-debug
php app/console doctrine:schema:update --dump-sql
```

And add commands to cron.

## Debug

* Use app_dev.php like https://palsta.pulu.org/app_dev.php/fi/1-article-name
    * needs nginx:

````
location ~ ^/(app_dev|config)\.php(/|$) {
    auth_basic "Closed";
    auth_basic_user_file /etc/nginx/dev_htpasswd;

    include /etc/nginx/fastcgi.conf;
    fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    fastcgi_split_path_info ^(.+\.php)(/.*)$;
}
````

## Troubleshooting

### 1. Remember eval cache

````
rm -rf /tmp/palsta-evalized-cache/*
````

### Logs

Look at `var/logs/`, not just `app/logs/` or `/var/logs/nginx/palsta*`
