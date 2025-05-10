<?php

namespace Test\Unit;

use App\Domain\Entity\Account;
use App\Domain\Usecase\GetAccount\GetAccount;
use App\Domain\Usecase\Signup\{Signup, SignupInput};
use App\Infra\Database\Repository\Account\AccountRepositoryInMemory;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SignupTest extends TestCase
{
    public function testDeveCriarUmaContaValida(): void
    {
        $input = new SignupInput('Rodrigo Farias', 'rodrigo.farias@outlook.com', '01690130067', 'asdQWE123');
        $accountRepository = new AccountRepositoryInMemory();
        $signup = new Signup($accountRepository);
        $getAccount = new GetAccount($accountRepository);
        $signupOutput = $signup->execute($input);
        $account = $getAccount->execute($signupOutput->accountId);

        $this->assertSame($account->name, $input->name);
        $this->assertSame($account->email, $input->email);
        $this->assertCount(0, $account->assets);
    }

    #[DataProvider('dataProviderDadosInvalidos')]
    public function testNaoDeveCriarAccountComDadosInvalidos(
        string $name,
        string $email,
        string $cpf,
        string $password,
        string $exceptionMessage
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new Account('id-123', $name, $email, $cpf, $password);
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
