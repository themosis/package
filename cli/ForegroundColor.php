<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class ForegroundColor implements Style
{
    public function __construct(
        private Color $color,
    ) {}

    public function definition(): string
    {
        return "";
    }
}
