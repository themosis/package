<?php

declare(strict_types=1);

namespace Themosis\Cli\Validation;

use RuntimeException;
use Themosis\Cli\Code;
use Throwable;

final class InvalidInput extends RuntimeException
{
    private Code $sequence;

    public function __construct(string $message, Code $sequence, ?Throwable $previous = null)
    {
        parent::__construct($message, 1, $previous);

        $this->sequence = $sequence;
    }

    public function getSequence(): Code
    {
        return $this->sequence;
    }
}
