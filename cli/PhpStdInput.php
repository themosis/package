<?php

declare(strict_types=1);

namespace Themosis\Cli;

use InvalidArgumentException;

final class PhpStdInput implements Input
{
    public function read(): string
    {
	$value = fgets(STDIN);

	if (false === $value) {
            throw new InvalidArgumentException('Invalid input content.');
	}
	
        return trim($value);
    }
}
