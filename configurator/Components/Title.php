<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Themosis\Cli\Attribute;
use Themosis\Cli\Display;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class Title extends Component
{
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
                )
                ->append(
                    Sequence::make()
                        ->attribute(Display::reset()),
                ),
            output: $output,
        );
    }

    public function render(): static
    {
        $this->element->render();

        return $this;
    }
}
