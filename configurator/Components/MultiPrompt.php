<?php

declare(strict_types=1);

namespace Themosis\Components\Package\Configurator\Components;

use Closure;
use Themosis\Cli\Collection;
use Themosis\Cli\Composable;

final class MultiPrompt extends Component
{
    private Composable $composable;
    
    public function __construct(
        Paragraph $message,
        TextPrompt $more,
        Closure $predicate,
    ) {
        $this->composable = new Composable(
            element: $message->element,
        );
        
        $this->element = new Collection(
            element: $this->composable,
            prompt: $more->element,
            predicate: $predicate,
        );
    }

    public function add(string $name, TextPrompt $prompt): static
    {
        $this->composable->add(
            $name,
            $prompt->element,
        );
        
        return $this;
    }

    public function render(): static
    {
        $this->element->render();

        $this->notify();

        return $this;
    }

    public function value(): array
    {
        return $this->element->value();
    }
}
