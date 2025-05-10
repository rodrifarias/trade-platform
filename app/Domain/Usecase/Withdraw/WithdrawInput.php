<?php

namespace App\Domain\Usecase\Withdraw;

use InvalidArgumentException;

readonly class WithdrawInput
{
    public function __construct(
        public string $accountId,
        public string $assetId,
        public int $quantity
    ) {
        throwIf($quantity <= 0, new InvalidArgumentException('Invalid quantity'));
    }
}
