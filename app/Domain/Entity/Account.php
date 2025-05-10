<?php

namespace App\Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Tigo\DocumentBr\Cpf;

class Account
{
    public function __construct(
        public readonly string $accountId,
        public readonly string $name,
        public readonly string $email,
        public readonly string $document,
        public string $password,
    ) {
        throwIf(!preg_match('/^[A-Za-zÀ-ÿ]+\s+[A-Za-zÀ-ÿ]+$/', $name), new InvalidArgumentException('Invalid name'));
        throwIf(!filter_var($email, FILTER_VALIDATE_EMAIL), new InvalidArgumentException('Invalid email'));
        throwIf(!(new Cpf())->check($document), new InvalidArgumentException('Invalid CPF'));
        throwIf(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password), new InvalidArgumentException('Invalid password'));
    }

    public static function create(
        string $name,
        string $email,
        string $document,
        string $password
    ): self {
        $accountId = Uuid::uuid4()->toString();
        return new self($accountId, $name, $email, $document, password_hash($password, PASSWORD_BCRYPT));
    }
}
