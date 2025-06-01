<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Message extends Element
{
    public function __construct(
        private Code $sequence,
        protected Output $output,
    ) {
        parent::__construct($output);
    }

    public function value(): null
    {
	return null;
    }

    public function render(): static
    {
        $this->output->write($this->sequence->get());

        return $this;
    }
}
