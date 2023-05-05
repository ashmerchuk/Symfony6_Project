<?php

namespace App\Service;

use App\Repository\SignUpSqlRepository;
use App\Repository\TodoSqlRepository;

class SignUpService
{
    public function __construct(
        private readonly SignUpSqlRepository $repository
    ){
    }

    public function addUser(string $sanitiseEmail, string $sanitisePassword): bool
    {
//        $password_hash = password_hash($sanitisePassword, PASSWORD_BCRYPT);
        return $this->repository->addUser($sanitiseEmail, $sanitisePassword);
    }
}
