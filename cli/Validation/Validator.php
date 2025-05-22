<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

interface Validator
{
    public function validate(?string $value): ?string;
}
