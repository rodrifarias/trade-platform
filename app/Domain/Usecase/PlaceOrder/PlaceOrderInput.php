<?php

namespace App\Domain\Usecase\PlaceOrder;

readonly class PlaceOrderInput
{
    public function __construct(
        public string $marketId,
        public string $accountId,
        public string $side,
        public int $quantity,
        public float $price,
    ) {
    }
}
