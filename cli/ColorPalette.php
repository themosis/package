<?php

declare(strict_types=1);

namespace Themosis\Cli;

abstract class ColorPalette implements Attribute
{
    public function __construct(
        protected Color $color,
    ) {}

    public static function black(): static
    {
        return new static(
            color: Color::black(),
        );
    }

    public static function base(): static
    {
        return static::black();
    }

    public static function brightBlack(): static
    {
        return new static(
            color: Color::brightBlack(),
        );
    }

    public static function red(): static
    {
        return new static(
            color: Color::red(),
        );
    }

    public static function brightRed(): static
    {
        return new static(
            color: Color::brightRed(),
        );
    }

    public static function green(): static
    {
        return new static(
            color: Color::green(),
        );
    }

    public static function brightGreen(): static
    {
        return new static(
            color: Color::brightGreen(),
        );
    }

    public static function yellow(): static
    {
        return new static(
            color: Color::yellow(),
        );
    }

    public static function brightYellow(): static
    {
        return new static(
            color: Color::brightYellow(),
        );
    }

    public static function blue(): static
    {
        return new static(
            color: Color::blue(),
        );
    }

    public static function brightBlue(): static
    {
        return new static(
            color: Color::brightBlue(),
        );
    }

    public static function magenta(): static
    {
        return new static(
            color: Color::magenta(),
        );
    }

    public static function brightMagenta(): static
    {
        return new static(
            color: Color::brightMagenta(),
        );
    }

    public static function cyan(): static
    {
        return new static(
            color: Color::cyan(),
        );
    }

    public static function brightCyan(): static
    {
        return new static(
            color: Color::brightCyan(),
        );
    }

    public static function white(): static
    {
        return new static(
            color: Color::white(),
        );
    }

    public static function reverse(): static
    {
        return static::white();
    }

    public static function brightWhite(): static
    {
        return new static(
            color: Color::brightWhite(),
        );
    }
}
