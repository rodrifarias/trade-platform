<?php

namespace App\Domain\Wallet\Exception;

use Exception;
use Throwable;

class InsufficientBalanceException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Insufficient balance', $code, $previous);
    }
}
