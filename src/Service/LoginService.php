<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\LoginRepository;

class LoginService
{
    public function __construct(
        private readonly LoginRepository $repository
    ) {
    }

    public function checkUser(string $sanitiseEmail, string $sanitisePassword): ?int
    {
        return $this->repository->checkUser($sanitiseEmail, $sanitisePassword);
    }

    public function checkForgotEmail(string $sanitiseEmail): ?bool
    {
        return $this->repository->checkForgotEmail($sanitiseEmail);
    }
}
