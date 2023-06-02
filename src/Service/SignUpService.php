<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\SignUpSqlRepository;

class SignUpService
{
    public function __construct(
        private readonly SignUpSqlRepository $repository
    ) {
    }

    public function addUser(string $sanitiseEmail, string $sanitisePassword): bool
    {
        return $this->repository->addUser($sanitiseEmail, $sanitisePassword);
    }

    public function updateUsersPassword($sanitiseEmail, $sanitisePassword): bool
    {
        return $this->repository->updateUsersPassword($sanitiseEmail, $sanitisePassword);
    }
}
