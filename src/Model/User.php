<?php


namespace Model;
class User extends Model
{

    private int $id;
    private string $name;
    private string $email;
    private string $password;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }
        return static::createObj($result);
    }

    public static function insertByNameEmailPass(string $name, string $email, string $password)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function getById(int $userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }
        return static::createObj($result);
    }

    public static function updateNameById(int $userId, string $name)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET name = :name WHERE id = :userId");
        $stmt->execute([':name' => $name, 'userId' => $userId]);
    }

    public static function updateEmailById(int $userId, string $email)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET email = :email WHERE id = :userId");
        $stmt->execute([':email' => $email, 'userId' => $userId]);
    }

    public static function createObj(array $user): self|null
    {
        if (!$user){
            return null;
        }
        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];
        return $obj;
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