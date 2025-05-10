<?php

namespace App\Domain\Usecase\GetDepth;

use App\Domain\Entity\Order;
use App\Domain\Enum\{OrderSideEnum, OrderStatusEnum};
use App\Infra\Database\Repository\Order\OrderRepositoryInterface;

class GetDepth
{
    public function __construct(private OrderRepositoryInterface $walletRepository)
    {
    }

    public function execute(GetDepthInput $input): GetDepthOutput
    {
        $orders = $this->walletRepository->getOrdersByMarketIdAndStatus($input->marketId, OrderStatusEnum::OPEN);
        $agrouppedOrders = $this->groupOrders($orders, $input->precision);
        $buys = array_values($agrouppedOrders[OrderSideEnum::BUY->value] ?? []);
        $sells = array_values($agrouppedOrders[OrderSideEnum::SELL->value] ?? []);
        return new GetDepthOutput($buys, $sells);
    }

    /**
     * @param Order[] $orders
     * @return array<int, array<string, int|string>
     */
    private function groupOrders(array $orders, int $precision): array
    {
        $group = [];

        foreach ($orders as $order) {
            $factor = pow(10, $precision);
            $price = floor($order->price / $factor) * $factor;
            $group[$order->side->value][$price] = [
                'quantity' => isset($group[$order->side->value][$price]['quantity']) ? ($group[$order->side->value][$price]['quantity'] + $order->quantity) : $order->quantity,
                'marketId' => $order->marketId,
                'price' => (float)$price
            ];
        }

        return $group;
    }
}
