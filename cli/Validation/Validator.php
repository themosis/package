<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

interface Validator
{
    /**
     * @param null|string|array<mixed> $value
     * @return null|string|array<mixed>
     */
    public function validate(null|string|array $value): null|string|array;
}
