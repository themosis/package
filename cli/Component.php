<?php

declare(strict_types=1);

namespace Themosis\Cli;

abstract class Component implements Element
{
    public function __construct(
        protected Element $element,
    ){}

    public function draw(): void
    {
        $this->element->draw();
    }

    public function value(): string
    {
        return $this->element->value();
    }

    public function __invoke(): string
    {
        $this->draw();

        return $this->value();
    }
}
