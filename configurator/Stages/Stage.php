<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Stages;

use Themosis\Components\Package\Configurator\Prompts\Component;

interface Stage
{
    public function run(): void;

    public function componentChanged(Component $component): void;
}
