<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class BackgroundColor implements Node
{
    public function __construct(
        private Color $color,
    ) {}

    public function content(): string
    {
        return $this->color->value(Layer::Background);
    }
}
