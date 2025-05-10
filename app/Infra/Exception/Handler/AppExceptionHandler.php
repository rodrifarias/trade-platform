<?php

declare(strict_types=1);

namespace App\Infra\Exception\Handler;

use DateTime;
use Hyperf\Contract\{ConfigInterface, StdoutLoggerInterface};
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(
        protected StdoutLoggerInterface $logger,
        protected ServerRequestInterface $request,
        protected ConfigInterface $config
    ) {}

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $errorLogMessage = sprintf(
            '%s in %s(%s) | Trace %s',
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getLine(),
            $throwable->getTraceAsString()
        );

        $this->logger->error($errorLogMessage);

        $code = $throwable->getCode() ?: 500;
        $dtNow = new DateTime();
        $appEnv = $this->config->get('app_env', 'dev');
        $showMessage = $appEnv === 'dev';

        $messageDefault = [
            'timestamp' => $dtNow->getTimestamp(),
            'status' => $code,
            'message' => $showMessage ? $throwable->getMessage() : 'Algo deu errado na requisição',
            'path' => $this->request->getUri()->getPath(),
        ];

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus($code)
            ->withBody(new SwooleStream(json_encode($messageDefault)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
