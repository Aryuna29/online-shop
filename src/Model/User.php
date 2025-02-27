<?php
//require_once '../Model/Model.php';

namespace Model;
class User extends Model
{

    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public function getByEmail(string $email): self|null
    {

        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $result['id'];
        $obj->name = $result['name'];
        $obj->email = $result['email'];
        $obj->password = $result['password'];

        return $obj;
    }


    public function insertByNameEmailPass(string $name, string $email, string $password)
    {
        $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getById(int $userId): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $result['id'];
        $obj->name = $result['name'];
        $obj->email = $result['email'];
        $obj->password = $result['password'];
        return $obj;
    }

    public function updateNameById(int $userId, string $name)
    {
        $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id = :userId");
        $stmt->execute([':name' => $name, 'userId' => $userId]);
    }

    public function updateEmailById(int $userId, string $email)
    {
        $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id = :userId");
        $stmt->execute([':email' => $email, 'userId' => $userId]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}