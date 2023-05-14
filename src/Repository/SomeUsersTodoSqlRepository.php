<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class SomeUsersTodoSqlRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS allSKills (id  INTEGER PRIMARY KEY AUTOINCREMENT, nameOfTodo TEXT, userId INT)");
    }

    public function getAllTodos($userEmail): array
    {
//        $userId = $_SESSION['user_id'];
//        dd('moin', $userEmail);
        $stmt = $this->pdo->prepare("SELECT allSkills.nameOfTodo FROM allSkills LEFT JOIN users ON allSkills.userId = users.id WHERE users.email = '$userEmail'");
        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}
