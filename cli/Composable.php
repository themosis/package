<?php

declare(strict_types=1);

namespace Themosis\Cli;

use RuntimeException;

final class Composable extends Element
{
    /** @var Element[] */
    private array $children = [];

    public function __construct(
        private Element $parent,
    ) {
        parent::__construct(
            output: $parent->output(),
        );
    }

    public function add(string $name, Element $child): static
    {
        if (isset($this->children[$name])) {
            throw new RuntimeException("Child element with name {$name} already declared.");
        }

        $this->children[] = $child;

        return $this;
    }

    public function render(): static
    {
        $this->parent->render();

        foreach ($this->children as $child) {
            $child->render();
        }

        return $this;
    }
}
