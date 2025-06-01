<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Prompt extends Element
{
    protected string $value;

    public function __construct(
        protected Element $element,
        private Input $input,
    ) {
        parent::__construct($element->output());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function render(): static
    {
        $this->element->render();
        $this->value = $this->input->read();

        return $this;
    }
}
