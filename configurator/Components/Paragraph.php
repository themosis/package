<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Attribute;
use Themosis\Cli\CsiSequence;
use Themosis\Cli\Display;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class Paragraph extends Component
{
    private CsiSequence $sequence;

    public function __construct(
        private Output $output,
        private string $text,
        Attribute ...$attributes,
    ) {
        $this->sequence = Sequence::make()
            ->attributes(...$attributes)
            ->append(
                new LineFeed(),
                new Text($text),
                new LineFeed(),
            )
            ->append(
                Sequence::make()
                    ->attribute(Display::reset()),
            );

        $this->element = new Message(
            sequence: $this->sequence,
            output: $output,
        );
    }

    public function add(string $text): static
    {
        $this
            ->sequence
            ->append(
                new LineFeed(),
                new Text($text),
                new LineFeed()
            );

        return $this;
    }

    public function render(): static
    {
        $this->element->render();

        $this->notify();

        return $this;
    }
}
