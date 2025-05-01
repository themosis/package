<?php

declare(strict_types=1);

use Themosis\Cli\Node;

final class Text implements Node
{
    public function __construct(
        private string $text,
    ) {}

    public function content(): string
    {
        return $this->text;
    }
}
