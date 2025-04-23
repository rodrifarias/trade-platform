<?php

namespace App\Domain\Wallet\Data;

use App\Domain\Wallet\Enum\AssetIdEnum;
use InvalidArgumentException;

readonly class DepositInput
{
    public function __construct(
        public string $accountId,
        public AssetIdEnum $assetId,
        public int $quantity
    ) {
        throwIf($quantity <= 0, new InvalidArgumentException('Invalid quantity'));
    }
}
