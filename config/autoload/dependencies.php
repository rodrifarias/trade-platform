<?php

declare(strict_types=1);

use App\Infra\Database\Repository\Account\{AccountRepositoryDatabase, AccountRepositoryInterface};
use Hyperf\SocketIOServer\Room\{AdapterInterface, MemoryAdapter};
use App\Infra\Database\Repository\Order\{OrderRepositoryDatabase, OrderRepositoryInterface};
use App\Infra\Middleware\CoreMiddlewareCustom;
use Hyperf\HttpServer\CoreMiddleware;

return [
    OrderRepositoryInterface::class => OrderRepositoryDatabase::class,
    AccountRepositoryInterface::class => AccountRepositoryDatabase::class,
    CoreMiddleware::class => CoreMiddlewareCustom::class,
    AdapterInterface::class => MemoryAdapter::class,
];
