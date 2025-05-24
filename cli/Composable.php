<?php

declare(strict_types=1);

namespace Themosis\Cli;

use RuntimeException;

final class Composable extends Element
{
    /** @var Element[] */
    private array $children = [];

    public function __construct(
        private Element $element,
    ) {
        parent::__construct(
            output: $element->output(),
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
        $value = [];

        $this->element->render();

        $value['parent'] = $this->element->value();

        foreach ($this->children as $name => $child) {
            $child->render();
            $value[$name] = $child->value();
        }

        $this->value = $value;

        return $this;
    }
}
