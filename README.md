# Pulupalsta

* http://palsta.pulu.org/en
* http://palsta.pulu.org/en/about
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
