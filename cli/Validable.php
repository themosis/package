<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Themosis\Cli\Validation\ValidationException;
use Themosis\Cli\Validation\Validator;

final class Validable extends Element
{
    public function __construct(
        private Element $element,
        private Validator $validator,
    ) {}

    public function render(Sequence $sequence): static
    {
        try {
            $this->value = $this
                ->element
                ->render($sequence)
                ->value();

            $this
                ->validator
                ->validate($this->value);
        } catch (ValidationException $exception) {
            $this->element->output->write($exception->getMessage());
            $this->render($sequence);
        }

        return $this;
    }
}
