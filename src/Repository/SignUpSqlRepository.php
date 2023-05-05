<?php

namespace App\Repository;

use PDO;

class SignUpSqlRepository
{
    public function __construct(private readonly PDO $pdo)
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (id  INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, password TEXT)");
    }

    public function addUser(string $email, string $password): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) {
            // email already exists
            return false;
        }

        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        return true;
    }
}
