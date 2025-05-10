<?php

namespace App\Domain\Usecase\GetDepth;

readonly class GetDepthOutput
{
    public function __construct(public array $buys, public array $sells)
    {
    }
}
