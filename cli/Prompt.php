<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Prompt
{
    public function __construct(
        private Output $output,
        private Input $input,
    ) {}

    public function call(): string
    {
        $this->output->write();

        return $this->input->read();
    }

    public function __invoke(): string
    {
        return $this->call();
    }
}
