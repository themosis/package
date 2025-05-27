<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class LineFeed implements Code
{
    public function get(): string
    {
        return "\u{000a}";
    }

    public function __toString(): string
    {
        return $this->get();
    }
}
