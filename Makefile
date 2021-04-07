db-test:
		php bin/console doctrine:database:drop --if-exists --force --env=test
		php bin/console doctrine:database:create --env=test
		php bin/console doctrine:schema:update --force --env=test
		php bin/console doctrine:fixtures:load -n --env=test

test:
		bin/phpunit
		vendor/bin/behat