<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\TodoSqlRepository;

class TodoService
{
    public function __construct(
        private readonly TodoSqlRepository $repository
    ) {
    }

    public function addTodo(string $sanitiseNameOfSkill): void
    {
        $this->repository->addTodo($sanitiseNameOfSkill);
    }

    public function deleteTodo($nameOfSkills): void
    {
        $this->repository->deleteTodo($nameOfSkills);
    }

    public function getAllTodos(): array
    {
        return $this->repository->getAllTodos();
    }
    public function getUserFromSession(): array
    {
        return $this->repository->getUserFromSession();
    }

}
