<?php

namespace App\Controller\Api;

use App\Domain\Usecase\GetOrder\{GetOrder, GetOrderOutput};
use App\Domain\Usecase\PlaceOrder\{PlaceOrder, PlaceOrderInput, PlaceOrderOutput};
use Hyperf\HttpServer\Annotation\{Controller, GetMapping, PostMapping};

#[Controller('/api')]
class OrderController extends AbstractController
{
    public function __construct(private PlaceOrder $placeOrder, private GetOrder $getOrder)
    {
    }

    #[PostMapping('place-order')]
    public function placeOrder(): PlaceOrderOutput
    {
        $inputOrder = new PlaceOrderInput(...$this->request->all());
        return $this->placeOrder->execute($inputOrder);
    }

    #[GetMapping('orders/{orderId}')]
    public function getOrder(string $orderId): GetOrderOutput
    {
        return $this->getOrder->execute($orderId);
    }
}
