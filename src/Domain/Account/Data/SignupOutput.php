<?php

namespace App\Domain\Account\Data;

readonly class SignupOutput
{
    public function __construct(public string $accountId)
    {
    }
}
