<?php

declare(strict_types=1);

namespace Themosis\Cli;

final class CsiSequence implements Code
{
    /** @var Attribute[] */
    private array $attributes = [];

    /** @var Code[] */
    private array $children = [];

    private function __construct(
        private string $code,
        private string $lastByte,
    ) {
    }

    public static function selectGraphicRendition(): self
    {
        return new self(
            code: '[',
            lastByte: 'm',
        );
    }

    public function append(Code ...$sequences): static
    {
        foreach ($sequences as $sequence) {
            $this->children[] = $sequence;
        }

        return $this;
    }

    public function attributes(Attribute ...$attributes): static
    {
        array_map($this->attribute(...), $attributes);

        return $this;
    }

    public function attribute(Attribute $attribute): static
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    public function get(): string
    {
        $unicodeEscapeCode = "\u{001b}";

        $attributes = implode(';', array_map(function (Attribute $attribute) {
            return $attribute->value();
        }, $this->attributes));

        $append = implode('', $this->children);

        return "{$unicodeEscapeCode}{$this->code}{$attributes}{$this->lastByte}{$append}";
    }

    public function __toString(): string
    {
        return $this->get();
    }
}
