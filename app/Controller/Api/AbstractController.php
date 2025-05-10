<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Hyperf\Contract\{ConfigInterface, StdoutLoggerInterface};
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\{RequestInterface, ResponseInterface};
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    protected StdoutLoggerInterface $logger;

    #[Inject]
    protected ConfigInterface $config;
}
