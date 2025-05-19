<?php

declare(strict_types=1);

namespace Themosis\Cli;

interface Element
{
    public function draw(): void;

    public function value(): string;
}
