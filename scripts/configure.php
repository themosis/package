<?php

declare(strict_types=1);

namespace Themosis;

function rootPath(): string {
    return dirname(__DIR__);
}

function path(?string $path = null): string {
    return $path ? rootPath().DIRECTORY_SEPARATOR.trim($path,'\/') : rootPath();
}

function json(string $path): \stdClass {
    return \json_decode(
        json: \file_get_contents($path),
        associative: false,
        flags: JSON_THROW_ON_ERROR,
    );
}

var_dump(path('composer.json'), json(path('composer.json')));
