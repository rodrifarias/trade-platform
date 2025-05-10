<?php

namespace App\Infra\Database\Repository\Order;

use App\Domain\Entity\{AccountAsset, Order};
use App\Domain\Enum\{OrderSideEnum, OrderStatusEnum};
use App\Domain\Exception\OrderNotFoundException;
use DateTime;
use Hyperf\DbConnection\Db;

class OrderRepositoryDatabase implements OrderRepositoryInterface
{
    public function addAccountAsset(AccountAsset $accountAsset): void
    {
        Db::table('account_asset')->insert([
            'account_id' => $accountAsset->accountId,
            'asset_id' => $accountAsset->assetId,
            'quantity' => $accountAsset->getQuantity(),
        ]);
    }

    public function updateAccountAsset(string $accountId, string $assetId, int $quantity): void
    {
        Db::table('account_asset')
            ->where('account_id', $accountId)
            ->where('asset_id', $assetId)
            ->update(['quantity' => $quantity]);
    }

    public function saveOrder(Order $order): void
    {
        Db::table('order')->insert([
            'order_id' => $order->orderId,
            'market_id' => $order->marketId,
            'account_id' => $order->accountId,
            'quantity' => $order->quantity,
            'price' => $order->price,
            'side' => $order->side->value,
            'status' => $order->status->value,
            'timestamp' => $order->timestamp->format('Y-m-d H:i:s'),
        ]);
    }

    public function getOrderById(string $orderId): Order
    {
        $order = Db::table('order')
            ->select(['order_id', 'market_id', 'account_id', 'quantity', 'price', 'side', 'status', 'timestamp'])
            ->where('order_id', $orderId)
            ->first();

        throwIf(!$order, new OrderNotFoundException($orderId));;

        return new Order(
            $order->order_id,
            $order->market_id,
            $order->account_id,
            $order->quantity,
            $order->price,
            OrderSideEnum::get($order->side),
            OrderStatusEnum::get($order->status),
            new DateTime($order->timestamp),
        );
    }

    /** @return Order[] */
    public function getOrdersByMarketIdAndStatus(string $marketId, OrderStatusEnum $status): array
    {
        $orders = Db::table('order')
            ->select(['id', 'market_id', 'account_id', 'quantity', 'price', 'side', 'status', 'timestamp'])
            ->where('market_id', $marketId)
            ->where('status', $status->value)
            ->get();

        return array_map(fn ($o) => new Order(
            $o->id,
            $o->market_id,
            $o->account_id,
            $o->quantity,
            $o->price,
            $o->side,
            $o->status,
            new DateTime($o->timestamp),
        ), $orders->toArray());
    }
}
