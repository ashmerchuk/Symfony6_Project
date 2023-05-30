<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\TableSqlRepository;

class TableService
{
    public function __construct(
        private readonly TableSqlRepository $repository
    ) {
    }

    public function getAllTodos(): array
    {
        return $this->repository->getAllTodos();
    }

    public function getSearchedTodos($todoSearch): array
    {
        return $this->repository->getSearchedTodos($todoSearch);
    }

    public function getAllSortedByNameTodos($sortedBy): array
    {
        return $this->repository->getAllSortedByNameTodos($sortedBy);
    }

    public function getAllSortedByEmailTodos($sortedBy): array
    {
        return $this->repository->getAllSortedByEmailTodos($sortedBy);
    }
}
