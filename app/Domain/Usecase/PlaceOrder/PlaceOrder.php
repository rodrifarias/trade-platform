<?php

namespace App\Domain\Usecase\PlaceOrder;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderSideEnum;
use App\Infra\Database\Repository\Account\AccountRepositoryInterface;
use App\Infra\Database\Repository\Order\OrderRepositoryInterface;

class PlaceOrder
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function execute(PlaceOrderInput $input): PlaceOrderOutput
    {
        $account = $this->accountRepository->getAccountById($input->accountId);
        $order = Order::create($input->marketId, $account->accountId, $input->quantity, $input->price, OrderSideEnum::get($input->side));
        $this->orderRepository->saveOrder($order);
        return new PlaceOrderOutput($order->orderId);
    }
}
