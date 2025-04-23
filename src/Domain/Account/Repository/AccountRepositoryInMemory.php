<?php

namespace App\Domain\Account\Repository;

class AccountRepositoryInMemory implements AccountRepositoryInterface
{
    public function __construct(private array $accounts = [])
    {
    }

    public function create(string $id, string $name, string $email, string $document, string $password): void
    {
        $this->accounts[] = [
            'accountId' => $id,
            'name' => $name,
            'email' => $email,
            'document' => $document,
            'password' => $password,
        ];
    }

    public function findById(string $id): ?array
    {
        $account = array_filter($this->accounts, fn($account) => $account['accountId'] === $id);
        return $account ? array_shift($account) : null;
    }
}
