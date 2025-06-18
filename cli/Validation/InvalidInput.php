<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

use RuntimeException;
use Throwable;

final class InvalidInput extends RuntimeException
{
    private FormattedText $formattedText;

    public function __construct(string $message, FormattedText $formattedText, ?Throwable $previous = null)
    {
        parent::__construct($message, 1, $previous);

        $this->formattedText = $formattedText;
    }

    public function getFormattedText(): FormattedText
    {
        return $this->formattedText;
    }
}
