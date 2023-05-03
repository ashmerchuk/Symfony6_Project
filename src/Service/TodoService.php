<?php

namespace App\Service;

use App\Repository\TodoSqlRepository;

class TodoService
{
    private TodoSqlRepository $repository;

    public function __construct($repository){
        $this->repository = $repository;
    }
    public function addTodo(string $sanitiseNameOfSkill): void
    {
        $allTodos = $this->repository->getAllTodos();
        foreach ($allTodos as $todo) {
            if ($sanitiseNameOfSkill === $todo) {
                return;
            }
        }
        $this->repository->addTodo($sanitiseNameOfSkill);
    }

    public function deleteTodo($nameOfSkills): void
    {
        $this->repository->deleteTodo($nameOfSkills);
    }

    public function getAllTodos()
    {
        return $this->repository->getAllTodos();
    }
}
