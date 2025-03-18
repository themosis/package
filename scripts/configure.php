<?php

declare(strict_types=1);

namespace Themosis;

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

function prompt(string $message, ?string &$value): void
{
    fwrite(STDOUT, $message."\n");
    $value = rtrim(fgets(STDIN));
}

function writeLine(string $message): void
{
    fwrite(STDOUT, $message."\n");
}

$name = null;
prompt("What's your name?", $name);
writeLine("Welcome, {$name}!");

