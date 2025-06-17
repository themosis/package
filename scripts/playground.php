<?php

use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Display;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\PhpStdInput;
use Themosis\Cli\PhpStdOutput;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Components\Package\Configurator\Prompts\TerminalComponentFactory;
use Themosis\Components\Package\Configurator\Stages\IntroductionStage;

require 'vendor/autoload.php';

$sequence = Sequence::make()
    ->attribute(BackgroundColor::blue())
    ->attribute(ForegroundColor::base())
    ->attribute(Display::bold())
    ->append(new Text("Hello World!"))
    ->append(Sequence::make()
        ->attribute(BackgroundColor::brightCyan())
        ->attribute(ForegroundColor::base())
        ->append(new Text("This is a test!")))
    ->append(Sequence::make()
        ->attribute(BackgroundColor::brightRed())
        ->attribute(ForegroundColor::base())
        ->append(new Text("Oops, something's wrong!")))
    ->append(Sequence::make()->attribute(Display::reset()))
    ->append(new LineFeed());

$output = new PhpStdOutput();
$output->write($sequence);

$prompt = new Prompt(
    element: new Message(
        sequence: Sequence::make()
            ->append(new Text("Insert a name:"))
            ->append(new LineFeed()),
        output: $output,
    ),
    input: new PhpStdInput(),
);

$result = $prompt();

$output->write(Sequence::make()
    ->attribute(Display::bold())
    ->attribute(ForegroundColor::green())
    ->append(new Text("You inserted: "))
    ->append(Sequence::make()->attribute(Display::reset()))
    ->append(Sequence::make()
        ->attribute(Display::bold())
        ->attribute(ForegroundColor::reverse())
        ->append(new Text($result)))
    ->append(Sequence::make()->attribute(Display::reset())
        ->append(new LineFeed())));

$intro = new IntroductionStage(
    factory: new TerminalComponentFactory(
        output: $output,
        input: new PhpStdInput(),
    )
);

$intro->run();
