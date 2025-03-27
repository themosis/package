<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Prompt
{
    public function __construct(
        private Output $output,
        private Input $input,
    ) {}

    public function __invoke(string $content): string
    {
        $this->output->write($content);

        return $this->input->read();
    }
}
