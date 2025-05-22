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
    ) {
        parent::__construct(
            output: $element->output,
        );
    }

    public function render(): static
    {
        try {
            $this->element->render();

            $this->value = $this
                ->validator
                ->validate($this->element->value());
        } catch (ValidationException $exception) {
            $this->output->write($exception->getMessage());
            $this->render();
        }

        return $this;
    }
}
