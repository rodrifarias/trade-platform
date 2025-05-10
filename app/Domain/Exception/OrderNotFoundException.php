<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class OrderNotFoundException extends Exception
{
    public function __construct(string $orderId, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct('Order [' . $orderId . '] not found', $code, $previous);
    }
}
