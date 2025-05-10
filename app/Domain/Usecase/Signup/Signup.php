<?php

namespace App\Domain\Usecase\Signup;

use App\Domain\{Entity\Account};
use App\Infra\Database\Repository\Account\AccountRepositoryInterface;

class Signup
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function execute(SignupInput $input): SignupOutput
    {
        $account = Account::create($input->name, $input->email, $input->document, $input->password);
        $this->accountRepository->saveAccount($account);
        return new SignupOutput($account->accountId);
    }
}
