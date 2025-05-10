<?php

namespace App\Domain\Entity;

use App\Domain\Enum\AccountAssetEnum;
use App\Domain\Exception\InsufficientFundsException;
use InvalidArgumentException;

class AccountAsset
{
    public function __construct(
        public readonly string $accountId,
        public readonly AccountAssetEnum $assetId,
        private int $quantity,
    ) {
        throwIf($this->quantity <= 0, new InvalidArgumentException('Invalid quantity'));
    }

    public function withDraw(int $quantity): void
    {
        throwIf($this->quantity < $quantity, new InsufficientFundsException());
        $this->quantity -= $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public static function create(string $accountId, string $assetId, $quantity): self
    {
        return new self($accountId, AccountAssetEnum::get($assetId), $quantity);
    }
}
