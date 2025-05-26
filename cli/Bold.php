<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Bold implements Node
{
    /**
     * TODO: Update API to use Select Graphic Rendition (SGR) mechanism...
     * SGR is applicable to colors.
     */
    public function content(): string
    {
        $unicodeEscape = "\u{001b}";

        return "{$unicodeEscape}[1m";
    }
}
