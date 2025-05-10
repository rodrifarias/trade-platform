<?php

namespace App\Domain\Usecase\GetAccount;

readonly class GetAccountOutput
{
    public function __construct(
        public string $accountId,
        public string $name,
        public string $email,
        public string $document,
        public array $assets,
    ) {
    }
}
