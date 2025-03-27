<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Input;
use Themosis\Cli\Output;
use Themosis\Cli\Prompt;

final class PromptTest extends TestCase
{
    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $prompt = new Prompt(
            output: $output = new LocalInMemoryOutput(),
            input: $input = new LocalInMemoryInput(
                input: 'Bond James',
            ),
        );

        $message = "Please insert your name:\n";
        $result = $prompt($message);

        $this->assertSame($message, $output->content);
        $this->assertSame($result, $input->read());
    }
}

final class LocalInMemoryOutput implements Output
{
    public string $content = '';

    public function write(string $content): void
    {
        $this->content = $content;
    }
}

final class LocalInMemoryInput implements Input
{
    public function __construct(
        private string $input,
    ) {}

    public function read(): string
    {
        return $this->input;
    }
}
