<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class BackgroundColor implements Style
{
    public function __construct(
        private Color $color,
    ) {}

    public function definition(): string
    {
        return $this->color->value(Layer::Background);
    }
}
