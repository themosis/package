<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Text implements Code
{
    public function __construct(
        private string $text,
    ) {}

    public function get(): string
    {
        return $this->text;
    }

    public function __toString(): string
    {
        return $this->get();
    }
}
