<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class TodoSqlRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS allSKills (id  INTEGER PRIMARY KEY AUTOINCREMENT, nameOfTodo TEXT, userId INT)");
    }

    public function getAllTodos(): array
    {
        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare("SELECT DISTINCT nameOfTodo FROM allSKills WHERE userId = '$userId'");
        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getUserFromSession(): array
    {
        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getUsersPhoto(): array
    {
        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare("SELECT userPhoto FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function addTodo(string $todo): void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare('INSERT INTO allSKills (nameOfTodo, userId) VALUES (:todo, :userId)');
        $stmt->bindParam(':todo', $todo);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function deleteTodo(string $todo): void
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare('DELETE FROM allSKills WHERE nameOfTodo = :todo AND userId = :userId');
        $stmt->bindParam(':todo', $todo);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
