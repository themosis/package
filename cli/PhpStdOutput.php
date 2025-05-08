<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class PhpStdOutput implements Output
{
    public function write(string $content): void
    {
        fwrite(STDOUT, $content);
    }
}
