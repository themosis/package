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
        if ('parent' === $name) {
            throw new RuntimeException("Name {parent} is a reserved keyword.");
        }

        if (isset($this->children[$name])) {
            throw new RuntimeException("Child element with name {$name} already declared.");
        }

        $this->children[$name] = $child;

        return $this;
    }

    public function render(): static
    {
        $localValue = [];

        $this->parent->render();

        $localValue['parent'] = $this->parent->value;

        foreach ($this->children as $name => $child) {
            $child->render();
            $localValue[$name] = $child->value();
        }

        $this->value = $localValue;

        return $this;
    }
}
