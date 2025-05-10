<?php

namespace App\Domain\Usecase\GetOrder;

use App\Infra\Database\Repository\Order\OrderRepositoryInterface;

class GetOrder
{
    public function __construct(private OrderRepositoryInterface $walletRepository)
    {
    }

    public function execute(string $orderId): GetOrderOutput
    {
        $order = $this->walletRepository->getOrderById($orderId);
        return new GetOrderOutput(
            $order->orderId,
            $order->marketId,
            $order->accountId,
            $order->side->value,
            $order->quantity,
            $order->price,
            $order->status->value,
            $order->timestamp->format('Y-m-d H:i:s'),
        );
    }
}
