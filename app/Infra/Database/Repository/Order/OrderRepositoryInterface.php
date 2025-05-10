<?php

namespace App\Infra\Database\Repository\Order;

use App\Domain\{Entity\AccountAsset, Entity\Order};
use App\Domain\Enum\OrderStatusEnum;

interface OrderRepositoryInterface
{
    public function addAccountAsset(AccountAsset $accountAsset): void;
    public function updateAccountAsset(string $accountId, string $assetId, int $quantity): void;
    public function saveOrder(Order $order): void;
    public function getOrderById(string $orderId): Order;
    /** @return Order[] */
    public function getOrdersByMarketIdAndStatus(string $marketId, OrderStatusEnum $status): array;
}
