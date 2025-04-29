<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\Action;
use Themosis\Cli\Input;
use Themosis\Cli\Validation\Validator;

final class ValidatorTest extends TestCase
{
    #[Test]
    public function itCanAcceptActionAsClosure_andValidate()
    {
        // Validator could be a wrapper around an input.
        // I could pass the validator as an input, but it has
        // internal knowledge about an invalid received input.
        // A prompt can then verify validated data, if not, execute
        // itself one more time.
        $validator = new Validator(function () {
            return true;
        });

        $result = $validator->validate(function () {
            echo "Hello";
        });

        $this->assertSame("Hello", $result);
    }

    #[Test]
    public function itCanRepeatAction_ifValidationFails()
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

class CallableAction implements Action
{
    public function __construct(
        private Input $input,
    ) {}

    

    public function input(): Input
    {
        return $this->input;
    }
}
