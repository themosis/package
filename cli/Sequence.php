<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Sequence
{
    public static function make(): CsiSequence
    {
        return CsiSequence::selectGraphicRendition();
    }
}
