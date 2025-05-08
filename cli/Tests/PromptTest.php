<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Input;
use Themosis\Cli\Output;
use Themosis\Cli\Prompt;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\ValidationException;

final class PromptTest extends TestCase
{
    #[Test]
    public function itCanPromptUser_andExpectEmptyString()
    {
        $prompt = new Prompt(
            output: new LocalInMemoryOutput(),
            input: new LocalInMemoryInput(
                text: '',
            ),
            validator: new CallbackValidator(function () {}),
        );

        $result = $prompt("Please insert nothing:");

        $this->assertEmpty($result);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $prompt = new Prompt(
            output: new LocalInMemoryOutput(),
            input: $input = new LocalInMemoryInput(
                text: 'Bond James',
            ),
            validator: new CallbackValidator(function () {})
        );

        $result = $prompt("Please insert your name:\n");

        $this->assertSame($result, $input->read());
    }

    #[Test]
    public function itCanPromptUser_andShouldRestartIfInvalidInput()
    {
        $iteration = 0;

        $prompt = new Prompt(
            output: $output = new LocalInMemoryOutput(),
            input: new LocalInMemoryInput(
                text: implode(',', ["", "Joe"]),
            ),
            validator: new CallbackValidator(function ($value) use (&$iteration) {
                $texts = explode(',', $value);

                if (empty($texts[$iteration])) {
                    $iteration++;
                    throw new ValidationException("Please insert a valid name.\n");
                }
            })
        );

        $result = $prompt("Insert your name:\n");

        $this->assertSame(
            "Insert your name:\nPlease insert a valid name.\nInsert your name:\n",
            $output->output,
        );

        $this->assertSame('Joe', explode(',', $result)[1]);
    }
}

final class LocalInMemoryOutput implements Output
{
    public string $output = '';

    public function write(string $content): void
    {
        $this->output .= $content;
    }
}

final class LocalInMemoryInput implements Input
{
    public function __construct(
        private string $text,
    ) {}

    public function read(): string
    {
        return $this->text;
    }
}
