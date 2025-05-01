<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class AnsiColor implements Color
{
    private string $color;

    private function __construct(
        string $code,
    ) {
        $this->color = "\u001b[{$code}m";
    }

    public static function default(): self
    {
        return new self(
            code: '0',
        );
    }

    public static function black(): self
    {
        return new self(
            code: '30',
        );
    }

    public static function brightBlack(): self
    {
        return new self(
            code: '30;1'
        );
    }

    public static function red(): self
    {
        return new self(
            code: '31',
        );
    }

    public static function brightRed(): self
    {
        return new self(
            code: '31;1',
        );
    }

    public static function green(): self
    {
        return new self(
            code: '32',
        );
    }

    public static function brightGreen(): self
    {
        return new self(
            code: '32;1',
        );
    }

    public static function yellow(): self
    {
        return new self(
            code: '33',
        );
    }

    public static function brightYellow(): self
    {
        return new self(
            code: '33;1',
        );
    }

    public static function blue(): self
    {
        return new self(
            code: '34',
        );
    }

    public static function brightBlue(): self
    {
        return new self(
            code: '34;1',
        );
    }

    public static function magenta(): self
    {
        return new self(
            code: '35',
        );
    }

    public static function brightMagenta(): self
    {
        return new self(
            code: '35;1',
        );
    }

    public static function cyan(): self
    {
        return new self(
            code: '36',
        );
    }

    public static function brightCyan(): self
    {
        return new self(
            code: '36;1',
        );
    }

    public static function white(): self
    {
        return new self(
            code: '37',
        );
    }

    public static function brightWhite(): self
    {
        return new self(
            code: '37;1',
        );
    }

    public function value(): string
    {
        return $this->color;
    }
}
