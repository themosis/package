<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Tests\Prompts;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Input;
use Themosis\Cli\Output;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Components\Package\Configurator\Prompts\TerminalComponentFactory;
use Themosis\Components\Package\Configurator\Tests\TestCase;

final class ComponentFactoryTest extends TestCase
{
    #[Test]
    public function it_can_prompt_for_input_using_text_prompt(): void
    {
        $prompt = (new TerminalComponentFactory(
            output: new InMemoryOutput(),
            input: new InMemoryInput('Zoe'),
        ))
            ->textPrompt(
                message: 'What is your name?',
                validator: new CallbackValidator(function (string $value) {
                    return $value;
                }),
            );

        $prompt->render();

        $this->assertSame('Zoe', $prompt->value());
    }
}

final class InMemoryOutput implements Output
{
    public string $content = '';

    public function write(string $content): void
    {
        $this->content .= $content;
    }
}

final class InMemoryInput implements Input
{
    public function __construct(
        private string $input = '',
    ) {}

    public function read(): string
    {
        return $this->input;
    }
}
