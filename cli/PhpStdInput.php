<?php

declare(strict_types=1);

namespace Themosis\Cli;

use InvalidArgumentException;
use Themosis\Cli\Validation\Validator;

final class PhpStdInput implements Input
{
    public function __construct(
        private ?Validator $validator = null,
    ) {}

    public function validate(): void
    {
        $this->validator?->validate();
    }

    public function read(): string
    {
        $input = fgets(STDIN);

        if (false === $input) {
            throw new InvalidArgumentException('Invalid input content.');
        }

        return $input;
    }
}
