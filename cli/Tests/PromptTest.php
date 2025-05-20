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
        $input = new LocalInMemoryInput("");

        $prompt = new Prompt(
            output: $output = new LocalInMemoryOutput(),
            input: $input,
        );

        $result = $prompt
            ->render($sequence = (new Sequence())->add(new Text("Please insert nothing:")))
            ->value();

        $this->assertEmpty($result);
        $this->assertSame($sequence->content(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $input = new LocalInMemoryInput(
            text: 'James Bond',
        );

        $prompt = new Prompt(
            output: $output = new LocalInMemoryOutput(),
            input: $input,
        );

        $result = $prompt
            ->render($sequence = (new Sequence())->add(new Text("What's your name?\n")))
            ->value();

        $this->assertSame('James Bond', $result);
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
                output: $output,
                input: $input,
            ),
            $validator,
        );

        $result = $prompt
            ->render((new Sequence())->add(new Text("Please insert your name:\n")))
            ->value();

        $this->assertSame("Please insert your name:\nInvalid name, try again!\nPlease insert your name:\n", $output->output);
        $this->assertSame('Julien', explode(',', $result)[$iteration]);
    }

    public function itCanCompose_MultiplePromptsAndValidate_EachInput(): void
    {
        $output = new LocalInMemoryOutput();
        $input = new LocalInMemoryInput(
            text: "Anything",
        );

        // $prompt = (new Composable(
        //     new Prompt(
        //         message: (new Sequence())->add(new Text("Enter an author:\n")),
        //         output: $output,
        //         input: $input,
        //     )))
        //     ->add(
        //         new Validable(
        //             new Prompt(
        //                 message: (new Sequence())->add(new Text("Enter the author's name?:\n")),
        //                 output: $output,
        //                 input: $input,
        //             ),
        //             new CallbackValidator(function (string $name) {
        //                 if ($name !== 'Julien') {
        //                     throw new ValidationException("Invalid author's name.\n");
        //                 }
        //             }),
        //             $output,
        //         )
        //     )
        //     ->add(
        //         new Validable(
        //             new Prompt(
        //                 message: (new Sequence())->add(new Text("Enter the author's email?:\n")),
        //                 output: $output,
        //                 input: $input,
        //             ),
        //             new CallbackValidator(function (string $email) {
        //                 if (false === filter_var($email, FILTER_SANITIZE_EMAIL)) {
        //                     throw new ValidationException("Invalid author's email.\n");
        //                 }
        //             }),
        //             $output,
        //         )
        //     );
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
