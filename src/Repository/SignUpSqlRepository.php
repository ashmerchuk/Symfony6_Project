<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class SignUpSqlRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (id  INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, password TEXT, userPhoto TEXT)");
    }

    public function addUser(string $email, string $password): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        if ($stmt->rowCount() == 0) {
            $this->createTable();
        }
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) {
            // email already exists
            return false;
        }
        $userPhoto = 'https://assets.stickpng.com/images/585e4bf3cb11b227491c339a.png';
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password, userPhoto) VALUES (:email, :password, :userPhoto)');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':userPhoto', $userPhoto);
        $stmt->execute();
        return true;
    }
}
