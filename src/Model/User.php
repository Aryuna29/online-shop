<?php

class User
{
public function getByEmail(string $email): array|false
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    return $result;
}

public function insertByNameEmailPass(string $name, string $email, string $password): null
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    return null;
}

public function getById(int $userId): array|false
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->query("SELECT * FROM users WHERE id = '$userId'");
    $result = $stmt->fetch();
    return $result;
}

public function updateNameById(int $userId, string $name): null
{
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
    $stmt->execute([':name' => $name]);
    return null;
}

    public function updateEmailById(int $userId, string $email): null
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = $userId");
        $stmt->execute([':email' => $email]);
        return null;
    }

}