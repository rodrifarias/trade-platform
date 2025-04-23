<?php

namespace App\Domain\Account\Exception;

use Throwable;

class AccountNotFoundException extends \Exception
{
    public function __construct(string $accountId, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct('Account [' . $accountId . '] not found', $code, $previous);
    }
}
