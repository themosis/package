<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

use Closure;

final class Validator
{
    public function __construct(
        Closure $rule,
    ) {}
    
    public function validate(callable $element): mixed
    {
        return null;
    }
}
