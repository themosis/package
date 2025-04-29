<?php

namespace Themosis\Cli;

use Themosis\Cli\Validation\Validator;

interface Input extends Validator
{
    public function read(): string;
}
