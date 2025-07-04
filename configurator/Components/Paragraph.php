<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Attribute;
use Themosis\Cli\Code;
use Themosis\Cli\CsiSequence;
use Themosis\Cli\Display;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\TextProcessing\Split;

final class Paragraph extends Component
{
    private CsiSequence $sequence;

    private int $length = 60;

    public function __construct(
        private Output $output,
        private string $text,
        Attribute ...$attributes,
    ) {
        $this->sequence = Sequence::make()
            ->attributes(...$attributes)
            ->append(
                ...$this->applyText($text),
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

    /**
     * @return Code[]
     */
    private function applyText(string $text): array
    {
        $lines = (new Split(
            length: $this->length,
        ))($text);

        $textElements = array_reduce($lines, function (array $carry, string $text) {
            $carry[] = new LineFeed();
            $carry[] = new Text($text);

            return $carry;
        }, []);

        $textElements[] = new LineFeed();

        return $textElements;
    }

    public function addText(string $text): static
    {
        $this
            ->sequence
            ->append(
                ...$this->applyText($text),
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
