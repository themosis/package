<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class LineFeed implements Node
{
    public function content(): string
    {
        return "\u{000a}";
    }
}
