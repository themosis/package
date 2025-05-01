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
    public function itCanPromptUser_andExpectEmptyString()
    {
        $prompt = new Prompt(
            output: new LocalInMemoryOutput(
                content: "Please insert nothing:",
            ),
            input: new LocalInMemoryInput(
                text: '',
            ),
        );

        $result = $prompt();

        $this->assertEmpty($result);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $prompt = new Prompt(
            output: new LocalInMemoryOutput(
                content: "Please insert your name:\n",
            ),
            input: $input = new LocalInMemoryInput(
                text: 'Bond James',
            ),
        );

        $result = $prompt();

        $this->assertSame($result, $input->read());
    }
}

final class LocalInMemoryOutput implements Output
{
    public function __construct(
        public string $content,
    ) {}

    public function write(): void
    {}
}

final class LocalInMemoryInput implements Input
{
    public function __construct(
        private string $text,
    ) {}

    public function validate(): void { }

    public function read(): string
    {
        return $this->text;
    }
}
