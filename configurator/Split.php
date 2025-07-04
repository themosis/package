<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator;

final class Split
{
    private array $lines = [];

    public const WHITESPACE = ' ';

    public function __construct(
        private int $length = 60,
    ) {}

    public function split(string $text): static
    {
        $line = [];

        $pointer = 0;

        while ($pointer < strlen($text)) {
            $char = $text[$pointer];
            $line[] = $char;

            if ($char === self::WHITESPACE) {
                if ($pointer >= ($this->length - 1)) {
                    $this->split(substr($text, $pointer));
                    break;
                }
            }

            $pointer++;
        }

        $this->lines[] = $line;

        return $this;
    }

    public function get(): array
    {
        return array_reverse(array_map(function (array $line) {
            return  trim(implode('', $line));
        }, $this->lines));
    }
}
