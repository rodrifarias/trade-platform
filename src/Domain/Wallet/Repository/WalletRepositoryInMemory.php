<?php

namespace App\Domain\Wallet\Repository;

class WalletRepositoryInMemory implements WalletRepositoryInterface
{
    public function __construct(private array $wallets = [])
    {
    }

    public function add(string $id, string $accountId, string $assetId, int $quantity): void
    {
        $this->wallets[] = [
            'id' => $id,
            'accountId' => $accountId,
            'assetId' => $assetId,
            'quantity' => $quantity,
        ];
    }

    public function findByAccountId(string $accountId): array
    {
        $wallet = array_filter($this->wallets, fn($w) => $w['accountId'] === $accountId);
        return $wallet ? array_values($wallet) : [];
    }

    public function sub(string $id, int $quantity): void
    {
        $wallets = array_filter($this->wallets, fn($w) => $w['id'] === $id);
        $keyWallet = array_key_first($wallets);
        $this->wallets[$keyWallet]['quantity'] -= $quantity;
    }
}
