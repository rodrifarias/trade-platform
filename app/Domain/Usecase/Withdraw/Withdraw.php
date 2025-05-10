<?php

namespace App\Domain\Usecase\Withdraw;

use App\Domain\Enum\AccountAssetEnum;
use App\Infra\Database\Repository\Account\AccountRepositoryInterface;

class Withdraw
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function execute(WithdrawInput $input): void
    {
        $accountAsset = $this->accountRepository->getAccountAsset($input->accountId, AccountAssetEnum::get($input->assetId));
        $accountAsset->withdraw($input->quantity);
        $this->accountRepository->updateAccountAsset($accountAsset);
    }
}
