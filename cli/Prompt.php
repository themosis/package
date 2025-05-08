<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Themosis\Cli\Validation\ValidationException;
use Themosis\Cli\Validation\Validator;

final class Prompt
{
    public function __construct(
        private Output $output,
        private Input $input,
        private Validator $validator,
    ) {}

    public function call(string $question): string
    {
        $this->output->write($question);
        $result = $this->input->read();

        try {
            $this->validator->validate($result);
        } catch (ValidationException $exception) {
            $this->output->write($exception->getMessage());

            return $this->call($question);
        }

        return $result;
    }

    public function __invoke(string $question): string
    {
        return $this->call($question);
    }
}
