<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Themosis\Cli\PhpStdInput;

class SimpleTestCase extends TestCase
{
    protected function setUp(): void
    {
        $path = dirname(__DIR__)."/autoload.php";
        require($path);
    }

    #[Test]
    public function itCanAssertTrue()
    {
        $input = new PhpStdInput();

        $this->assertTrue(true);
    }
}
