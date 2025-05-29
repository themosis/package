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
    public function itRenders_EmptySequence_WithCsiEscapeSequence(): void
    {
        $sequence = Sequence::make();

        $this->assertSame("\u{001b}[m", $sequence->get());
        $this->assertSame("\u{001b}[m", (string) $sequence);
    }

    #[Test]
    public function itRenders_Text(): void
    {
        $sequence = Sequence::make()
            ->append(new Text($text = 'This is some text'));

        $this->assertSame("\u{001b}[m{$text}", $sequence->get());
        $this->assertSame("\u{001b}[m{$text}", (string) $sequence);
    }

    #[Test]
    public function itRenders_Text_WithForeground_AndBackgroundColors(): void
    {
        $sequence = Sequence::make()
            ->attribute(BackgroundColor::red())
            ->attribute(ForegroundColor::yellow())
            ->append(new Text($text = "This text has a red background and a yellow foreground"))
            ->append(new LineFeed())
            ->append(Sequence::make()->attribute(Display::reset()));

        $this->assertSame("\u{001b}[48;5;1;38;5;3m{$text}\u{000a}\u{001b}[0m", $sequence->get());
    }
}
