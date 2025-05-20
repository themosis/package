<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Prompt extends Element
{
    public function render(Sequence $sequence): static
    {
        $this->output->write($sequence->content());
        $this->value = $this->input->read();

        return $this;
    }
}
