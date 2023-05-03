<?php

namespace App\Repository;

use PDO;

class TodoSqlRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo =  $pdo;
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS allSKills (id  INTEGER PRIMARY KEY AUTOINCREMENT, nameOfTodo TEXT)");
    }
    public function getAllTodos() :array
    {
        $stmt = $this->pdo->prepare('SELECT nameOfTodo FROM allSKills');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function addTodo(string $todo) :void
    {
        $stmt = $this->pdo->prepare('INSERT INTO allSKills (nameOfTodo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }

    public function deleteTodo(string $todo) :void
    {
        $stmt = $this->pdo->prepare('DELETE FROM allSKills WHERE nameOfTodo = :todo');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}

