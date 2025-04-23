<?php

namespace Test\Account;

use App\Domain\Account\Data\SignupInput;
use App\Domain\Wallet\Repository\WalletRepositoryInMemory;
use App\Domain\Account\{GetAccount, Signup};
use App\Domain\Account\Repository\AccountRepositoryInMemory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    public function testDeveCriarUmaContaValida(): void
    {
        $input = new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123');
        $accountRepository = new AccountRepositoryInMemory();
        $walletRepository = new WalletRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository, $walletRepository);
        $accountId = $signup->execute($input);
        $account = $getAccount->execute($accountId->accountId);

        $this->assertSame($account->name, $input->name);
    }

    #[DataProvider('dataProviderDadosInvalidos')]
    public function testNaoDeveCriarInputComDadosInvalidos(string $name, string $email, string $cpf, string $password, string $exceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new SignupInput($name, $email, $cpf, $password);
    }

    public static function dataProviderDadosInvalidos(): array
    {
        return [
            'invalidName' => ['Rodrigo', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123', 'Invalid name'],
            'invalidEmail' => ['Rodrigo Farias', 'rodrigo.farias@', '01690130067', 'asdQWE123', 'Invalid email'],
            'invalidCpf' => ['Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130066', 'asdQWE123', 'Invalid CPF'],
            'invalidPassword' => ['Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE', 'Invalid password'],
        ];
    }
}
