test:
	php tools/phpunit12/vendor/bin/phpunit cli/Tests/*Test.php --bootstrap cli/autoload.php

coverage:
	XDEBUG_MODE=coverage php tools/phpunit12/vendor/bin/phpunit cli/Tests/*Test.php --bootstrap cli/autoload.php --coverage-html cli/coverage/html
