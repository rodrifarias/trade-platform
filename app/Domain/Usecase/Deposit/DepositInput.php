<?php

namespace App\Domain\Usecase\Deposit;

use App\Domain\Enum\AccountAssetEnum;

readonly class DepositInput
{
    public function __construct(
        public string $accountId,
        public string $assetId,
        public int $quantity
    ) {
    }
}
