<?php

namespace App\Domain\Wallet\Repository;

interface WalletRepositoryInterface
{
    public function add(string $id, string $accountId, string $assetId, int $quantity): void;
    public function sub(string $id, int $quantity): void;
    public function findByAccountId(string $accountId): array;
}
