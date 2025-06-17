<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Prompts;

use Themosis\Components\Package\Configurator\Stages\Stage;

abstract class Component
{
    protected ?Stage $director = null;

    public function withDirector(Stage $director): static
    {
        $this->director = $director;
        
        return $this;
    }
}
