<?php

declare(strict_types=1);

namespace Themosis\Cli;

abstract class Element
{
    public function __construct(
        protected Output $output,
    ) {
    }

    abstract public function render(): static;

    public function output(): Output
    {
        return $this->output;
    }

    /**
     * @return null|string|array<mixed>
     */
    abstract public function value(): null|string|array;

    public function __invoke(): mixed
    {
        $this->render();

        return $this->value();
    }
}
