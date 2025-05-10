<?php

namespace App\Domain\Usecase\GetAccount;

use App\Domain\Entity\AccountAsset;
use App\Infra\Database\Repository\Account\AccountRepositoryInterface;

class GetAccount
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function execute(string $accountId): GetAccountOutput
    {
        $account = $this->accountRepository->getAccountById($accountId);
        $assets = $this->accountRepository->getAccountAssets($account->accountId);
        return new GetAccountOutput(
            $account->accountId,
            $account->name,
            $account->email,
            $account->document,
            array_map(fn (AccountAsset $a) => ['assetId' => $a->assetId, 'quantity' => $a->getQuantity()], $assets),
        );
    }
}
