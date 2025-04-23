<?php

namespace App\Domain\Account\Data;

use InvalidArgumentException;
use Tigo\DocumentBr\Cpf;

readonly class SignupInput
{
    public function __construct(
        public string $name,
        public string $email,
        public string $document,
        public string $password,
    ) {
        throwIf(!preg_match('/^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)$/', $name), new InvalidArgumentException('Invalid name'));
        throwIf(!filter_var($email, FILTER_VALIDATE_EMAIL), new InvalidArgumentException('Invalid email'));
        throwIf(!(new Cpf())->check($document), new InvalidArgumentException('Invalid CPF'));
        throwIf(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password), new InvalidArgumentException('Invalid password'));
    }
}
