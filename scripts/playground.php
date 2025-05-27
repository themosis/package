<?php

use Themosis\Cli\AnsiColor;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\PhpStdInput;
use Themosis\Cli\PhpStdOutput;
use Themosis\Cli\Prompt;
use Themosis\Cli\Reset;
use Themosis\Cli\GraphicSequence;
use Themosis\Cli\Text;

require './cli/autoload.php';

$sequence = (new GraphicSequence())
    ->add(new BackgroundColor(AnsiColor::blue()))
    ->add(new ForegroundColor(AnsiColor::brightBlack()))
    ->add(new Text("This text has a "))
    ->add(new BackgroundColor(AnsiColor::brightRed()))
    ->add(new ForegroundColor(AnsiColor::yellow()))
    ->add(new Text('red background and a yellow foreground'))
    ->add(new Reset())
    ->add(new LineFeed());

$output = new PhpStdOutput();
$output->write($sequence);

$prompt = new Prompt(
    element: new Message(
        sequence: (new GraphicSequence())->add(new Text("Insert a name:\n")),
        output: $output,
    ),
    input: new PhpStdInput(),
);

$result = $prompt();

$output->write(
    (new GraphicSequence())
        ->add(new BackgroundColor(AnsiColor::green()))
        ->add(new ForegroundColor(AnsiColor::black()))
        ->add(new Text("Success:"))
        ->add(new BackgroundColor(AnsiColor::white()))
        ->add(new ForegroundColor(AnsiColor::black()))
        ->add(new Text(" {$result}"))
        ->add(new Reset())
        ->add(new LineFeed())
);
