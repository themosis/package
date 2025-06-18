<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Display;
use Themosis\Cli\Element;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\Input;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\Validable;
use Themosis\Cli\Validation\Validator;

final class TextPrompt extends Component
{
    private Element $element;

    public function __construct(
        Output $output,
        Input $input,
        string $message,
        Validator $validator,
    ) {
        $this->element = new Validable(
            element: new Prompt(
                element: new Message(
                    sequence: Sequence::make()
                        ->append(
                            new LineFeed(),
                            new Text($message),
                            new LineFeed(),
                            Sequence::make()
                                ->attributes(ForegroundColor::green(), Display::bold())
                                ->append(new Text("> ")),
                            Sequence::make()
                                ->attribute(Display::reset())
                        ),
                    output: $output,
                ),
                input: $input,
            ),
            validator: $validator,
        );
    }

    public function render(): static
    {
        $this->element->render();

        $this->notify();

        return $this;
    }

    public function value(): ?string
    {
        return $this->element->value();
    }
}
