<?php

namespace App\Domain\Account;

use App\Domain\Account\Data\AccountOutput;
use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\Repository\AccountRepositoryInterface;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;

class GetAccount
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private WalletRepositoryInterface $walletRepository,
    ) {
    }

    public function execute(string $accountId): AccountOutput
    {
        $account = $this->accountRepository->findById($accountId);
        throwIf(!$account, new AccountNotFoundException($accountId));
        $assets = $this->walletRepository->findByAccountId($accountId);
        return new AccountOutput(
            $account['accountId'],
            $account['name'],
            $account['email'],
            $account['document'],
            $assets,
        );
    }
}
