<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use Themosis\Cli\PhpStdInput;
use Themosis\Cli\Prompt;

final class ScratchTest extends TestCase
{
    public function kind_of_outputs()
    {
        // Line output
        $line = new LineOutput();
        $line->write();

        // List output
        $list = new ListOutput(
            label: new LineOutput("Pick a color:"),
            options: [
                new ListItem('Red', 'red'),
                new ListItem('Green', 'green'),
                new ListItem('Blue', 'blue'),
            ]
        );
        $list->write();

        // Kind of prompt - A prompt is an object that can
        // ask something by writing elements to STDOUT but
        // that is also supporting STDIN in order to retrieve
        // user entered/picked data.
        $textPrompt = new Prompt(
            output: $line,
            input: new PhpStdInput(),
        );

        $selectPrompt = new Prompt(
            output: $list,
            input: new PhpStdInput()
        );
    }
    
    public function kind_of_inputs()
    {
        // TextInput
        $input = new TextInput(
            output: new LineOutput(),
        );
        $result = $input->read();

        // Select input
        $input = new SelectInput(
            output: new ListOutput(),
        );
        $result = $input->read();
    }
}
