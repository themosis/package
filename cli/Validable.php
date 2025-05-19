<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Themosis\Cli\Validation\ValidationException;
use Themosis\Cli\Validation\Validator;

final class Validable extends Component
{
    private Validator $validator;

    private Output $output;

    public function __construct(
        Element $element,
        Validator $validator,
        Output $output,
    ) {
        $this->element = $element;
        $this->validator = $validator;
        $this->output = $output;
    }

    public function draw(): void
    {
        try {
            $this->element->draw();
            $this->validator->validate($this->element->value());
        } catch (ValidationException $exception) {
            $this->output->write($exception->getMessage());
            $this->draw();
        }
    }
}
