<?php

namespace App\Domain\Usecase\Signup;

readonly class SignupOutput
{
    public function __construct(public string $accountId)
    {
    }
}
