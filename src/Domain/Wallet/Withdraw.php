<?php

namespace App\Domain\Wallet;

use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\Repository\AccountRepositoryInterface;
use App\Domain\Wallet\Data\WithdrawInput;
use App\Domain\Wallet\Exception\{AssetNotFoundException, InsufficientBalanceException};
use App\Domain\Wallet\Repository\WalletRepositoryInterface;

class Withdraw
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private WalletRepositoryInterface $walletRepository,
    ) {
    }

    public function execute(WithdrawInput $input): void
    {
        $account = $this->accountRepository->findById($input->accountId);
        throwIf(!$account, new AccountNotFoundException($input->accountId));
        $assets = $this->walletRepository->findByAccountId($input->accountId);
        $asset = array_filter($assets, fn($a) => $a['assetId'] === $input->assetId->value);
        throwIf(!$asset, new AssetNotFoundException());
        $balance = array_sum(array_column($asset, 'quantity'));
        throwIf($balance < $input->quantity, new InsufficientBalanceException());
        $quantitySub = $input->quantity;
        foreach ($asset as $a) {
            $quantity = min($quantitySub, $a['quantity']);
            $this->walletRepository->sub($a['id'], $quantity);
            $quantitySub -= $quantity;
        }
    }
}
