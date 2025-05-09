<?php

declare(strict_types=1);

namespace Themosis\Cli;

use Themosis\Cli\Validation\ValidationException;
use Themosis\Cli\Validation\Validator;

final class Prompt
{
    /** @var string[] $values */
    private array $values = [];

    public function __construct(
        private Output $output,
        private Input $input,
        private Validator $validator,
    ) {}

    public function call(string $question, bool $iterate = false): string|array
    {
        $this->output->write($question);
        $result = $this->input->read();

        try {
            $this->validator->validate($result);
        } catch (ValidationException $exception) {
            $this->output->write($exception->getMessage());

            return $this->call($question);
        }

        $this->values[] = $result;

        if ($iterate) {
            $this->output->write("More? (y/n)\n");
            $response = $this->input->read();

            if (in_array(strtolower($response), ['y', 'yes'])) {
                return $this->call($question, $iterate);
            }
        }

        return $iterate ? $this->values : array_shift($this->values);
    }

    public function __invoke(string $question, bool $iterate = false): string|array
    {
        return $this->call($question, $iterate);
    }
}
