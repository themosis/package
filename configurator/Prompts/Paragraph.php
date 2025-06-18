<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Prompts;

use Themosis\Cli\Attribute;
use Themosis\Cli\Display;
use Themosis\Cli\Element;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class Paragraph extends Component
{
    private Element $element;

    public function __construct(
        private Output $output,
        private string $text,
        Attribute ...$attributes,
    ) {
        $this->element = new Message(
            sequence: Sequence::make()
                ->attributes(...$attributes)
                ->append(
                    new LineFeed(),
                    new Text($text),
                    new LineFeed(),
                    new LineFeed(),
                    Sequence::make()
                        ->attribute(Display::reset()),
                ),
            output: $output,
        );
    }

    public function render(): static
    {
        $this->element->render();

        $this->notify();

        return $this;
    }
}
