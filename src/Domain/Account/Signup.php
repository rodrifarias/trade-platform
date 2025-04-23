<?php

namespace App\Domain\Account;

use App\Domain\Account\Data\{SignupInput, SignupOutput};
use App\Domain\Account\Repository\AccountRepositoryInterface;
use Ramsey\Uuid\Uuid;

class Signup
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function execute(SignupInput $input): SignupOutput
    {
        $id = Uuid::uuid4();
        $this->accountRepository->create($id, $input->name, $input->email, $input->document, $input->password);
        return new SignupOutput($id);
    }
}
