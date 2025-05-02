<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Stringable;

final class Sequence implements Stringable, Node
{
    private array $nodes = [];

    public function add(Node $node): static
    {
        $this->nodes[] = $node;

        return $this;
    }

    public function content(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        return implode("", $this->nodes);
    }
}
