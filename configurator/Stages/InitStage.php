<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Stages;

use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\FormattedText;
use Themosis\Cli\Validation\InvalidInput;
use Themosis\Components\Package\Configurator\Components\Block;
use Themosis\Components\Package\Configurator\Components\Component;
use Themosis\Components\Package\Configurator\Components\ComponentFactory;
use Themosis\Components\Package\Configurator\Components\Paragraph;
use Themosis\Components\Package\Configurator\Components\TextPrompt;

final class InitStage implements Stage
{
    private Block $title;

    private Paragraph $introduction;

    private TextPrompt $vendor;

    private TextPrompt $package;

    private TextPrompt $description;

    private array $state = [];

    public function __construct(
        private ComponentFactory $factory,
    ) {
        $this->title = $factory
            ->block('Themosis Package')
            ->withDirector($this);

        $this->introduction = $factory
            ->paragraph('This tool will guide you through setting up your PHP package or application.')
            ->withDirector($this);

        $this->vendor = $factory
            ->textPrompt('Please insert a vendor name:', new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $message = "A vendor name is required.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                if (preg_match('/^[a-z0-9]([_.-]?[a-z0-9]+)*$/', $value) !== 1) {
                    $message = "A vendor name must be a lowercased alphanumeric string without any special characters.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                return $value;
            }))
            ->withDirector($this);

        $this->package = $factory
            ->textPrompt('Please insert a package name:', new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $message = "A package name is required.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                if (preg_match('/^[a-z0-9](([_.]|-{1,2})?[a-z0-9]+)*$/', $value) !== 1) {
                    $message = "A package name must be a lowercased alphanumeric string without any special characters.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                return $value;
            }))
            ->withDirector($this);

        $this->description = $factory
            ->textPrompt('Please insert a description:', new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $message = "A description is required.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                return $value;
            }))
            ->withDirector($this);
    }

    public function run(): void
    {
        $this->title->render();
        $this->introduction->render();
        $this->vendor->render();
        $this->package->render();
        $this->description->render();
    }

    public function componentChanged(Component &$component): void
    {
        if ($component === $this->vendor && $component instanceof TextPrompt) {
            $this->state['vendor'] = $component->value();
        }

        if ($component === $this->package && $component instanceof TextPrompt) {
            $this->state['package'] = $component->value();
        }

        if ($component === $this->description && $component instanceof TextPrompt) {
            $this->state['description'] = $component->value();
        }
    }
}
