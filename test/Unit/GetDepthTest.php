<?php

namespace Test\Unit;

use App\Domain\Enum\OrderSideEnum;
use App\Domain\Usecase\GetDepth\{GetDepth, GetDepthInput};
use App\Domain\Usecase\PlaceOrder\{PlaceOrder, PlaceOrderInput};
use App\Domain\Usecase\Signup\{Signup, SignupInput};
use App\Infra\Database\Repository\Account\AccountRepositoryInMemory;
use App\Infra\Database\Repository\Order\OrderRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class GetDepthTest extends TestCase
{
    public function testDeveRetornarAListaDeComprasEVendasAgrupadasPorPrecisao(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $OrderRepository = new OrderRepositoryInMemory();
        $input = new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123');
        $signup = new Signup($accountRepository);
        $accountId = $signup->execute($input);
        $placeOrder = new PlaceOrder($accountRepository, $OrderRepository);
        $placeOrder->execute(new PlaceOrderInput('BTC/USD', $accountId->accountId, OrderSideEnum::BUY->value, 15, 84000));
        $placeOrder->execute(new PlaceOrderInput('BTC/USD', $accountId->accountId, OrderSideEnum::BUY->value, 19, 84500));
        $placeOrder->execute(new PlaceOrderInput('BTC/USD', $accountId->accountId, OrderSideEnum::SELL->value, 3, 1100));
        $placeOrder->execute(new PlaceOrderInput('BTC/USD', $accountId->accountId, OrderSideEnum::SELL->value, 3, 1900));

        $getDepth = new GetDepth($OrderRepository);
        $getDepthOutput = $getDepth->execute(new GetDepthInput('BTC/USD', 3));

        $this->assertCount(1, $getDepthOutput->buys);
        $this->assertSame((float)84000, $getDepthOutput->buys[0]['price']);
        $this->assertSame(34, $getDepthOutput->buys[0]['quantity']);
        $this->assertSame('BTC/USD', $getDepthOutput->buys[0]['marketId']);

        $this->assertCount(1, $getDepthOutput->sells);
        $this->assertSame((float)1000, $getDepthOutput->sells[0]['price']);
        $this->assertSame(6, $getDepthOutput->sells[0]['quantity']);
        $this->assertSame('BTC/USD', $getDepthOutput->sells[0]['marketId']);
    }
}
