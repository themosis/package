<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Reset implements Node
{
    public function content(): string
    {
        return "\u001b[0m";
    }
}
