<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Closure;

final class Collection extends Element
{
    /**
     * @var array<mixed>
     */
    protected array $value = [];

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

    /**
     * @return array<mixed>
     */
    public function value(): array
    {
        return $this->value;
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
