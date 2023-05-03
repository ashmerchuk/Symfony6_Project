<?php

namespace App\Tests\Repository;

use App\Repository\TodoSqlRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TodoSqlRepositoryTest extends TestCase
{
    private TodoSqlRepository|MockObject $pdoMock;
    private TodoSqlRepository $sut;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->sut = new TodoSqlRepository($this->pdoMock);
    }
    public function testGetAllTodos(): void
    {
        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock
            ->expects($this->once())
            ->method('execute');

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with('SELECT nameOfTodo FROM allSKills')
            ->willReturn($stmtMock);

        $this->sut->getAllTodos();
    }
    public function testDeleteTodo(): void
    {
        $todo = 'andrii';
        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock
            ->expects($this->once())
            ->method('bindParam')
            ->withAnyParameters()
            ->willReturn(true);

        $stmtMock
            ->expects($this->once())
            ->method('execute');

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with('DELETE FROM allSKills WHERE nameOfTodo = :todo')
            ->willReturn($stmtMock);

        $this->sut->deleteTodo($todo);
    }
    public function testAddTodo(): void
    {
        $todo = 'andrii';
        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock
            ->expects($this->once())
            ->method('bindParam')
            ->withAnyParameters()
            ->willReturn(true);

        $stmtMock
            ->expects($this->once())
            ->method('execute');

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO allSKills (nameOfTodo) VALUES (:todo)')
            ->willReturn($stmtMock);

        $this->sut->addTodo($todo);
    }
}

