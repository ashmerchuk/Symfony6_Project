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

        if ($user || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // email already exists or email is invalid
            return false;
        }
        $userPhoto = 'https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds=';
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password, userPhoto) VALUES (:email, :password, :userPhoto)');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':userPhoto', $userPhoto);
        $stmt->execute();
        return true;
    }

    public function updateUsersPassword($email, $password): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();
        if($count > 0) {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);

            $stmt = $this->pdo->prepare('UPDATE users SET password = :password WHERE email = :email');
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return true;
        }
        return false;
    }
}
