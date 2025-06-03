<?php

declare(strict_types=1);

namespace Themosis;

use Themosis\Cli\BackgroundColor;
use Themosis\Cli\Code;
use Themosis\Cli\Collection;
use Themosis\Cli\Composable;
use Themosis\Cli\CsiSequence;
use Themosis\Cli\Display;
use Themosis\Cli\ForegroundColor;
use Themosis\Cli\LineFeed;
use Themosis\Cli\Message;
use Themosis\Cli\PhpStdInput;
use Themosis\Cli\PhpStdOutput;
use Themosis\Cli\Prompt;
use Themosis\Cli\Sequence;
use Themosis\Cli\Text;
use Themosis\Cli\Validable;
use Themosis\Cli\Validation\CallbackValidator;
use Themosis\Cli\Validation\InvalidInput;
use Throwable;

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

function sequenceDefault(Code $sequence): CsiSequence
{
    return Sequence::make()
        ->append(
            $sequence,
            new LineFeed(),
            Sequence::make()
                ->attributes(ForegroundColor::green(), Display::bold())
                ->append(new Text("> ")),
            Sequence::make()
                ->attribute(Display::reset()),
        );
}

function sequencePredicate(Code $text, Code $expectation): CsiSequence
{
    return Sequence::make()
        ->append(
            $text,
            Sequence::make()
                ->attribute(ForegroundColor::yellow())
                ->append($expectation),
            Sequence::make()
                ->attribute(Display::reset())
                ->append(new LineFeed()),
            Sequence::make()
                ->attributes(ForegroundColor::green(), Display::bold())
                ->append(new Text("> ")),
            Sequence::make()
                ->attribute(Display::reset()),
        );
}

function sequenceError(Code $sequence): CsiSequence
{
    return Sequence::make()
        ->attribute(ForegroundColor::red())
        ->append(
            $sequence,
            new LineFeed(),
            Sequence::make()->attribute(Display::reset()),
        );
}

$output = new PhpStdOutput();
$input = new PhpStdInput();

$title = " Themosis Package Tool ";

$introduction = new Message(
    sequence: Sequence::make()
        ->attributes(BackgroundColor::cyan(), ForegroundColor::base(), Display::bold())
        ->append(
            new Text(str_repeat(" ", strlen($title))),
            new LineFeed(),
            new Text($title),
            new LineFeed(),
            new Text(str_repeat(" ", strlen($title))),
            new LineFeed(),
            Sequence::make()
                ->attribute(Display::reset())
                ->append(
                    new LineFeed(),
                    new Text("This tool will guide you through setting up your PHP package."),
                    new LineFeed(),
                    new LineFeed(),
                ),
        ),
    output: $output,
);

$vendor = Sequence::make()
    ->attribute(Display::bold())
    ->append(
        new Text("vendor"),
        Sequence::make()->attribute(Display::reset()),
    );

$vendorPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault(new Text("Please insert a {$vendor} name:")),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $message = "A vendor name is required.";

            throw new InvalidInput($message, sequenceError(new Text($message)));
        }

        if (preg_match('/^[a-z0-9]([_.-]?[a-z0-9]+)*$/', $value) !== 1) {
            $message = "A vendor name must be a lowercased alphanumeric string without any special characters.";

            throw new InvalidInput($message, sequenceError(new Text($message)));
        }

        return $value;
    }),
);

$package = Sequence::make()
    ->attribute(Display::bold())
    ->append(
        new Text("package"),
        Sequence::make()
            ->attribute(Display::reset())
    );

$packagePrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault(new Text("Please insert a {$package} name:")),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $message = "A package name is required.";

            throw new InvalidInput($message, sequenceError(new Text($message)));
        }

        if (preg_match('/^[a-z0-9](([_.]|-{1,2})?[a-z0-9]+)*$/', $value) !== 1) {
            $message = "A package name must be a lowercased alphanumeric string without any special characters.";

            throw new InvalidInput($message, sequenceError(new Text($message)));
        }

        return $value;
    }),
);

$description = Sequence::make()
    ->attribute(Display::bold())
    ->append(
        new Text("description"),
        Sequence::make()->attribute(Display::reset())
    );

$descriptionPrompt = new Validable(
    element: new Prompt(
        element: new Message(
            sequence: sequenceDefault(new Text("Please insert a {$description}:")),
            output: $output,
        ),
        input: $input,
    ),
    validator: new CallbackValidator(function (string $value) {
        if (empty($value)) {
            $message = "A description is required.";

            throw new InvalidInput($message, sequenceError(new Text($message)));
        }

        return $value;
    }),
);

$authorName = Sequence::make()
    ->attribute(Display::bold())
    ->append(
        new Text("name"),
        Sequence::make()->attribute(Display::reset())
    );

$authorEmail = Sequence::make()
    ->attribute(Display::bold())
    ->append(
        new Text("email"),
        Sequence::make()->attribute(Display::reset())
    );

$authorsPrompt = new Collection(
    element: (new Composable(
        element: new Message(
            sequence: Sequence::make()
                ->append(
                    new Text("Please insert an author."),
                    new LineFeed(),
                ),
            output: $output,
        ),
    ))->add('name', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault(new Text("Enter author's {$authorName}:")),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $name) {
            if (empty($name)) {
                $message = "An author's name is required.";

                throw new InvalidInput($message, sequenceError(new Text($message)));
            }

            return $name;
        }),
    ))->add('email', new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequenceDefault(new Text("Enter author's {$authorEmail}:")),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $email) {
            if (empty($email)) {
                $message = "An author's email is required.";

                throw new InvalidInput($message, sequenceError(new Text($message)));
            }

            if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Invalid email address.";

                throw new InvalidInput($message, sequenceError(new Text($message)));
            }

            return $email;
        }),
    )),
    prompt: new Validable(
        element: new Prompt(
            element: new Message(
                sequence: sequencePredicate(new Text("Would you like to add another author?"), new Text("(y/n)")),
                output: $output,
            ),
            input: $input,
        ),
        validator: new CallbackValidator(function (string $value) {
            if (! in_array($value, ['y', 'Y', 'n', 'N'], true)) {
                $message = sprintf('Answer "%s" or "%s"', 'y', 'n');

                throw new InvalidInput($message, sequenceError(new Text($message)));
            }

            return strtolower($value);
        }),
    ),
    predicate: function (string $value) {
        return 'y' === $value;
    },
);

try {
    $introduction();

    $vendor = $vendorPrompt();
    $package = $packagePrompt();
    $description = $descriptionPrompt();
    $authors = $authorsPrompt();

    var_dump($vendor, $package, $description, $authors);
} catch (Throwable $exception) {
    $output->write(
        Sequence::make()
            ->attribute(ForegroundColor::red())
            ->append(
                new LineFeed(),
                new Text($exception->getMessage()),
                new LineFeed(),
                Sequence::make()
                    ->attribute(Display::reset()),
            )
            ->get()
    );
} finally {
    return 0;
}
