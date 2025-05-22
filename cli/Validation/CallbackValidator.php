<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

use Closure;

final class CallbackValidator implements Validator
{
    public function __construct(
        private Closure $callback,
    ) {}

    public function validate(?string $value): ?string
    {
        return ($this->callback)($value);
    }
}
