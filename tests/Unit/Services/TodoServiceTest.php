<?php

declare(strict_types=1);

namespace Test\Unit\Service;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use App\Service\TodoService;
use App\Repository\TodoSqlRepository;
use PHPUnit\Framework\MockObject\MockObject;

class TodoServiceTest extends TestCase
{
    private TodoSqlRepository|MockObject $repositoryMock;
    private TodoService $service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(TodoSqlRepository::class);
        $this->service = new TodoService($this->repositoryMock);
    }
    public function testAddTodo(): void
    {
        $todoName = 'New Todo';

        $this->repositoryMock->expects($this->once())
            ->method('addTodo')
            ->with($this->equalTo($todoName));
        $this->service->addTodo($todoName);
    }

    public function testDeleteTodo(): void
    {
        $todoName = 'Todo To Be Deleted';

        $this->repositoryMock->expects($this->once())
            ->method('deleteTodo')
            ->with($this->equalTo($todoName));
        $this->service->deleteTodo($todoName);
    }

    public function testGetAllTodos(): void
    {
        $todos = ['New Todo'];

        $this->repositoryMock->expects($this->once())
            ->method('getAllTodos')
            ->willReturn($todos);

        $expectedResult = $todos;
        $actualResult = $this->service->getAllTodos();
        $this->assertEquals($expectedResult, $actualResult, 'Expected and actual results do not match');
    }
}
