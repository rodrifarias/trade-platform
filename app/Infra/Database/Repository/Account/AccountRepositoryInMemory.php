<?php

namespace App\Infra\Database\Repository\Account;

use App\Domain\Entity\{Account, AccountAsset};
use App\Domain\Enum\AccountAssetEnum;
use App\Domain\Exception\AccountAssetNotFoundException;
use App\Domain\Exception\AccountNotFoundException;

class AccountRepositoryInMemory implements AccountRepositoryInterface
{
    public function __construct(private array $accounts = [], private array $accountAssets = [])
    {
    }

    public function saveAccount(Account $account): void
    {
        $this->accounts[] = $account;
    }

    public function saveAccountAsset(AccountAsset $accountAsset): void
    {
        $this->accountAssets[] = $accountAsset;
    }

    public function getAccountById(string $accountId): Account
    {
        $account = array_filter($this->accounts, fn(Account $a) => $a->accountId === $accountId);
        throwIf(! $account, new AccountNotFoundException($accountId));
        return $this->accounts[array_key_first($account)];
    }

    public function getAccountAsset(string $accountId, AccountAssetEnum $assetEnum): AccountAsset
    {
        $accountAsset = array_filter(
            $this->accountAssets,
            fn(AccountAsset $a) => $a->accountId === $accountId && $a->assetId === $assetEnum
        );
        throwIf(! $accountAsset, new AccountAssetNotFoundException());
        return $this->accountAssets[array_key_first($accountAsset)];
    }

    /** @return AccountAsset[] */
    public function getAccountAssets(string $accountId): array
    {
        return array_values(array_filter($this->accountAssets, fn(AccountAsset $a) => $a->accountId === $accountId));
    }

    public function updateAccountAsset(AccountAsset $accountAsset): void
    {
    }
}
