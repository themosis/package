<?php

use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Color;
use Themosis\Cli\Display;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\PhpStdInput;
use Themosis\Cli\PhpStdOutput;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;

require './cli/autoload.php';

$sequence = Sequence::display()
    ->attribute(new BackgroundColor(Color::blue()))
    ->attribute(new ForegroundColor(Color::base()))
    ->attribute(Display::bold())
    ->append(new Text("Hello World!"))
    ->append(Sequence::display()
        ->attribute(new BackgroundColor(Color::brightCyan()))
        ->attribute(new ForegroundColor(Color::base()))
        ->append(new Text("This is a test!")))
    ->append(Sequence::display()
        ->attribute(new BackgroundColor(Color::brightRed()))
        ->attribute(new ForegroundColor(Color::base()))
        ->append(new Text("Oops, something's wrong!")))
    ->append(Sequence::display()->attribute(Display::reset()))
    ->append(new LineFeed());

$output = new PhpStdOutput();
$output->write($sequence);

$prompt = new Prompt(
    element: new Message(
        sequence: Sequence::display()
            ->append(new Text("Insert a name:"))
            ->append(new LineFeed()),
        output: $output,
    ),
    input: new PhpStdInput(),
);

$result = $prompt();

$output->write(Sequence::display()
    ->attribute(Display::bold())
    ->attribute(new ForegroundColor(Color::green()))
    ->append(new Text("You inserted: "))
    ->append(Sequence::display()->attribute(Display::reset()))
               ->append(Sequence::display()
                        ->attribute(Display::bold())
                        ->attribute(new ForegroundColor(Color::reverse()))
                        ->append(new Text($result)))
               ->append(Sequence::display()->attribute(Display::reset())
                        ->append(new LineFeed())));
