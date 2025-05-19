<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Prompt implements Element
{
    private string $value = '';

    public function __construct(
        private Sequence $message,
        private Output $output,
        private Input $input,
    ) {}

    public function draw(): void
    {
        $this->output->write($this->message->content());
        $this->value = $this->input->read();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __invoke(): string
    {
        $this->draw();

        return $this->value();
    }
}
