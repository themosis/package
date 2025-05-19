<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Input;
use Themosis\Cli\Output;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\Validable;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\ValidationException;

final class PromptTest extends TestCase
{
    #[Test]
    public function itCanPromptUser_andExpectEmptyString()
    {
        $prompt = new Prompt(
            message: (new Sequence())->add($text = new Text("Please insert nothing:")),
            output: $output = new LocalInMemoryOutput(),
            input: new LocalInMemoryInput(
                text: '',
            ),
        );

        $result = $prompt();

        $this->assertEmpty($result);
        $this->assertSame($text->content(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $prompt = new Prompt(
            message: (new Sequence())->add($text = new Text("Please insert your name:\n")),
            output: $output = new LocalInMemoryOutput(),
            input: $input = new LocalInMemoryInput(
                text: 'Bond James',
            ),
        );

        $result = $prompt();

        $this->assertSame($result, $input->read());
        $this->assertSame($text->content(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andShouldRestartIfInvalidInput()
    {
        $iteration = 0;

        $output = new LocalInMemoryOutput();
        $validator = new CallbackValidator(function (string $value) use (&$iteration) {
            $texts = explode(',', $value);

            if (empty($texts[$iteration])) {
                $iteration++;
                throw new ValidationException("Invalid name, try again!\n");
            }
        });

        $prompt = new Validable(
            new Prompt(
                message: (new Sequence())->add(new Text("Please insert your name:\n")),
                output: $output,
                input: new LocalInMemoryInput(
                    text: implode(',', ["", "Julien"]),
                ),
            ),
            $validator,
            $output
        );

        $result = $prompt();

        $this->assertSame("Please insert your name:\nInvalid name, try again!\nPlease insert your name:\n", $output->output);
        $this->assertSame('Julien', explode(',', $result)[$iteration]);
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
