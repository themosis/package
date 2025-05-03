<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class AnsiColor implements Color
{
    private function __construct(
        private int $code,
        private bool $isBright = false,
    ) {}

    public static function black(): self
    {
        return new self(
            code: 30,
        );
    }

    public static function brightBlack(): self
    {
        return new self(
            code: 30,
            isBright: true,
        );
    }

    public static function red(): self
    {
        return new self(
            code: 31,
        );
    }

    public static function brightRed(): self
    {
        return new self(
            code: 31,
            isBright: true,
        );
    }

    public static function green(): self
    {
        return new self(
            code: 32,
        );
    }

    public static function brightGreen(): self
    {
        return new self(
            code: 32,
            isBright: true,
        );
    }

    public static function yellow(): self
    {
        return new self(
            code: 33,
        );
    }

    public static function brightYellow(): self
    {
        return new self(
            code: 33,
            isBright: true,
        );
    }

    public static function blue(): self
    {
        return new self(
            code: 34,
        );
    }

    public static function brightBlue(): self
    {
        return new self(
            code: 34,
            isBright: true,
        );
    }

    public static function magenta(): self
    {
        return new self(
            code: 35,
        );
    }

    public static function brightMagenta(): self
    {
        return new self(
            code: 35,
            isBright: true,
        );
    }

    public static function cyan(): self
    {
        return new self(
            code: 36,
        );
    }

    public static function brightCyan(): self
    {
        return new self(
            code: 36,
            isBright: true,
        );
    }

    public static function white(): self
    {
        return new self(
            code: 37,
        );
    }

    public static function brightWhite(): self
    {
        return new self(
            code: 37,
            isBright: true,
        );
    }

    public function value(Layer $layer): string
    {
        $code = $layer === Layer::Foreground
            ? $this->code
            : $this->code + 10;

        $codeAsString = $this->isBright
            ? "{$code};1"
            : $code;

        $unicodeEscape = "\u{001b}";

        /**
         * This is called a CSI (Control Sequence Introducer).
         * It starts with an escape sequence followed by a left square bracket,
         * the sequence color code and ending with the single "m" character.
         */
        return "{$unicodeEscape}[{$codeAsString}m";
    }
}
