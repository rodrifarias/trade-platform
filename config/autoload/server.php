<?php

declare(strict_types=1);

use Hyperf\Server\{Event, Server};
use Hyperf\Framework\Bootstrap\{FinishCallback, PipeMessageCallback, TaskCallback, WorkerExitCallback, WorkerStartCallback};
use Hyperf\HttpServer\Server as HyperfServer;
use Hyperf\WebSocketServer\Server as WebsocketServer;
use Swoole\Constant;

use function Hyperf\Support\env;

return [
    'mode' => SWOOLE_PROCESS,
    'servers' => [
        [
            'name' => 'http',
            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => 80,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_REQUEST => [HyperfServer::class, 'onRequest'],
            ],
            'options' => [
                'enable_request_lifecycle' => true,
            ],
        ],
        [
            'name' =>'socket-io',
            'type' => Server::SERVER_WEBSOCKET,
            'host' => '0.0.0.0',
            'port' => 8080,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_HAND_SHAKE => [WebsocketServer::class, 'onHandShake'],
                Event::ON_MESSAGE => [WebsocketServer::class, 'onMessage'],
                Event::ON_CLOSE => [WebsocketServer::class, 'onClose'],
            ],
        ],
    ],
    'settings' => [
        Constant::OPTION_ENABLE_COROUTINE => true,
        Constant::OPTION_WORKER_NUM => 4,
        Constant::OPTION_PID_FILE => BASE_PATH . '/runtime/hyperf.pid',
        Constant::OPTION_OPEN_TCP_NODELAY => true,
        Constant::OPTION_MAX_COROUTINE => 100000,
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true,
        Constant::OPTION_MAX_REQUEST => 100000,
        Constant::OPTION_SOCKET_BUFFER_SIZE => 2 * 1024 * 1024,
        Constant::OPTION_BUFFER_OUTPUT_SIZE => 2 * 1024 * 1024,
        'document_root' => BASE_PATH . '/public',
        'enable_static_handler' => true,
    ],
    'callbacks' => [
        Event::ON_WORKER_START => [WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT => [WorkerExitCallback::class, 'onWorkerExit'],
    ],
];
