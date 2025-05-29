<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class BackgroundColor extends ColorPalette
{
    public function value(): string
    {
        return "48;5;{$this->color->value()}";
    }
}
