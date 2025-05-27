<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Sequence
{
    public static function display(): CsiSequence
    {
        return CsiSequence::selectGraphicRendition();
    }
}
