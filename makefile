SHELL=/bin/sh

.PHONY: test coverage

test:
	php tools/phpunit12/vendor/bin/phpunit --configuration cli/phpunit.xml

coverage:
	XDEBUG_MODE=coverage php tools/phpunit12/vendor/bin/phpunit --configuration cli/phpunit.xml --coverage-html cli/coverage/html
