<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\SomeUsersTodoSqlRepository;

class
SomeUsersTodoService
{
    public function __construct(
        private readonly SomeUsersTodoSqlRepository $repository
    ) {
    }

    public function getAllTodos($userEmail): array
    {
        return $this->repository->getAllTodos($userEmail);
    }
}
