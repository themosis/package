<?php

declare(strict_types=1);

namespace Themosis\Cli\TextProcessing;

final class Split
{
    private array $lines = [];

    private const WHITESPACE = ' ';

    public function __construct(
        private int $length = 60,
    ) {}

    private function reset(): void
    {
        $this->lines = [];
    }

    private function split(string $text): void
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
    }

    public function __invoke(string $text): array
    {
        $this->reset();
        $this->split($text);
        
        return array_reverse(array_map(function (array $line) {
            return  trim(implode('', $line));
        }, $this->lines));
    }
}
