<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Themosis\Cli\Collection;
use Themosis\Cli\Composable;
use Themosis\Cli\Input;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\Output;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\Validable;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\InvalidInput;

final class PromptTest extends TestCase
{
    #[Test]
    public function itCanPromptUser_andExpectEmptyString()
    {
        $input = new LocalInMemoryInput("");

        $prompt = new Prompt(
            element: new Message(
                sequence: $sequence = Sequence::make()->append(new Text("Please insert nothing:")),
                output: $output = new LocalInMemoryOutput(),
            ),
            input: $input,
        );

        $result = $prompt();

        $this->assertEmpty($result);
        $this->assertSame($sequence->get(), $output->output);
    }

    #[Test]
    public function itCanPromptUser_andExpectStringResult()
    {
        $input = new LocalInMemoryInput(
            text: 'Emile Zolair',
        );

        $prompt = new Prompt(
            element: new Message(
                sequence: $sequence = Sequence::make()->append(new Text("What's your name?"))->append(new LineFeed()),
                output: $output = new LocalInMemoryOutput(),
            ),
            input: $input,
        );

        $result = $prompt();

        $this->assertSame('Emile Zolair', $result);
        $this->assertSame($sequence->get(), $output->output);
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

                    $errorSequence = Sequence::make()
                        ->append($text = new Text("Invalid name, try again!"))
                        ->append(new LineFeed());

                    throw new InvalidInput((string) $text, $errorSequence);
                }

                return $texts[$iteration];
            }
        );

        $prompt = new Validable(
            new Prompt(
                element: new Message(
                    sequence: Sequence::make()->append(new Text("Please insert your name:")),
                    output: $output,
                ),
                input: $input,
            ),
            $validator,
        );

        $result = $prompt();

        $this->assertSame(
	    // phpcs:ignore
            expected: "\u{001b}[mPlease insert your name:\u{001b}[mInvalid name, try again!\u{000a}\u{001b}[mPlease insert your name:",
            actual: $output->output
        );

        $this->assertSame('Julien', $result);
    }

    #[Test]
    public function itCanComposeWithAPrompt_AndValidateInput(): void
    {
        $output = new LocalInMemoryOutput();

        $prompt = (new Composable(
            element: new Message(
                sequence: Sequence::make()
                    ->append(new Text("Please enter an author:"))
                    ->append(new LineFeed()),
                output: $output,
            ),
        ));

        $prompt->add('name', new Validable(
            element: new Prompt(
                element: new Message(
                    sequence: Sequence::make()->append(new Text("Insert author's name:")),
                    output: $output,
                ),
                input: new LocalInMemoryInput("Jean Pass")
            ),
            validator: new CallbackValidator(function (string $value) {
                if (empty($value)) {
                    $errorSequence = Sequence::make()
                        ->append($text = new Text("Author's name is required."))
                        ->append(new LineFeed());

                    throw new InvalidInput((string) $text, $errorSequence);
                }

                return $value;
            })
        ));

        $iteration = 0;

        $prompt->add('email', new Validable(
            element: new Prompt(
                element: new Message(
                    sequence: Sequence::make()->append(new Text("Insert author's email:")),
                    output: $output
                ),
                input: new LocalInMemoryInput(implode(',', ["not-an-email", "jean@champagne.biz"])),
            ),
            validator: new CallbackValidator(function (string $value) use (&$iteration) {
                $value = explode(',', $value)[$iteration];

                if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $iteration++;

                    $errorSequence = Sequence::make()
                        ->append($text = new Text("Invalid email address."))
                        ->append(new LineFeed());

                    throw new InvalidInput((string) $text, $errorSequence);
                }

                return $value;
            })
        ));

        $result = $prompt();

        $this->assertSame(
	    // phpcs:ignore
	    expected: "\u{001b}[mPlease enter an author:\u{000a}\u{001b}[mInsert author's name:\u{001b}[mInsert author's email:\u{001b}[mInvalid email address.\u{000a}\u{001b}[mInsert author's email:",
            actual: $output->output
        );

        $this->assertSame(['parent' => null, 'name' => 'Jean Pass', 'email' => 'jean@champagne.biz'], $result);
    }

    #[Test]
    public function itCanAskToCollectPrompts_andGetOnlyOneEntry(): void
    {
        $output = new LocalInMemoryOutput();

        $prompt = new Collection(
            element: new Validable(
                element: new Prompt(
                    element: new Message(
                        sequence: Sequence::make()->append(new Text("Insert a name:"))
                            ->append(new LineFeed()),
                        output: $output,
                    ),
                    input: new LocalInMemoryInput('Lolita'),
                ),
                validator: new CallbackValidator(function (string $value) {
                    return $value;
                })
            ),
            prompt: new Validable(
                element: new Prompt(
                    element: new Message(
                        sequence: Sequence::make()->append(new Text("Add another name?(y/n)"))
                            ->append(new LineFeed()),
                        output: $output,
                    ),
                    input: new LocalInMemoryInput('n'),
                ),
                validator: new CallbackValidator(function (string $value) {
                    if (! in_array($value, ['y', 'n'])) {
                        $errorSequence = Sequence::make()
                            ->append($text = new Text("Enter either y or n."))
                            ->append(new LineFeed());

                        throw new InvalidInput((string) $text, $errorSequence);
                    }

                    return $value;
                })
            ),
            predicate: function (string $value) {
                return 'y' === $value;
            },
        );

        $result = $prompt();

        $this->assertTrue(is_array($result));
        $this->assertSame(['Lolita'], $result);

        $this->assertSame("\u{001b}[mInsert a name:\u{000a}\u{001b}[mAdd another name?(y/n)\u{000a}", $output->output);
    }

    #[Test]
    public function itCanCollectComposableElements(): void
    {
        $output = new LocalInMemoryOutput();

        $iteration = 0;

        $prompt = new Collection(
            element: (new Composable(
                element: new Message(
                    sequence: Sequence::make()
                        ->append(new Text("Add an author:"))
                        ->append(new LineFeed()),
                    output: $output,
                ),
            ))
                ->add('name', new Validable(
                    element: new Prompt(
                        element: new Message(
                            sequence: Sequence::make()
                                ->append(new Text("Enter author's name:"))
                                ->append(new LineFeed()),
                            output: $output,
                        ),
                        input: new LocalInMemoryInput(implode(',', ["Laurent", "Joao"]))
                    ),
                    validator: new CallbackValidator(function (string $value) use (&$iteration) {
                        $value = explode(',', $value)[$iteration];
                        return $value;
                    }),
                ))
                ->add('email', new Validable(
                    element: new Prompt(
                        element: new Message(
                            sequence: Sequence::make()
                                ->append(new Text("Enter author's email:"))
                                ->append(new LineFeed()),
                            output: $output,
                        ),
                        input: new LocalInMemoryInput(implode(',', ["laurent@web.com", "joao@web.pt"]))
                    ),
                    validator: new CallbackValidator(function (string $value) use (&$iteration) {
                        $value = explode(',', $value)[$iteration];
                        return $value;
                    }),
                )),
            prompt: new Validable(
                element: new Prompt(
                    element: new Message(
                        sequence: Sequence::make()
                            ->append(new Text("Would you like to add an author?(y/n)"))
                            ->append(new LineFeed()),
                        output: $output,
                    ),
                    input: new LocalInMemoryInput(implode(',', ["y", "n"])),
                ),
                validator: new CallbackValidator(function (string $value) use (&$iteration) {
                    $value = explode(',', $value)[$iteration];
                    $iteration++;

                    return $value;
                })
            ),
            predicate: function (string $value) {
                return 'y' === $value;
            },
        );

        $result = $prompt();

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        $this->assertSame([
            'parent' => null,
            'name' => 'Laurent',
            'email' => 'laurent@web.com',
        ], $result[0]);

        $this->assertSame([
            'parent' => null,
            'name' => 'Joao',
            'email' => 'joao@web.pt',
        ], $result[1]);

        $this->assertSame(
	    // phpcs:ignore
	    expected: "\u{001b}[mAdd an author:\u{000a}\u{001b}[mEnter author's name:\u{000a}\u{001b}[mEnter author's email:\u{000a}\u{001b}[mWould you like to add an author?(y/n)\u{000a}\u{001b}[mAdd an author:\u{000a}\u{001b}[mEnter author's name:\u{000a}\u{001b}[mEnter author's email:\u{000a}\u{001b}[mWould you like to add an author?(y/n)\u{000a}",
            actual: $output->output
        );
    }

    #[Test]
    public function itCanThrowException_whenDeclaringParentAdditionalElement_onComposable(): void
    {
        $this->expectException(RuntimeException::class);

        $output = new LocalInMemoryOutput();

        (new Composable(
            element: new Message(
                sequence: (Sequence::make()->append(new Text("This is a message."))),
                output: $output,
            ),
        ))
        ->add('parent', new Message(
            sequence: (Sequence::make()->append(new Text("Message from child element."))),
            output: $output,
        ));
    }

    #[Test]
    public function itCanThrowException_whenDeclaringChildElement_withSameName_onComposable(): void
    {
        $this->expectException(RuntimeException::class);

        $output = new LocalInMemoryOutput();

        (new Composable(
            element: new Message(
                sequence: (Sequence::make()->append(new Text("This is a message."))),
                output: $output,
            ),
        ))
        ->add('name', new Message(
            sequence: (Sequence::make()->append(new Text("Message from child element."))),
            output: $output,
        ))
        ->add('name', new Message(
            sequence: (Sequence::make()->append(new Text("Message from another child element."))),
            output: $output,
        ));
    }
}

// phpcs:disable
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
    ) {
    }

    public function read(): string
    {
        return $this->text;
    }
}
// phpcs:enable
