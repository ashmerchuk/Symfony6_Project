<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class TableSqlRepository
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
        $stmt = $this->pdo->prepare("SELECT allSkills.nameOfTodo, users.email, users.userPhoto FROM allSkills LEFT JOIN users ON allSkills.userId = users.id WHERE users.email IS NOT NULL");
        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAllSortedByNameTodos($sortedByName): array
    {
        $sortedByName ? $sortedByName = "DESC" : $sortedByName = "ASC";
        $stmt = $this->pdo->prepare("SELECT allSkills.nameOfTodo, users.email, users.userPhoto FROM allSkills LEFT JOIN users ON allSkills.userId = users.id WHERE users.email IS NOT NULL ORDER BY allSkills.nameOfTodo $sortedByName");

        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllSortedByEmailTodos($sortedByEmail): array
    {
        $sortedByEmail ? $sortedByEmail = "DESC" : $sortedByEmail = "ASC";
        $stmt = $this->pdo->prepare("SELECT allSkills.nameOfTodo, users.email, users.userPhoto FROM allSkills LEFT JOIN users ON allSkills.userId = users.id WHERE users.email IS NOT NULL ORDER BY users.email $sortedByEmail");


        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
