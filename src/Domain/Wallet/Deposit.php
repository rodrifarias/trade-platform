<?php

namespace App\Domain\Wallet;

use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\Repository\AccountRepositoryInterface;
use App\Domain\Wallet\Data\DepositInput;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;
use Ramsey\Uuid\Uuid;

class Deposit
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private WalletRepositoryInterface $walletRepository,
    ) {
    }

    public function execute(DepositInput $input): void
    {
        $account = $this->accountRepository->findById($input->accountId);
        throwIf(!$account, new AccountNotFoundException($input->accountId));
        $this->walletRepository->add(Uuid::uuid4(), $input->accountId, $input->assetId->value, $input->quantity);
    }
}
