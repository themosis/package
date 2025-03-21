<?php

declare(strict_types=1);

namespace Themosis;

use Closure;

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

function prompt(string $message, string $validation): string
{
    fwrite(STDOUT, $message . "\n");
    $eval = function ($callback) use ($message, $validation) {
        return $callback($message, $validation);
    };

    return call_user_func($validation, rtrim(fgets(STDIN)), $eval);
}

function iterablePrompt(string $message, string $addMessage,  Closure ...$prompts): array
{
    $items = [];

    $add = function (Closure $next, &$items) use ($addMessage, $prompts) {
        $item = [];

        array_map(function (Closure $prompt) use (&$item) {
            [$key, $value] = $prompt();

            $item[$key] = $value;
        }, $prompts);

        $items[] = $item;

        $response = prompt($addMessage , 'Themosis\validateYesOrNo');

        if ($response === 'y') {
            $next($next, $items);
        }
    };

    writeLine($message);
    $add($add, $items);

    return $items;
}

function writeLine(string $message): void
{
    fwrite(STDOUT, $message . "\n");
}

function validateVendor(string $vendor, Closure $eval): string
{
    if (empty($vendor)) {
        return $eval(function ($message, $validation) {
            writeLine("Vendor name cannot be empty.");
            return prompt($message, $validation);
        });
    }

    if (strpos($vendor, '/') !== false) {
        return $eval(function ($message, $validation) {
            writeLine("Vendor name cannot contain '/' characters.");
            return prompt($message, $validation);
        });
    }

    return \strtolower($vendor);
}

function validatePackage(string $package, Closure $eval): string
{
    if (empty($package)) {
        return $eval(function ($message, $validation) {
            writeLine("Package name cannot be empty.");
            return prompt($message, $validation);
        });
    }

    return \strtolower($package);
}

function validateDescription(string $description, Closure $eval): string
{
    if (empty($description)) {
        return $eval(function ($message, $validation) {
            writeLine("Description cannot be empty.");
            return prompt($message, $validation);
        });
    }

    return $description;
}

function validateYesOrNo(string $confirm): string
{
    if (in_array($confirm, ['y', 'Y', 'Yes', 'yes', 'YES'])) {
        return 'y';
    }

    return 'n';
}

function validateText(string $text): string
{
    return $text;
}

/*----------------------------------------------------------------------------*/
$vendor = prompt("Please insert vendor name:", 'Themosis\validateVendor');
$package = prompt("Please insert package name:", 'Themosis\validatePackage');
$description = prompt("Please insert a description:", 'Themosis\validateDescription');
$authors = iterablePrompt(
    "Please add an author:",
    "Add another author?(y/n)",
    function () {
        $name = prompt("Author name:", 'Themosis\validateText');
        return ['name', $name];
    },
    function () {
        $email = prompt("Author email:", 'Themosis\validateText');
        return ['email', $email];
    }
);

writeLine("You inserted: {$vendor}/{$package}: {$description}");
var_dump($authors);
