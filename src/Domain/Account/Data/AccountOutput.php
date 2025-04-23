<?php

namespace App\Domain\Account\Data;

readonly class AccountOutput
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
