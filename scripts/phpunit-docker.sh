#!/usr/bin/env sh
set -eu

# Ensure database service is available for integration-style tests.
docker-compose up -d mysql

# Build runtime image from current source and execute test bootstrap + PHPUnit.
docker-compose build server
docker-compose run --rm server sh -lc "php noob.php -i --testdb && vendor/bin/phpunit --configuration phpunit.xml"
