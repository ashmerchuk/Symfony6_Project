<?php

namespace App\Repository;

use PDO;

class TodoSqlRepository
{
    public function __construct(private readonly PDO $pdo){

    }

    public function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS allSKills (id  INTEGER PRIMARY KEY AUTOINCREMENT, nameOfTodo TEXT, userId INT)");
    }

    public function getAllTodos() :array
    {
        $userId = $_COOKIE['userId'];
        $stmt = $this->pdo->prepare("SELECT DISTINCT nameOfTodo FROM allSKills WHERE userId = '$userId'");
        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function addTodo(string $todo) :void
    {
        $stmt = $this->pdo->prepare('INSERT INTO allSKills (nameOfTodo, userId) VALUES (:todo, :userId)');
        $stmt->bindParam(':todo', $todo);
        $stmt->bindParam(':userId', $_COOKIE['userId']);
        $stmt->execute();
    }

    public function deleteTodo(string $todo) :void
    {
        $stmt = $this->pdo->prepare('DELETE FROM allSKills WHERE nameOfTodo = :todo');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}
