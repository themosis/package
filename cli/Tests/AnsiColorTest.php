<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\AnsiColor;
use Themosis\Cli\Color;
use Themosis\Cli\Layer;

final class AnsiColorTest extends TestCase
{
    public static function foregroundColors(): array
    {
        return [
            [AnsiColor::black(), "\u001b[30m"],
            [AnsiColor::brightBlack(), "\u001b[30;1m"],
            [AnsiColor::red(), "\u001b[31m"],
            [AnsiColor::brightRed(), "\u001b[31;1m"],
            [AnsiColor::green(), "\u001b[32m"],
            [AnsiColor::brightGreen(), "\u001b[32;1m"],
            [AnsiColor::yellow(), "\u001b[33m"],
            [AnsiColor::brightYellow(), "\u001b[33;1m"],
            [AnsiColor::blue(), "\u001b[34m"],
            [AnsiColor::brightBlue(), "\u001b[34;1m"],
            [AnsiColor::magenta(), "\u001b[35m"],
            [AnsiColor::brightMagenta(), "\u001b[35;1m"],
            [AnsiColor::cyan(), "\u001b[36m"],
            [AnsiColor::brightCyan(), "\u001b[36;1m"],
            [AnsiColor::white(), "\u001b[37m"],
            [AnsiColor::brightWhite(), "\u001b[37;1m"],
        ];
    }

    public static function backgroundColors(): array
    {
        return [
            [AnsiColor::black(), "\u001b[40m"],
            [AnsiColor::brightBlack(), "\u001b[40;1m"],
            [AnsiColor::red(), "\u001b[41m"],
            [AnsiColor::brightRed(), "\u001b[41;1m"],
            [AnsiColor::green(), "\u001b[42m"],
            [AnsiColor::brightGreen(), "\u001b[42;1m"],
            [AnsiColor::yellow(), "\u001b[43m"],
            [AnsiColor::brightYellow(), "\u001b[43;1m"],
            [AnsiColor::blue(), "\u001b[44m"],
            [AnsiColor::brightBlue(), "\u001b[44;1m"],
            [AnsiColor::magenta(), "\u001b[45m"],
            [AnsiColor::brightMagenta(), "\u001b[45;1m"],
            [AnsiColor::cyan(), "\u001b[46m"],
            [AnsiColor::brightCyan(), "\u001b[46;1m"],
            [AnsiColor::white(), "\u001b[47m"],
            [AnsiColor::brightWhite(), "\u001b[47;1m"],
        ];
    }

    #[Test]
    #[DataProvider('foregroundColors')]
    public function itRenders16BitsForegroundAnsiColors(Color $color, string $expected): void
    {
        $this->assertSame($expected, $color->value(Layer::Foreground));
    }

    #[Test]
    #[DataProvider('backgroundColors')]
    public function itRenders16BitsBackgroundAnsiColors(Color $color, string $expected): void
    {
        $this->assertSame($expected, $color->value(Layer::Background));
    }
}
