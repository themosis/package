<?php

declare(strict_types=1);

spl_autoload_register(
    function ($class) {
        $name = str_replace('Themosis\\Cli\\', '', $class);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';

        require __DIR__ . DIRECTORY_SEPARATOR . $path;
    },
    true,
    false
);
