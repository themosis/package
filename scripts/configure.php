<?php

declare(strict_types=1);

namespace Themosis;

use Themosis\Cli\AnsiColor;
use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Bold;
use Themosis\Cli\Collection;
use Themosis\Cli\Composable;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\PhpStdInput;
use Themosis\Cli\PhpStdOutput;
use Themosis\Cli\Prompt;
use Themosis\Cli\Reset;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\Validable;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\InvalidInput;

require dirname(__DIR__) . '/cli/autoload.php';

function rootPath(): string
{
    return \dirname(__DIR__);
}

function path(?string $path = null): string
{
    return $path ? rootPath() . DIRECTORY_SEPARATOR . trim($path, '\/') : rootPath();
}

function json(string $path): \stdClass
{
    return \json_decode(
        json: \file_get_contents($path),
        associative: false,
        flags: JSON_THROW_ON_ERROR,
    );
}

function sequenceDefault(string $text): Sequence
{
    return (new Sequence())
        ->add(new Reset())
        ->add(new ForegroundColor(AnsiColor::reverse()))
        ->add(new Text($text))
        ->add(new LineFeed())
        ->add(new ForegroundColor(AnsiColor::green()))
        ->add(new Bold())
        ->add(new Text("> "))
        ->add(new Reset())
        ->add(new ForegroundColor(AnsiColor::reverse()));
}

function sequenceTitle(string $text): Sequence
{
    return (new Sequence())
        ->add(new Text($text))
        ->add(new LineFeed())
        ->add(new Reset());
}

function sequencePredicate(string $text, string $expectation): Sequence
{
    return (new Sequence())
        ->add(new Reset())
        ->add(new Text($text))
        ->add(new ForegroundColor(AnsiColor::yellow()))
        ->add(new Text($expectation))
        ->add(new LineFeed())
        ->add(new ForegroundColor(AnsiColor::green()))
        ->add(new Bold())
        ->add(new Text("> "))
        ->add(new Reset())
        ->add(new ForegroundColor(AnsiColor::reverse()));
}

function sequenceError(string $text): Sequence
{
    return (new Sequence())
        ->add(new ForegroundColor(AnsiColor::red()))
        ->add(new Text($text))
        ->add(new LineFeed())
        ->add(new Reset());
}

$output = new PhpStdOutput();
$input = new PhpStdInput();

$title = " Themosis Package Tool ";

$introduction = new Message(
    sequence: (new Sequence())
        ->add(new BackgroundColor(AnsiColor::cyan()))
        ->add(new ForegroundColor(AnsiColor::base()))
        ->add(new Bold())
        ->add(new Text(str_repeat(" ", strlen($title))))
        ->add(new LineFeed())
        ->add(new Text($title))
        ->add(new LineFeed())
        ->add(new Text(str_repeat(" ", strlen($title))))
        ->add(new LineFeed())
        ->add(new Reset())
        ->add(new LineFeed()),
    output: $output,
);

$vendorName = (new Sequence())
    ->add(new Bold())
    ->add(new Text("vendor"))
    ->add(new Reset())
    ->add(new ForegroundColor(AnsiColor::reverse()));

$vendorPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a {$vendorName} name:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A vendor name is required.");

            throw new InvalidInput((string) $error);
        }

        if (preg_match('/^[a-z0-9]([_.-]?[a-z0-9]+)*$/', $value) !== 1) {
            $error = sequenceError("A vendor name must be a lowercased alphanumeric string without any special characters.");

            throw new InvalidInput((string) $error);
        }

        return $value;
    }),
);

$packageName = (new Sequence())
    ->add(new Bold())
    ->add(new Text("package"))
    ->add(new Reset())
    ->add(new ForegroundColor(AnsiColor::reverse()));

$packagePrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a {$packageName} name:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A package name is required.");

            throw new InvalidInput((string) $error);
        }

        if (preg_match('/^[a-z0-9](([_.]|-{1,2})?[a-z0-9]+)*$/', $value) !== 1) {
            $error = sequenceError("A package name must be a lowercased alphanumeric string without any special characters.");

            throw new InvalidInput((string) $error);
        }

        return strtolower($value);
    }),
);

$descriptionName = (new Sequence())
    ->add(new Bold())
    ->add(new Text("description"))
    ->add(new Reset())
    ->add(new ForegroundColor(AnsiColor::reverse()));

$descriptionPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a {$descriptionName}:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A description is required.");

            throw new InvalidInput((string) $error);
        }

        return $value;
    }),
);

$authorName = (new Sequence())
    ->add(new Bold())
    ->add(new Text("name"))
    ->add(new Reset())
    ->add(new ForegroundColor(AnsiColor::reverse()));

$authorEmail = (new Sequence())
    ->add(new Bold())
    ->add(new Text("email"))
    ->add(new Reset())
    ->add(new ForegroundColor(AnsiColor::reverse()));

$authorsPrompt = new Collection(
    element: (new Composable(
        element: new Message(
            sequence: sequenceTitle("Please insert an author."),
            output: $output,
        ),
    ))->add('name', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault("Enter author's {$authorName}:"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $name) {
            if (empty($name)) {
                $error = sequenceError("An author's name is required.");

                throw new InvalidInput((string) $error);
            }

            return $name;
        }),
    ))->add('email', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault("Enter author's {$authorEmail}:"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $email) {
            if (empty($email)) {
                $error = sequenceError("An author's email is required.");

                throw new InvalidInput((string) $error);
            }

            if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = sequenceError("Invalid email address.");

                throw new InvalidInput((string) $error);
            }

            return $email;
        }),
    )),
    prompt: new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequencePredicate("Would you like to add another author?", "(y/n)"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $value) {
            if (! in_array($value, ['y', 'Y', 'n', 'N'], true)) {
                $error = sequenceError(sprintf('Answer "%s" or "%s"', 'y', 'n'));

                throw new InvalidInput((string) $error);
            }

            return strtolower($value);
        }),
    ),
    predicate: function (string $value) {
        return 'y' === $value;
    },
);

$introduction();

$vendor = $vendorPrompt();
$package = $packagePrompt();
$description = $descriptionPrompt();
$authors = $authorsPrompt();

var_dump($vendor, $package, $description, $authors);
