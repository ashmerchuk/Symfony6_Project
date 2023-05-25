<?php

declare(strict_types=1);

namespace Unit;

use PHPUnit\Framework\TestCase;
use App\Repository\AddUsersPhotoRepository;
use App\Service\AddUsersPhotoService;
use PDO;

class TodoServiceTest extends TestCase
{
    private AddUsersPhotoService $service;

    protected function setUp(): void
    {
        $pdo = new PDO('sqlite:./sk.db');
        $this->repository = new AddUsersPhotoRepository($pdo);
        $this->service = new AddUsersPhotoService($this->repository);
    }
    public function testDeleteTodo(): void
    {
        $nameOfSkillToDelete = 'todo_1';
        $this->service->addTodo($nameOfSkillToDelete);
        $this->service->deleteTodo($nameOfSkillToDelete);
        $allTodos = $this->service->getAllTodos();
        $this->assertNotContains($nameOfSkillToDelete, $allTodos);
    }
    public function testAddTodo(): void
    {
        $nameOfSkillToAdd = 'todo_to_add';
        $this->service->addTodo($nameOfSkillToAdd);
        $allTodos = $this->service->getAllTodos();
        $this->assertContains($nameOfSkillToAdd, $allTodos);
    }
    public function testGetAllTodo(): void
    {
        $this->service->addTodo('todo1');
        $this->service->addTodo('todo2');
        $this->service->addTodo('todo3');

        $allTodos = $this->service->getAllTodos();
        foreach (['todo1', 'todo2','todo3']  as $todo) {
            $this->assertContains($todo, $allTodos);
        }
    }
}
