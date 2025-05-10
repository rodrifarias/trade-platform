<?php

namespace App\Domain\Usecase\GetOrder;

readonly class GetOrderOutput
{
    public function __construct(
        public string $orderId,
        public string $marketId,
        public string $accountId,
        public string $side,
        public int $quantity,
        public float $price,
        public string $status,
        public string $timestamp,
    ) {
    }
}
