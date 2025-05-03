<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Stringable;

final class Sequence implements Stringable, Node
{
    /** @var Node[] */
    private array $nodes = [];

    public function add(Node $node): static
    {
        $this->nodes[] = $node;

        return $this;
    }

    public function content(): string
    {
        return implode("", array_map(function (Node $node) {
            return $node->content();
        }, $this->nodes));
    }

    public function __toString(): string
    {
        return $this->content();
    }
}
