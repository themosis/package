<?php

declare(strict_types=1);

namespace Themosis\Cli;

interface Output
{
    public function write(string $content): void;
}
