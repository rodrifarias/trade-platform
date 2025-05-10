<?php

namespace App\Domain\Usecase\Deposit;

use App\Domain\Entity\AccountAsset;
use App\Infra\Database\Repository\Account\AccountRepositoryInterface;

class Deposit
{
    public function __construct(protected AccountRepositoryInterface $accountRepository)
    {
    }
    public function execute(DepositInput $input): void
    {
        $account = $this->accountRepository->getAccountById($input->accountId);
        $accountAsset = AccountAsset::create($account->accountId, $input->assetId, $input->quantity);
        $this->accountRepository->saveAccountAsset($accountAsset);
    }
}
