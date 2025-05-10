<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class AccountAssetNotFoundException extends Exception
{
    public function __construct(string $message = 'Account asset not found', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
