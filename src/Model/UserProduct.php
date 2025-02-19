<?php
//require_once '../Model/Model.php';
namespace Model;
class UserProduct extends Model
{
    public function getById(int $product_id, int $user_id): array|false
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);

        return  $stmt->fetch();
    }

    public function updateById(int $product_id, int $user_id, int $amount): null
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['amount' => $amount, 'product_id' => $product_id, 'user_id' => $user_id]);
        return null;
    }

    public function insertId(int $user_id, int $product_id, int $amount): null
    {

        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
        return null;
    }

    public function getByUserId(int $user_id):array|false
    {
        $stmt = $this->PDO->query("SELECT * FROM user_products WHERE user_id = {$user_id}");

        return $stmt->fetchALL();
    }

    public function deleteById(int $product_id, int $user_id): null
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        return null;
    }
}