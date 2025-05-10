<?php

namespace App\Infra\Database\Repository\Account;

use App\Domain\{Entity\Account, Entity\AccountAsset, Enum\AccountAssetEnum};

interface AccountRepositoryInterface
{
    public function saveAccount(Account $account): void;
    public function saveAccountAsset(AccountAsset $accountAsset): void;
    public function getAccountById(string $accountId): Account;
    public function getAccountAsset(string $accountId, AccountAssetEnum $assetEnum): AccountAsset;
    /** @return AccountAsset[] */
    public function getAccountAssets(string $accountId): array;

    public function updateAccountAsset(AccountAsset $accountAsset): void;
}
