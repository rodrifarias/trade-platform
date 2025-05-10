<?php

namespace Test\Unit;

use App\Domain\Exception\{AccountAssetNotFoundException, InsufficientFundsException};
use App\Domain\Usecase\Deposit\{Deposit, DepositInput};
use App\Domain\Usecase\GetAccount\GetAccount;
use App\Domain\Usecase\Signup\{Signup, SignupInput};
use App\Domain\Usecase\Withdraw\{Withdraw, WithdrawInput};
use App\Infra\Database\Repository\Account\AccountRepositoryInMemory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WithdrawTest extends TestCase
{
    public function testDeveRetirarFundosDeUmaConta(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository);
        $accountId = $signup->execute(new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123'));
        $deposit = new Deposit($accountRepository);
        $withdraw = new Withdraw($accountRepository);
        $input1 = new DepositInput($accountId->accountId, 'BTC', 50);
        $deposit->execute($input1);
        $account = $getAccount->execute($accountId->accountId);
        $withdraw->execute(new WithdrawInput($account->accountId, 'BTC', 50));

        $assets = $getAccount->execute($accountId->accountId);
        $this->assertSame($assets->assets[0]['quantity'], 0);
    }

    public function testNaoDeveRetirarFundosComSaldoInsuficiente(): void
    {
        $this->expectException(InsufficientFundsException::class);
        $this->expectExceptionMessage('Insufficient funds');

        $accountRepository = new AccountRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository);
        $accountId = $signup->execute(new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123'));
        $deposit = new Deposit($accountRepository);
        $withdraw = new Withdraw($accountRepository);
        $input1 = new DepositInput($accountId->accountId, 'USD', 10);
        $deposit->execute($input1);
        $account = $getAccount->execute($accountId->accountId);
        $withdraw->execute(new WithdrawInput($account->accountId, 'USD', 11));

        $getAccount->execute($accountId->accountId)->assets;
    }

    public function testNaoDeveRetirarFundosEmUmaContaInexistente(): void
    {
        $this->expectException(AccountAssetNotFoundException::class);
        $this->expectExceptionMessage('Account asset not found');

        $deposit = new Withdraw(new AccountRepositoryInMemory());
        $deposit->execute(new WithdrawInput('123', 'BTC', 50));
    }

    public function testNaoDeveCriarWithdrawInputInvalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid quantity');

        new WithdrawInput('123', 'BTC', 0);
    }
}
