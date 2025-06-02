<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Color;
use Themosis\Cli\ForegroundColor;

final class ColorPaletteTest extends TestCase
{
    private function fgExpectation(int $color): string
    {
        return "38;5;{$color}";
    }

    private function bgExpectation(int $color): string
    {
        return "48;5;{$color}";
    }

    #[Test]
    public function itThrowsAnException_ifColorCode_isOutOfRange(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Color(-25);

        $this->expectException(InvalidArgumentException::class);

        new Color(267);
    }

    #[Test]
    public function itRenders_baseAndReverseColors(): void
    {
        $baseColor = Color::base();
        $this->assertSame('0', $baseColor->value());

        $bgBase = BackgroundColor::base();
        $this->assertSame($this->bgExpectation(0), $bgBase->value());

        $fgBase = ForegroundColor::base();
        $this->assertSame($this->fgExpectation(0), $fgBase->value());

        $reverseColor = Color::reverse();
        $this->assertSame('7', $reverseColor->value());

        $bgReverse = BackgroundColor::reverse();
        $this->assertSame($this->bgExpectation(7), $bgReverse->value());

        $fgReverse = ForegroundColor::reverse();
        $this->assertSame($this->fgExpectation(7), $fgReverse->value());
    }

    #[Test]
    public function itRenders_blackColors(): void
    {
        $bgBlack = BackgroundColor::black();
        $this->assertSame($this->bgExpectation(0), $bgBlack->value());

        $bgBrightBlack = BackgroundColor::brightBlack();
        $this->assertSame($this->bgExpectation(8), $bgBrightBlack->value());

        $fgBlack = ForegroundColor::black();
        $this->assertSame($this->fgExpectation(0), $fgBlack->value());

        $fgBrightBlack = ForegroundColor::brightBlack();
        $this->assertSame($this->fgExpectation(8), $fgBrightBlack->value());
    }

    #[Test]
    public function itRenders_redColors(): void
    {
        $bgRed = BackgroundColor::red();
        $this->assertSame($this->bgExpectation(1), $bgRed->value());

        $bgBrightRed = BackgroundColor::brightRed();
        $this->assertSame($this->bgExpectation(9), $bgBrightRed->value());

        $fgRed = ForegroundColor::red();
        $this->assertSame($this->fgExpectation(1), $fgRed->value());

        $fgBrightRed = ForegroundColor::brightRed();
        $this->assertSame($this->fgExpectation(9), $fgBrightRed->value());
    }

    #[Test]
    public function itRenders_greenColors(): void
    {
        $bgGreen = BackgroundColor::green();
        $this->assertSame($this->bgExpectation(2), $bgGreen->value());

        $bgBrightGreen = BackgroundColor::brightGreen();
        $this->assertSame($this->bgExpectation(10), $bgBrightGreen->value());

        $fgGreen = ForegroundColor::green();
        $this->assertSame($this->fgExpectation(2), $fgGreen->value());

        $fgBrightGreen = ForegroundColor::brightGreen();
        $this->assertSame($this->fgExpectation(10), $fgBrightGreen->value());
    }

    #[Test]
    public function itRenders_yellowColors(): void
    {
        $bgYellow = BackgroundColor::yellow();
        $this->assertSame($this->bgExpectation(3), $bgYellow->value());

        $bgBrightYellow = BackgroundColor::brightYellow();
        $this->assertSame($this->bgExpectation(11), $bgBrightYellow->value());

        $fgYellow = ForegroundColor::yellow();
        $this->assertSame($this->fgExpectation(3), $fgYellow->value());

        $fgBrightYellow = ForegroundColor::brightYellow();
        $this->assertSame($this->fgExpectation(11), $fgBrightYellow->value());
    }

    #[Test]
    public function itRenders_blueColors(): void
    {
        $bgBlue = BackgroundColor::blue();
        $this->assertSame($this->bgExpectation(4), $bgBlue->value());

        $bgBrightBlue = BackgroundColor::brightBlue();
        $this->assertSame($this->bgExpectation(12), $bgBrightBlue->value());

        $fgBlue = ForegroundColor::blue();
        $this->assertSame($this->fgExpectation(4), $fgBlue->value());

        $fgBrightBlue = ForegroundColor::brightBlue();
        $this->assertSame($this->fgExpectation(12), $fgBrightBlue->value());
    }

    #[Test]
    public function itRenders_magentaColors(): void
    {
        $bgMagenta = BackgroundColor::magenta();
        $this->assertSame($this->bgExpectation(5), $bgMagenta->value());

        $bgBrightMagenta = BackgroundColor::brightMagenta();
        $this->assertSame($this->bgExpectation(13), $bgBrightMagenta->value());

        $fgMagenta = ForegroundColor::magenta();
        $this->assertSame($this->fgExpectation(5), $fgMagenta->value());

        $fgBrightMagenta = ForegroundColor::brightMagenta();
        $this->assertSame($this->fgExpectation(13), $fgBrightMagenta->value());
    }

    #[Test]
    public function itRenders_cyanColors(): void
    {
        $bgCyan = BackgroundColor::cyan();
        $this->assertSame($this->bgExpectation(6), $bgCyan->value());

        $bgBrightCyan = BackgroundColor::brightCyan();
        $this->assertSame($this->bgExpectation(14), $bgBrightCyan->value());

        $fgCyan = ForegroundColor::cyan();
        $this->assertSame($this->fgExpectation(6), $fgCyan->value());

        $fgBrightCyan = ForegroundColor::brightCyan();
        $this->assertSame($this->fgExpectation(14), $fgBrightCyan->value());
    }

    #[Test]
    public function itRenders_whiteColors(): void
    {
        $bgWhite = BackgroundColor::white();
        $this->assertSame($this->bgExpectation(7), $bgWhite->value());

        $bgBrightWhite = BackgroundColor::brightWhite();
        $this->assertSame($this->bgExpectation(15), $bgBrightWhite->value());

        $fgWhite = ForegroundColor::white();
        $this->assertSame($this->fgExpectation(7), $fgWhite->value());

        $fgBrightWhite = ForegroundColor::brightWhite();
        $this->assertSame($this->fgExpectation(15), $fgBrightWhite->value());
    }
}
