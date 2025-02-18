<?php
//require_once '../Model/Model.php';

namespace Model;
class User extends Model
{
    public function getByEmail(string $email): array|false
    {

        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result;
    }

    public function insertByNameEmailPass(string $name, string $email, string $password): null
    {
        $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        return null;
    }

    public function getById(int $userId): array|false
    {
        $stmt = $this->PDO->query("SELECT * FROM users WHERE id = '$userId'");
        $result = $stmt->fetch();
        return $result;
    }

    public function updateNameById(int $userId, string $name): null
    {
        $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute([':name' => $name]);
        return null;
    }

    public function updateEmailById(int $userId, string $email): null
    {

        $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id = $userId");
        $stmt->execute([':email' => $email]);
        return null;
    }

}