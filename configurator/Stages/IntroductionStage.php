<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Stages;

use Themosis\Components\Package\Configurator\Prompts\Block;
use Themosis\Components\Package\Configurator\Prompts\Component;
use Themosis\Components\Package\Configurator\Prompts\ComponentFactory;
use Themosis\Components\Package\Configurator\Prompts\Paragraph;

final class IntroductionStage implements Stage
{
    private Block $title;

    private Paragraph $introduction;

    public function __construct(
        private ComponentFactory $factory,
    ) {
        $this->title = $factory
            ->block(' Themosis Package ')
            ->withDirector($this);

        $this->introduction = $factory
            ->paragraph('This tool will guide you through setting up your PHP package or application.')
            ->withDirector($this);
    }

    public function run(): void
    {
        $this->title->render();
        $this->introduction->render();
    }

    public function componentChanged(Component $component): void {}
}
