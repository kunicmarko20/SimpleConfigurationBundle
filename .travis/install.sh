#!/usr/bin/env sh
set -ev

mkdir --parents "${HOME}/bin"

composer global require "squizlabs/php_codesniffer"

wget "https://phar.phpunit.de/phpunit-5.7.phar" --output-document="${HOME}/bin/phpunit"
chmod u+x "${HOME}/bin/phpunit"

# Coveralls client install
wget https://github.com/satooshi/php-coveralls/releases/download/v1.0.1/coveralls.phar --output-document="${HOME}/bin/coveralls"
chmod u+x "${HOME}/bin/coveralls"

if [ "$SYMFONY" != "" ]; then composer require "symfony/symfony:$SYMFONY" --no-update; fi;
composer install --dev --prefer-dist
