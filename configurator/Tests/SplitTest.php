<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use Themosis\Components\Package\Configurator\Split;
use Themosis\Components\Package\Configurator\Tests\TestCase;

final class SplitTest extends TestCase
{
    #[Test]
    public function it_can_split_text(): void
    {
        $splitter = new Split();
        $splitter->split('The Themosis Package tool will guide you to setup your PHP package or application.');

        var_dump($splitter->get());
    }
}
