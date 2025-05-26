<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Reversed implements Node
{
    public function content(): string
    {
        $unicodeEscape = "\u{001b}";

        return "{$unicodeEscape}[7m";
    }
}
