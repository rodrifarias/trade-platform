<?php

namespace App\Domain\Usecase\GetDepth;

readonly class GetDepthInput
{
    public function __construct(public string $marketId, public int $precision)
    {
    }
}
