<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class PhpStdOutput implements Output
{
    public function __construct(
        private string $content,
    ) {}

    public function write(): void
    {
        fwrite(STDOUT, $this->content);
    }
}
