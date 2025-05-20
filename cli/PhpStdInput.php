<?php

declare(strict_types=1);

namespace Themosis\Cli;

use InvalidArgumentException;

final class PhpStdInput implements ·Input
{
    public function read(): string
    {
        $input = trim(fgets(STDIN));

        if (false === $input) {
            throw new InvalidArgumentException('Invalid input content.');
        }

        return $input;
    }
}
