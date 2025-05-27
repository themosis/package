<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Stringable;

interface Code extends Stringable
{
    public function get(): string;
}
