<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class ForegroundColor extends ColorPalette
{
    public function value(): string
    {
        return "38;5;{$this->color->value()}";
    }
}
