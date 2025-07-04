<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Closure;
use Themosis\Cli\Attribute;
use Themosis\Cli\Input;
use Themosis\Cli\Output;
use Themosis\Cli\Validation\Validator;

final class TerminalComponentFactory implements ComponentFactory
{
    public function __construct(
        private Output $output,
        private Input $input,
    ) {}

    public function withInput(Input $input): self
    {
        return new self(
            output: $this->output,
            input: $input,
        );
    }

    public function block(string $text, Attribute ...$attributes): Block
    {
        return new Block(
            $this->output,
            $text,
            ...$attributes,
        );
    }

    public function title(string $text, Attribute ...$attributes): Title
    {
        return new Title(
            $this->output,
            $text,
            ...$attributes,
        );
    }

    public function paragraph(string $text, Attribute ...$attributes): Paragraph
    {
        return new Paragraph(
            $this->output,
            $text,
            ...$attributes,
        );
    }

    public function list(Attribute ...$attributes): TextList
    {
        return new TextList(
            $this->output,
            ...$attributes,
        );
    }

    public function textPrompt(string $message, Validator $validator): TextPrompt
    {
        return new TextPrompt(
            output: $this->output,
            input: $this->input,
            message: $message,
            validator: $validator,
        );
    }

    public function multiPrompt(Paragraph $message, TextPrompt $more, Closure $predicate): MultiPrompt
    {
        return new MultiPrompt(
            message: $message,
            more: $more,
            predicate: $predicate,
        );
    }
}
