<?php

namespace App\Infra\Database\Repository\Account;

use App\Domain\Entity\{Account, AccountAsset};
use App\Domain\Exception\{AccountAssetNotFoundException, AccountNotFoundException};
use App\Domain\Enum\AccountAssetEnum;
use Hyperf\DbConnection\Db;

class AccountRepositoryDatabase implements AccountRepositoryInterface
{
    public function saveAccount(Account $account): void
    {
        Db::table('account')->insert([
            'account_id' => $account->accountId,
            'name' => $account->name,
            'email' => $account->email,
            'document' => $account->document,
            'password' => $account->password,
        ]);
    }

    public function getAccountById(string $accountId): Account
    {
        $account = Db::table('account')
            ->select(['account_id', 'name', 'email', 'document', 'password'])
            ->where('account_id', $accountId)
            ->first();

        throwIf(!$account, new AccountNotFoundException($accountId));

        return new Account(
            $account->account_id,
            $account->name,
            $account->email,
            $account->document,
            $account->password,
        );
    }

    public function saveAccountAsset(AccountAsset $accountAsset): void
    {
        Db::table('account_asset')->insert([
            'account_id' => $accountAsset->accountId,
            'asset_id' => $accountAsset->assetId->value,
            'quantity' => $accountAsset->getQuantity(),
        ]);
    }

    public function getAccountAsset(string $accountId, AccountAssetEnum $assetEnum): AccountAsset
    {
        $asset = Db::table('account_asset')
            ->select(['account_id', 'asset_id', 'quantity'])
            ->where('account_id', $accountId)
            ->where('asset_id', $assetEnum->value)
            ->first();

        throwIf(!$asset, new AccountAssetNotFoundException());

        return AccountAsset::create($asset->account_id, $asset->asset_id, $asset->quantity);
    }

    /** @return AccountAsset[] */
    public function getAccountAssets(string $accountId): array
    {
        $assets = Db::table('account_asset')
            ->select(['account_id', 'asset_id', 'quantity'])
            ->where('account_id', $accountId)
            ->get();

        return array_map(
            fn ($a) => AccountAsset::create($a->account_id, $a->asset_id, $a->quantity),
            $assets->toArray(),
        );
    }

    public function updateAccountAsset(AccountAsset $accountAsset): void
    {
        Db::table('account_asset')
            ->where('account_id', $accountAsset->accountId)
            ->where('asset_id', $accountAsset->assetId->value)
            ->update(['quantity' => $accountAsset->getQuantity()]);
    }
}
