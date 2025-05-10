<?php

namespace App\Infra\Middleware;

use Hyperf\Codec\Json;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\ViewEngine\Contract\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swow\Psr7\Message\ResponsePlusInterface;

class CoreMiddlewareCustom extends CoreMiddleware
{
    protected function transferToResponse($response, ServerRequestInterface $request): ResponsePlusInterface
    {
        if (is_object($response) && ! $response instanceof ViewInterface) {
            return $this->response()
                ->addHeader('content-type', 'application/json')
                ->setBody(new SwooleStream(Json::encode($response)));
        }

        return parent::transferToResponse($response, $request);
    }
}
