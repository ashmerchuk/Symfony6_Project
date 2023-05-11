<?php

declare(strict_types=1);

namespace Unit;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Repository\TodoSqlRepository;
use App\Service\TodoService;

class TodoSqlRepositoryTest extends TestCase
{
    private TodoSqlRepository $repository;
    private TodoService $service;

    protected function setUp(): void
    {
        $pdo = new PDO('sqlite:./sk.db');
        $this->repository = new TodoSqlRepository($pdo);
        $this->service = new TodoService($this->repository);
    }
    public function testDeleteTodo(): void
    {
        $nameOfSkillToDelete = 'todo_1';
        $this->repository->addTodo($nameOfSkillToDelete);
        $this->repository->deleteTodo($nameOfSkillToDelete);
        $allTodos = $this->repository->getAllTodos();
        $this->assertNotContains($nameOfSkillToDelete, $allTodos);
    }
    public function testAddTodo(): void
    {
        $nameOfSkillToAdd = 'todo_to_add';
        $this->repository->addTodo($nameOfSkillToAdd);
        $allTodos = $this->repository->getAllTodos();
        $this->assertContains($nameOfSkillToAdd, $allTodos);
    }
    public function testGetAllTodo(): void
    {
        $this->repository->addTodo('todo1');
        $this->repository->addTodo('todo2');
        $this->repository->addTodo('todo3');

        $allTodos = $this->repository->getAllTodos();
        foreach (['todo1', 'todo2','todo3']  as $todo) {
            $this->assertContains($todo, $allTodos);
        }
    }
}
