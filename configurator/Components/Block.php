<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Attribute;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Display;
use Themosis\Cli\Element;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class Block extends Component
{
    private Element $element;

    public function __construct(
        private Output $output,
        private string $text,
        Attribute ...$attributes,
    ) {
        $text = ' ' . trim($text) . ' ';
        $emptySpace = str_repeat(' ', strlen($text));

        if (empty($attributes)) {
            $attributes = [
                BackgroundColor::cyan(),
                ForegroundColor::base(),
                Display::bold(),
            ];
        }

        $this->element = new Message(
            sequence: Sequence::make()
                ->attributes(...$attributes)
                ->append(
                    new Text($emptySpace),
                    new LineFeed(),
                    new Text($text),
                    new LineFeed(),
                    new Text($emptySpace),
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
