<?php

namespace Test\Wallet;

use App\Domain\Account\{Exception\AccountNotFoundException, GetAccount, Signup};
use App\Domain\Account\Data\SignupInput;
use App\Domain\Account\Repository\AccountRepositoryInMemory;
use App\Domain\Wallet\Data\DepositInput;
use App\Domain\Wallet\Deposit;
use App\Domain\Wallet\Enum\AssetIdEnum;
use App\Domain\Wallet\Repository\WalletRepositoryInMemory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DepositTest extends TestCase
{
    public function testDeveAdicionarFundosEmUmaConta(): void
    {
        $accountRepository = new AccountRepositoryInMemory();
        $walletRepository = new WalletRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository, $walletRepository);
        $accountId = $signup->execute(new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123'));
        $deposit = new Deposit($accountRepository, $walletRepository);
        $input1 = new DepositInput($accountId->accountId, AssetIdEnum::BTC, 50);
        $input2 = new DepositInput($accountId->accountId, AssetIdEnum::USD, 10);
        $deposit->execute($input1);
        $deposit->execute($input2);
        $account = $getAccount->execute($accountId->accountId);

        $this->assertCount(2, $account->assets);
        $this->assertSame($account->assets[0]['quantity'], $input1->quantity);
        $this->assertSame($account->assets[0]['assetId'], $input1->assetId->value);
        $this->assertSame($account->assets[1]['quantity'], $input2->quantity);
        $this->assertSame($account->assets[1]['assetId'], $input2->assetId->value);
    }

    public function testNaoDeveAdicionarFundosEmUmaContaInexistente(): void
    {
        $this->expectException(AccountNotFoundException::class);
        $this->expectExceptionMessage('Account [123] not found');

        $deposit = new Deposit(new AccountRepositoryInMemory(), new WalletRepositoryInMemory());
        $deposit->execute(new DepositInput('123', AssetIdEnum::BTC, 50));
    }

    public function testNaoDeveCriarDepositInputInvalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid quantity');

        new DepositInput('123', AssetIdEnum::BTC, 0);
    }
}
