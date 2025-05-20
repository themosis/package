<?php

declare(strict_types=1);

namespace Themosis\Cli;

abstract class Element
{
    protected ?string $value = null;

    public function __construct(
        protected Output $output,
        protected Input $input,
    ){}

    abstract public function render(Sequence $sequence): static;

    public function value(): ?string
    {
        return $this->value;
    }
}
