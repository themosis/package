<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Validation\Validator;

final class ValidatorTest extends TestCase
{
    #[Test]
    public function itCanAcceptCallable_andValidate()
    {
        $validator = new Validator(function () {
            return true;
        });

        $result = $validator->validate(function () {
            echo "Hello";
        });

        $this->assertSame("Hello", $result);
    }

    #[Test]
    public function itCanRepeatCallable_ifValidationFails()
    {
        $output = "";
        $validator = new Validator(function () {
            return false;
        });

        $prompt = function () use (&$output) {
            $output += "Call";
        };

        $validator->validate($prompt);
        $validator->validate($prompt);

        $this->assertSame("CallCall", $output);
    }
}
