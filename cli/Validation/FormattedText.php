<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

use Stringable;
use Themosis\Cli\Display;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class FormattedText implements Stringable
{
    private function __construct(
        private string $text,
    ) {}

    public static function error(string $text): self
    {
        return new self(
            Sequence::make()
                ->attribute(ForegroundColor::red())
                ->append(
                    new LineFeed(),
                    new Text($text),
                    new LineFeed(),
                    new LineFeed(),
                    Sequence::make()->attribute(Display::reset()),
                )
                ->get()
        );
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
