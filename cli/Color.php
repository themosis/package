<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Color implements Attribute
{
    private function __construct(
        private string $color,
    ) {}

    public static function black(): self
    {
        return new self(
            color: '0'
        );
    }

    public static function base(): self
    {
        return self::black();
    }

    public static function brightBlack(): self
    {
        return new self(
            color: '8',
        );
    }

    public function value(): string
    {
        return $this->color;
    }
}
