<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Underline implements Node
{
    public function content(): string
    {
        $unicodeEscape = "\u{001b}";

        return "{$unicodeEscape}[4m";
    }
}
