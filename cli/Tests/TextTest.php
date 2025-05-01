<?php

declare(strict_types=1);

namespace Themosis\Cli\Tests;

final class TextTest extends TestCase
{
    public function buildText()
    {
        $text = new Text("Hello World");

        $greenText = new Green($text);
        $blueBg = new BlueBackground();

        $sequence = new Sequence();

        $foreground = new ForegroundColor(new Blue());
        $background = new BackgroundColor(new White());

        $sequence
            ->add($foreground)
            ->add($background)
            ->add(new Text("Hello World"))
            ->add(new ForegroundColor(new Red()))
            ->add(BackgroundColor::default())
            ->add("Error");
    }
}
