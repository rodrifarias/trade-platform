<?php

namespace App\Domain\Wallet\Exception;

use Exception;
use Throwable;

class AssetNotFoundException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Asset not found', $code, $previous);
    }
}
