<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class AddUsersPhotoRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (id  INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, password TEXT, userPhoto TEXT)");
    }

    public function addPhotosUrl(string $photoUrl): void
    {



        session_start();
        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->prepare("PRAGMA table_info(users)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $columnExists = false;
        foreach ($columns as $column) {
            if ($column['name'] === 'userPhoto') {
                $columnExists = true;
                break;
            }
        }

        if (!$columnExists) {
            $stmt = $this->pdo->prepare("ALTER TABLE users ADD COLUMN userPhoto TEXT");
            $stmt->execute();
        }
        $stmt = $this->pdo->prepare("UPDATE users SET userPhoto = :userPhoto WHERE id = :userId");
        $stmt->bindValue(':userPhoto', $photoUrl);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
    }
}
