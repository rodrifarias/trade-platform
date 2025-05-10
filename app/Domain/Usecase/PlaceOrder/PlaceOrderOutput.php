<?php

namespace App\Domain\Usecase\PlaceOrder;

readonly class PlaceOrderOutput
{
    public function __construct(public string $orderId)
    {
    }
}
