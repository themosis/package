<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Composable;
use Themosis\Cli\Input;
use Themosis\Cli\Message;
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
        $input = new LocalInMemoryInput("");

        $prompt = new Prompt(
            element: new Message(
                sequence: $sequence = (new Sequence())->add(new Text("Please insert nothing:")),
                output: $output = new LocalInMemoryOutput(),
            ),
            input: $input,
        );

        $result = $prompt
            ->render()
            ->value();

        $this->assertEmpty($result);
        $this->assertSame($sequence->content(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $input = new LocalInMemoryInput(
            text: 'Emile Zolair',
        );

        $prompt = new Prompt(
            element: new Message(
                sequence: $sequence = (new Sequence())->add(new Text("What's your name?\n")),
                output: $output = new LocalInMemoryOutput(),
            ),
            input: $input,
        );

        $result = $prompt
            ->render()
            ->value();

        $this->assertSame('Emile Zolair', $result);
        $this->assertSame($sequence->content(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andShouldRestartIfInvalidInput(): void
    {
        $iteration = 0;

        $output = new LocalInMemoryOutput();
        $input = new LocalInMemoryInput(
            text: implode(',', ["", "Julien"]),
        );

        $validator = new CallbackValidator(
            function (string $value) use (&$iteration) {
                $texts = explode(',', $value);

                if (empty($texts[$iteration])) {
                    $iteration++;
                    throw new ValidationException("Invalid name, try again!\n");
                }
            }
        );

        $prompt = new Validable(
            new Prompt(
                element: new Message(
                    sequence: (new Sequence())->add(new Text("Please insert your name:\n")),
                    output: $output,
                ),
                input: $input,
            ),
            $validator,
        );

        $result = $prompt
            ->render()
            ->value();

        $this->assertSame("Please insert your name:\nInvalid name, try again!\nPlease insert your name:\n", $output->output);
        $this->assertSame('Julien', explode(',', $result)[$iteration]);
    }

    #[Test]
    public function itCanComposeWithAPrompt_AndValidateInput(): void
    {
        $output = new LocalInMemoryOutput();

        $prompt = (new Composable(
            parent: new Message(
                sequence: (new Sequence())->add(new Text("Please enter an author:\n")),
                output: $output,
            ),
        ));

        $prompt->add('name', new Validable(
            element: new Prompt(
                element: new Message(
                    sequence: (new Sequence())->add(new Text("Insert author's name:\n")),
                    output: $output,
                ),
                input: new LocalInMemoryInput("Jean Pass")
            ),
            validator: new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    throw new ValidationException("Author's name is required.\n");
                }
            })
        ));

        $result = $prompt
            ->render()
            ->value();

        $this->assertSame("Please enter an author:\nInsert author's name:\n", $output->output);
        $this->assertSame(['parent' => null, 'name' => 'Jean Pass'], $result);
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
