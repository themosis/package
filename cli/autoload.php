<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'simpletestcase' => '/Tests/SimpleTestCase.php',
                'themosis\\cli\\input' => '/Input.php',
                'themosis\\cli\\output' => '/Output.php',
                'themosis\\cli\\phpstdinput' => '/PhpStdInput.php',
                'themosis\\cli\\phpstdoutput' => '/PhpStdOutput.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
