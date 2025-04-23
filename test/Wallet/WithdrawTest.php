<?php

namespace Test\Wallet;

use App\Domain\Account\Data\SignupInput;
use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\GetAccount;
use App\Domain\Account\Repository\AccountRepositoryInMemory;
use App\Domain\Account\Signup;
use App\Domain\Wallet\Data\DepositInput;
use App\Domain\Wallet\Data\WithdrawInput;
use App\Domain\Wallet\Deposit;
use App\Domain\Wallet\Enum\AssetIdEnum;
use App\Domain\Wallet\Repository\WalletRepositoryInMemory;
use App\Domain\Wallet\Withdraw;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WithdrawTest extends TestCase
{
    public function testDeveRetirarFundosDeUmaConta(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $walletRepository = new WalletRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository, $walletRepository);
        $accountId = $signup->execute(new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123'));
        $deposit = new Deposit($accountRepository, $walletRepository);
        $withdraw = new Withdraw($accountRepository, $walletRepository);
        $input1 = new DepositInput($accountId->accountId, AssetIdEnum::BTC, 50);
        $input2 = new DepositInput($accountId->accountId, AssetIdEnum::BTC, 10);
        $deposit->execute($input1);
        $deposit->execute($input2);
        $account = $getAccount->execute($accountId->accountId);
        $withdraw->execute(new WithdrawInput($account->accountId, AssetIdEnum::BTC, 55));

        $assets = $getAccount->execute($accountId->accountId)->assets;
        $this->assertSame($assets[0]['quantity'], 0);
        $this->assertSame($assets[1]['quantity'], 5);
    }

    public function testNaoDeveRetirarFundosEmUmaContaInexistente(): void
    {
        $this->expectException(AccountNotFoundException::class);
        $this->expectExceptionMessage('Account [123] not found');

        $deposit = new Withdraw(new AccountRepositoryInMemory(), new WalletRepositoryInMemory());
        $deposit->execute(new WithdrawInput('123', AssetIdEnum::BTC, 50));
    }

    public function testNaoDeveCriarWithdrawInputInvalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid quantity');

        new WithdrawInput('123', AssetIdEnum::BTC, 0);
    }
}
