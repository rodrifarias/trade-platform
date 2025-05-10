<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class InsufficientFundsException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Insufficient funds', $code, $previous);
    }
}
