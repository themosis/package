<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\AnsiColor;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\Reset;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

final class SequenceTest extends TestCase
{
    #[Test]
    public function itRenders_EmptySequence(): void
    {
        $sequence = new Sequence();

        $this->assertEmpty($sequence->content());
        $this->assertEmpty((string) $sequence);
    }

    #[Test]
    public function itRenders_Text(): void
    {
        $sequence = (new Sequence())
            ->add(new Text($text = 'This is some text'));

        $this->assertSame($text, $sequence->content());
        $this->assertSame($text, (string) $sequence);
    }

    #[Test]
    public function itRenders_Text_WithForeground_AndBackgroundColors(): void
    {
        $sequence = (new Sequence())
            ->add(new BackgroundColor(AnsiColor::red()))
            ->add(new ForegroundColor(AnsiColor::yellow()))
            ->add(new Text($text = "This text has a red background and a yellow foreground"))
            ->add(new Reset());

        $this->assertSame("\u{001b}[41m\u{001b}[33m{$text}\u{001b}[0m", $sequence->content());
    }
}
