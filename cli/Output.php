<?php

namespace Themosis\Cli;

interface Output
{
    public function write(string $content): void;
}
