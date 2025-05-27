<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class BackgroundColor implements Attribute
{
    public function __construct(
        private Color $color,
    ) {}

    public function value(): string
    {
        return "48;5;{$this->color->value()}";
    }
}
