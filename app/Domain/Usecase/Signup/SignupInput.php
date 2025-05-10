<?php

namespace App\Domain\Usecase\Signup;

readonly class SignupInput
{
    public function __construct(
        public string $name,
        public string $email,
        public string $document,
        public string $password,
    ) {
    }
}
