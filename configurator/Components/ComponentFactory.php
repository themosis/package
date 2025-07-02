<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Closure;
use Themosis\Cli\Attribute;
use Themosis\Cli\Validation\Validator;

interface ComponentFactory
{
    public function block(string $text, Attribute ...$attributes): Block;

    public function title(string $text, Attribute ...$attributes): Title;
    
    public function paragraph(string $text, Attribute ...$attributes): Paragraph;
    
    public function textPrompt(string $message, Validator $validator): TextPrompt;

    public function multiPrompt(Paragraph $message, TextPrompt $more, Closure $predicate): MultiPrompt;
}
