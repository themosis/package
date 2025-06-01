<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class Display implements Attribute
{
    private function __construct(
        private string $attribute,
    ) {
    }

    public static function reset(): self
    {
        return new self('0');
    }

    public static function bold(): self
    {
        return new self('1');
    }

    public static function underline(): self
    {
        return new self('4');
    }

    public static function reversed(): self
    {
        return new self('7');
    }

    public function value(): string
    {
        return $this->attribute;
    }
}
