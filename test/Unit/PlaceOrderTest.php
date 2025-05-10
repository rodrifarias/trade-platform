<?php

namespace Test\Unit;

use App\Domain\Enum\{OrderSideEnum, OrderStatusEnum};
use App\Domain\Usecase\GetOrder\GetOrder;
use App\Domain\Usecase\PlaceOrder\{PlaceOrder, PlaceOrderInput};
use App\Domain\Usecase\Signup\{Signup, SignupInput};
use App\Infra\Database\Repository\Account\AccountRepositoryInMemory;
use App\Infra\Database\Repository\Order\OrderRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
    public function testDeveCriarUmaOrdem(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $orderRepository = new OrderRepositoryInMemory();
        $input = new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123');
        $signup = new Signup($accountRepository);
        $accountId = $signup->execute($input);
        $placeOrderInput = new PlaceOrderInput('BTC/USD', $accountId->accountId, OrderSideEnum::SELL->value, 1, 3.20);
        $placeOrder = new PlaceOrder($accountRepository, $orderRepository);
        $getOrder = new GetOrder($orderRepository);
        $placeOrderOutput = $placeOrder->execute($placeOrderInput);
        $orderOutput = $getOrder->execute($placeOrderOutput->orderId);

        $this->assertSame($orderOutput->marketId, $placeOrderInput->marketId);
        $this->assertSame($orderOutput->side, $placeOrderInput->side);
        $this->assertSame($orderOutput->quantity, $placeOrderInput->quantity);
        $this->assertSame($orderOutput->price, $placeOrderInput->price);
        $this->assertSame($orderOutput->status, OrderStatusEnum::OPEN->value);
        $this->assertTrue((bool) preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $orderOutput->timestamp));
    }
}
