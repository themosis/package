<?php

declare(strict_types=1);

namespace Themosis\Cli;

use InvalidArgumentException;

/**
 * Color values follow the 8-bit code sequence and allow
 * developers to specify up to 256 colors.
 *
 * @see https://en.wikipedia.org/wiki/ANSI_escape_code#8-bit
 */
final class Color implements Attribute
{
    public function __construct(
        private int $color,
    ) {
        if ($color < 0 || $color > 255) {
            throw new InvalidArgumentException("Color value must be between 0 and 255.");
        }
    }

    public static function black(): self
    {
        return new self(
            color: 0
        );
    }

    public static function base(): self
    {
        return self::black();
    }

    public static function brightBlack(): self
    {
        return new self(
            color: 8,
        );
    }

    public static function red(): self
    {
        return new self(
            color: 1,
        );
    }

    public static function brightRed(): self
    {
        return new self(
            color: 9,
        );
    }

    public static function green(): self
    {
        return new self(
            color: 2,
        );
    }

    public static function brightGreen(): self
    {
        return new self(
            color: 10,
        );
    }

    public static function yellow(): self
    {
        return new self(
            color: 3,
        );
    }

    public static function brightYellow(): self
    {
        return new self(
            color: 11,
        );
    }

    public static function blue(): self
    {
        return new self(
            color: 4,
        );
    }

    public static function brightBlue(): self
    {
        return new self(
            color: 12,
        );
    }

    public static function magenta(): self
    {
        return new self(
            color: 5,
        );
    }

    public static function brightMagenta(): self
    {
        return new self(
            color: 13,
        );
    }

    public static function cyan(): self
    {
        return new self(
            color: 6,
        );
    }

    public static function brightCyan(): self
    {
        return new self(
            color: 14,
        );
    }

    public static function white(): self
    {
        return new self(
            color: 7,
        );
    }

    public static function reverse(): self
    {
        return self::white();
    }

    public static function brightWhite(): self
    {
        return new self(
            color: 15,
        );
    }

    public function value(): string
    {
        return (string) $this->color;
    }
}
