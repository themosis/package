<?php

declare(strict_types=1);

namespace Themosis;

use Themosis\Cli\AnsiColor;
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
use Themosis\Cli\Validation\ValidationException;

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
        ->add(new ForegroundColor(AnsiColor::green()))
        ->add(new Text($text))
        ->add(new LineFeed())
        ->add(new Reset());
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

$vendorPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a vendor name:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A vendor name is required.");

            throw new ValidationException((string) $error);
        }

        return strtolower($value);
    }),
);

$packagePrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a package name:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A package name is required.");

            throw new ValidationException((string) $error);
        }

        if (strpos($value, '/') !== false) {
            $error = sequenceError("A '/' character is not allowed in a vendor name.");

            throw new ValidationException((string) $error);
        }

        return strtolower($value);
    }),
);

$descriptionPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault("Please insert a description:"),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $error = sequenceError("A description is required.");

            throw new ValidationException((string) $error);
        }

        return $value;
    }),
);

$authorsPrompt = new Collection(
    element: (new Composable(
        element: new Message(
            sequence: sequenceDefault("Please insert an author:"),
            output: $output,
        ),
    ))->add('name', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault("Enter author's name:"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $name) {
            if (empty($name)) {
                $error = sequenceError("An author's name is required.");

                throw new ValidationException((string) $error);
            }

            return $name;
        }),
    ))->add('email', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault("Enter author's email:"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $email) {
            if (empty($email)) {
                $error = sequenceError("An author's email is required.");

                throw new ValidationException((string) $error);
            }

            if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = sequenceError("Invalid email address.");

                throw new ValidationException((string) $error);
            }

            return $email;
        }),
    )),
    prompt: new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault("Would you like to add another author?(y/n)"),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $value) {
            if (! in_array($value, ['y', 'Y', 'n', 'N'], true)) {
                $error = sequenceError(sprintf('Answer "%s" or "%s"', 'y', 'n'));

                throw new ValidationException((string) $error);
            }

            return strtolower($value);
        }),
    ),
    predicate: function (string $value) {
        return 'y' === $value;
    },
);

$vendor = $vendorPrompt();
$package = $packagePrompt();
$description = $descriptionPrompt();
$authors = $authorsPrompt();

var_dump($vendor, $package, $description, $authors);
