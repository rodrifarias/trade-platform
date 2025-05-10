<?php

namespace App\Controller\Api;

use App\Domain\Usecase\GetAccount\{GetAccount, GetAccountOutput};
use App\Domain\Usecase\Deposit\{Deposit, DepositInput};
use App\Domain\Usecase\Withdraw\{Withdraw, WithdrawInput};
use App\Domain\Usecase\Signup\{Signup, SignupInput, SignupOutput};
use Hyperf\HttpServer\Annotation\{Controller, GetMapping, PostMapping};

#[Controller('/api')]
class AccountController extends AbstractController
{
    public function __construct(
        private Signup $signup,
        private Deposit $deposit,
        private Withdraw $withdraw,
        private GetAccount $getAccount,
    ) {
    }

    #[PostMapping('signup')]
    public function signup(): SignupOutput
    {
        $signupInput = new SignupInput(...$this->request->all());
        return $this->signup->execute($signupInput);
    }

    #[PostMapping('deposit')]
    public function deposit(): void
    {
        $depositInput = new DepositInput(...$this->request->all());
        $this->deposit->execute($depositInput);
    }

    #[PostMapping('withdraw')]
    public function withdraw(): void
    {
        $withdrawInput = new WithdrawInput(...$this->request->all());
        $this->withdraw->execute($withdrawInput);
    }

    #[GetMapping('accounts/{accountId}')]
    public function getAccount(string $accountId): GetAccountOutput
    {
        return $this->getAccount->execute($accountId);
    }
}
