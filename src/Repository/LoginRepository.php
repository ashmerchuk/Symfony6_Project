<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class LoginRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function checkUser(string $email, string $password): ?int
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return null;
    }

    public function checkForgotEmail(string $email): ?bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();
        if($count > 0) {
            return true;
        }
        return false;
    }
}
