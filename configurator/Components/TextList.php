<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Attribute;
use Themosis\Cli\CsiSequence;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class TextList extends Component
{
    private CsiSequence $sequence;

    public function __construct(
        private Output $output,
        Attribute ...$attributes,
    ) {
        $this->sequence = Sequence::make()
            ->attributes(...$attributes)
            ->append(new LineFeed());

        $this->element = new Message(
            sequence: $this->sequence,
            output: $output,
        );
    }

    public function addTextElement(string $text): static
    {
        $this
            ->sequence
            ->append(
                new Text(sprintf('- %s', $text)),
                new LineFeed(),
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
