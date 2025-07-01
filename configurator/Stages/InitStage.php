<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Stages;

use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\FormattedText;
use Themosis\Cli\Validation\InvalidInput;
use Themosis\Components\Package\Configurator\Components\Block;
use Themosis\Components\Package\Configurator\Components\Component;
use Themosis\Components\Package\Configurator\Components\ComponentFactory;
use Themosis\Components\Package\Configurator\Components\MultiPrompt;
use Themosis\Components\Package\Configurator\Components\Paragraph;
use Themosis\Components\Package\Configurator\Components\TextPrompt;

final class InitStage implements Stage
{
    private Block $title;

    private Paragraph $introduction;

    private TextPrompt $vendor;

    private TextPrompt $package;

    private TextPrompt $description;

    private MultiPrompt $authors;

    private array $state = [];

    public function __construct(
        private ComponentFactory $factory,
    ) {
        $this->title = $factory
            ->block('Themosis Package')
            ->withDirector($this);

        $this->introduction = $factory
            ->paragraph('The Themosis Package tool will guide you to setup your PHP package or application.')
            ->addText('The following steps will help you configure your "composer.json" file:')
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

        $this->authors = $factory
            ->multiPrompt(
                message: $factory->paragraph('Please insert an author.'),
                more: $factory->textPrompt('Would you like to add another author?[y/n]', new CallbackValidator(function (string $value) {
                    if (! in_array($value, ['y', 'Y', 'n', 'N'], true)) {
                        $message = sprintf('Answer "%s" or "%s"', 'y', 'n');

                        throw new InvalidInput($message, FormattedText::error($message));
                    }

                    return strtolower($value);
                })),
                predicate: function (string $value) {
                    return 'y' === $value;
                },
            )
            ->add('name', $factory->textPrompt('Enter author\'s name:', new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $message = "An author's name is required.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                return $value;
            })))
            ->add('email', $factory->textPrompt('Enter author\'s email:', new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $message = "An author's email is required.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $message = "Invalid email address.";

                    throw new InvalidInput($message, FormattedText::error($message));
                }

                return $value;
            })))
            ->withDirector($this);
    }

    public function run(): void
    {
        $this->title->render();
        $this->introduction->render();
        $this->vendor->render();
        $this->package->render();
        $this->description->render();
        $this->authors->render();
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

        if ($component === $this->authors && $component instanceof MultiPrompt) {
            $this->state['authors'] = $component->value();
        }
    }
}
