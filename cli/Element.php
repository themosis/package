<?php

declare(strict_types=1);

namespace Themosis\Cli;

abstract class Element
{
    protected ?string $value = null;

    public function __construct(
        protected Output $output,
    ) {}

    abstract public function render(): static;

    public function output(): Output
    {
        return $this->output;
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
