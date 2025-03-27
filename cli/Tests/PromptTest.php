<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Output;

final class PromptTest extends TestCase
{
    #[Test]
    public function itCanPromptUser()
    {
        $prompt = new Prompt(
            output: $output = new LocalFileOutput(
                filepath: __DIR__.'/fixtures/hello.txt',
            ),
            input: null,
        );

        $message = "Please insert your name:\n";
        $prompt($message);

        $this->assertSame($message, $output->read());
    }
}

final class LocalFileOutput implements Output
{
    public function __construct(
        private string $filepath,
    ) {}

    public function write(string $content): void
    {
        file_put_contents($this->filepath, $content);
    }

    public function read(): string
    {
        return file_get_contents($this->filepath);
    }
}
