<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

use PHPUnit\Framework\Attributes\Test;
use Themosis\Cli\TextProcessing\Split;
use Themosis\Components\Package\Configurator\Tests\TestCase;

final class SplitTest extends TestCase
{
    #[Test]
    public function it_can_split_text_using_default_length(): void
    {
        $lines = (new Split())('The Themosis Package tool will guide you to setup your PHP package or application.');

        $this->assertCount(2, $lines);
    }

    #[Test]
    public function it_can_split_text_using_user_defined_length(): void
    {
        $lines = (new Split(15))('The Themosis Package tool will guide you to setup your PHP package or application.');

        $this->assertCount(5, $lines);

    }
}
