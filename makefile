SHELL=/bin/sh

COMMAND=php --version

OCI_IMAGE=php-dev
OCI_ENV=

RUN=podman run -it --rm $(OCI_ENV) -v "$$PWD":/app -w /app $(OCI_IMAGE)

.PHONY: analyze build-oci coverage install* php play test update*

build-oci:
	podman build -t $(OCI_IMAGE) .

install-phpunit:
	$(RUN) composer --working-dir=tools/phpunit install

update-phpunit:
	$(RUN) composer --working-dir=tools/phpunit update

install-phpstan:
	$(RUN) composer --working-dir=tools/phpstan install

update-phpstan:
	$(RUN) composer --working-dir=tools/phpstan update

install-phpcs:
	$(RUN) composer --working-dir=tools/phpcs install

update-phpcs:
	$(RUN) composer --working-dir=tools/phpcs update

install &: install-phpunit install-phpstan install-phpcs

update &: update-phpunit update-phpstan update-phpcs

test:
	$(RUN) php tools/phpunit/vendor/bin/phpunit --configuration cli/phpunit.xml

coverage: OCI_ENV=--env "XDEBUG_MODE=coverage"
coverage:
	$(RUN) php tools/phpunit/vendor/bin/phpunit --configuration cli/phpunit.xml --coverage-html cli/coverage/html

analyze:
	$(RUN) php tools/phpstan/vendor/bin/phpstan analyze -v -c cli/phpstan.neon cli

fix:
	$(RUN) php tools/phpcs/vendor/bin/phpcbf cli

sniff:
	$(RUN) php tools/phpcs/vendor/bin/phpcs cli

php:
	$(RUN) $(COMMAND)

play:
	$(RUN) php -f scripts/playground.php

