<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Prompts;

use Themosis\Cli\Attribute;
use Themosis\Cli\Validation\Validator;

interface ComponentFactory
{
    public function block(string $text, Attribute ...$attributes): Block;

    public function paragraph(string $text, Attribute ...$attributes): Paragraph;
    
    public function textPrompt(string $message, Validator $validator): TextPrompt;
}
