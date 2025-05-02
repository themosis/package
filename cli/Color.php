<?php

declare(strict_types=1);

namespace Themosis\Cli;

interface Color
{
    public function value(Layer $layer): string;
}
