<?php

namespace App\Domain\Entity;

use App\Domain\Enum\{OrderStatusEnum};
use App\Domain\Enum\OrderSideEnum;
use DateTime;
use Ramsey\Uuid\Uuid;

readonly class Order
{
    public function __construct(
        public string $orderId,
        public string $marketId,
        public string $accountId,
        public int $quantity,
        public float $price,
        public OrderSideEnum $side,
        public OrderStatusEnum $status,
        public DateTime $timestamp,
    ) {
    }

    public static function create(
        string $marketId,
        string $accountId,
        int $quantity,
        float $price,
        OrderSideEnum $side,
    ): self {
        $orderId = Uuid::uuid4()->toString();
        return new self($orderId, $marketId, $accountId, $quantity, $price, $side, OrderStatusEnum::OPEN, new DateTime());
    }
}
