<?php

declare(strict_types=1);

namespace Themosis\Cli;

interface Input
{
    public function read(): string;
}
