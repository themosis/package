<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Display;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class SequenceTest extends TestCase
{
    #[Test]
    public function itRenders_emptySequence_withCsiEscapeSequence(): void
    {
        $sequence = Sequence::make();

        $this->assertSame("\u{001b}[m", $sequence->get());
        $this->assertSame("\u{001b}[m", (string) $sequence);
    }

    #[Test]
    public function itRenders_text(): void
    {
        $sequence = Sequence::make()
            ->append(new Text($text = 'This is some text'));

        $this->assertSame("\u{001b}[m{$text}", $sequence->get());
        $this->assertSame("\u{001b}[m{$text}", (string) $sequence);
    }

    #[Test]
    public function itRenders_textWithForeground_andBackgroundColors(): void
    {
        $sequence = Sequence::make()
            ->attribute(BackgroundColor::red())
            ->attribute(ForegroundColor::yellow())
            ->append(new Text($text = "This text has a red background and a yellow foreground"))
            ->append(new LineFeed())
            ->append(Sequence::make()->attribute(Display::reset()));

        $this->assertSame("\u{001b}[48;5;1;38;5;3m{$text}\u{000a}\u{001b}[0m", $sequence->get());
    }

    #[Test]
    public function itRenders_textWithBoldStyle(): void
    {
        $sequence = Sequence::make()
        ->attribute(Display::bold())
        ->append($text = new Text("This is a text sample."));

        $this->assertSame("\u{001b}[1m{$text}", $sequence->get());
    }

    #[Test]
    public function itRenders_textWithUnderlineStyle(): void
    {
        $sequence = Sequence::make()
            ->attribute(Display::underline())
            ->append($text = new Text("This is a text sample."));

        $this->assertSame("\u{001b}[4m{$text}", $sequence->get());
    }

    #[Test]
    public function itRenders_textWithReversedStyle(): void
    {
        $sequence = Sequence::make()
            ->attribute(Display::reversed())
            ->append($text = new Text("This is a text sample."));

        $this->assertSame("\u{001b}[7m{$text}", $sequence->get());
    }
}
