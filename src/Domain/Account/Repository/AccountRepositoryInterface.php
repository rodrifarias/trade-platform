<?php

namespace App\Domain\Account\Repository;

interface AccountRepositoryInterface
{
    public function create(string $id, string $name, string $email, string $document, string $password): void;
    public function findById(string $id): ?array;
}
