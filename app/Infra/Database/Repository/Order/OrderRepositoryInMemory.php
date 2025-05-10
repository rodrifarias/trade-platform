<?php

namespace App\Infra\Database\Repository\Order;

use App\Domain\{Entity\AccountAsset, Entity\Order};
use App\Domain\Enum\OrderStatusEnum;

class OrderRepositoryInMemory implements OrderRepositoryInterface
{
    public function __construct(private array $assets = [], private array $orders = [])
    {
    }

    public function addAccountAsset(AccountAsset $accountAsset): void
    {
        $this->assets[] = $accountAsset;
    }

    public function updateAccountAsset(string $accountId, string $assetId, int $quantity): void
    {
        $wallets = array_filter($this->assets, fn(AccountAsset $a) => $a->accountId === $accountId && $a->assetId === $assetId);
        $keyWallet = array_key_first($wallets);
        $this->assets[$keyWallet]->quantity = $quantity;
    }

    public function saveOrder(Order $order): void
    {
        $this->orders[] = $order;
    }

    public function getOrderById(string $orderId): Order
    {
        $orders = array_filter($this->orders, fn(Order $o) => $o->orderId === $orderId);
        $keyOrder = array_key_first($orders);
        return $this->orders[$keyOrder];
    }

    /** @return Order[] */
    public function getOrdersByMarketIdAndStatus(string $marketId, OrderStatusEnum $status): array
    {
        return array_values(array_filter(
            $this->orders,
            fn(Order $o) => $o->marketId === $marketId && $o->status === $status,
        ));
    }
}
