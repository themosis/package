<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\AnsiColor;
use Themosis\Cli\Layer;

final class AnsiColorTest extends TestCase
{
    #[Test]
    public function itRenders_blackColors(): void
    {
        $black = AnsiColor::black();

        $this->assertSame("\u{001b}[30m", $black->value(Layer::Foreground));
        $this->assertSame("\u{001b}[40m", $black->value(Layer::Background));

        $brightBlack = AnsiColor::brightBlack();

        $this->assertSame("\u{001b}[30;1m", $brightBlack->value(Layer::Foreground));
        $this->assertSame("\u{001b}[40;1m", $brightBlack->value(Layer::Background));
    }

    #[Test]
    public function itRenders_redColors(): void
    {
        $red = AnsiColor::red();

        $this->assertSame("\u{001b}[31m", $red->value(Layer::Foreground));
        $this->assertSame("\u{001b}[41m", $red->value(Layer::Background));

        $brightRed = AnsiColor::brightRed();

        $this->assertSame("\u{001b}[31;1m", $brightRed->value(Layer::Foreground));
        $this->assertSame("\u{001b}[41;1m", $brightRed->value(Layer::Background));
    }

    #[Test]
    public function itRenders_greenColors(): void
    {
        $green = AnsiColor::green();

        $this->assertSame("\u{001b}[32m", $green->value(Layer::Foreground));
        $this->assertSame("\u{001b}[42m", $green->value(Layer::Background));

        $brightGreen = AnsiColor::brightGreen();

        $this->assertSame("\u{001b}[32;1m", $brightGreen->value(Layer::Foreground));
        $this->assertSame("\u{001b}[42;1m", $brightGreen->value(Layer::Background));
    }

    #[Test]
    public function itRenders_yellowColors(): void
    {
        $yellow = AnsiColor::yellow();

        $this->assertSame("\u{001b}[33m", $yellow->value(Layer::Foreground));
        $this->assertSame("\u{001b}[43m", $yellow->value(Layer::Background));

        $brightYellow = AnsiColor::brightYellow();

        $this->assertSame("\u{001b}[33;1m", $brightYellow->value(Layer::Foreground));
        $this->assertSame("\u{001b}[43;1m", $brightYellow->value(Layer::Background));
    }

    #[Test]
    public function itRenders_blueColors(): void
    {
        $blue = AnsiColor::blue();

        $this->assertSame("\u{001b}[34m", $blue->value(Layer::Foreground));
        $this->assertSame("\u{001b}[44m", $blue->value(Layer::Background));

        $brightBlue = AnsiColor::brightBlue();

        $this->assertSame("\u{001b}[34;1m", $brightBlue->value(Layer::Foreground));
        $this->assertSame("\u{001b}[44;1m", $brightBlue->value(Layer::Background));
    }

    #[Test]
    public function itRenders_magentaColors(): void
    {
        $magenta = AnsiColor::magenta();

        $this->assertSame("\u{001b}[35m", $magenta->value(Layer::Foreground));
        $this->assertSame("\u{001b}[45m", $magenta->value(Layer::Background));

        $brightMagenta = AnsiColor::brightMagenta();

        $this->assertSame("\u{001b}[35;1m", $brightMagenta->value(Layer::Foreground));
        $this->assertSame("\u{001b}[45;1m", $brightMagenta->value(Layer::Background));
    }

    #[Test]
    public function itRenders_cyanColors(): void
    {
        $cyan = AnsiColor::cyan();

        $this->assertSame("\u{001b}[36m", $cyan->value(Layer::Foreground));
        $this->assertSame("\u{001b}[46m", $cyan->value(Layer::Background));

        $brightCyan = AnsiColor::brightCyan();

        $this->assertSame("\u{001b}[36;1m", $brightCyan->value(Layer::Foreground));
        $this->assertSame("\u{001b}[46;1m", $brightCyan->value(Layer::Background));
    }

    #[Test]
    public function itRenders_whiteColors(): void
    {
        $white = AnsiColor::white();

        $this->assertSame("\u{001b}[37m", $white->value(Layer::Foreground));
        $this->assertSame("\u{001b}[47m", $white->value(Layer::Background));

        $brightWhite = AnsiColor::brightWhite();

        $this->assertSame("\u{001b}[37;1m", $brightWhite->value(Layer::Foreground));
        $this->assertSame("\u{001b}[47;1m", $brightWhite->value(Layer::Background));
    }
}
