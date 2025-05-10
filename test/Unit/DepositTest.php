<?php

namespace Test\Unit;

use App\Domain\Entity\AccountAsset;
use App\Domain\Enum\AccountAssetEnum;
use App\Domain\Exception\AccountNotFoundException;
use App\Domain\Usecase\Deposit\{Deposit, DepositInput};
use App\Domain\Usecase\GetAccount\GetAccount;
use App\Domain\Usecase\Signup\{Signup, SignupInput};
use App\Infra\Database\Repository\Account\AccountRepositoryInMemory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DepositTest extends TestCase
{
    public function testDeveAdicionarFundosEmUmaConta(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository);
        $accountId = $signup->execute(new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123'));
        $deposit = new Deposit($accountRepository);
        $input1 = new DepositInput($accountId->accountId, 'BTC', 50);
        $input2 = new DepositInput($accountId->accountId, 'USD', 10);
        $deposit->execute($input1);
        $deposit->execute($input2);
        $account = $getAccount->execute($accountId->accountId);

        $this->assertCount(2, $account->assets);
        $this->assertSame($account->assets[0]['quantity'], $input1->quantity);
        $this->assertSame($account->assets[0]['assetId']->value, $input1->assetId);
        $this->assertSame($account->assets[1]['quantity'], $input2->quantity);
        $this->assertSame($account->assets[1]['assetId']->value, $input2->assetId);
    }

    public function testNaoDeveAdicionarFundosEmUmaContaInexistente(): void
    {
        $this->expectException(AccountNotFoundException::class);
        $this->expectExceptionMessage('Account [123] not found');

        $deposit = new Deposit(new AccountRepositoryInMemory());
        $deposit->execute(new DepositInput('123', 'BTC', 50));
    }

    public function testNaoDeveCriarDepositInputInvalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid quantity');

        new AccountAsset('123', AccountAssetEnum::BTC, 0);
    }
}
