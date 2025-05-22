<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Closure;

final class Collection extends Element
{
    public function __construct(
        private Element $element,
        private Validable $prompt,
        private Closure $predicate,
    ) {
        parent::__construct(
            output: $element->output(),
        );

        $this->value = [];
    }

    public function render(): static
    {
        $this->element->render();

        $this->value[] = $this->element->value();

        if (($this->predicate)($this->prompt->render()->value())) {
            $this->render();
        }

        return $this;
    }
}
