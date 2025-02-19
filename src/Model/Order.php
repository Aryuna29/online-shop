<?php

namespace Model;
//require_once '../Model/Model.php';
class Order extends Model
{
    public function insert(int $user_id, string $address, string $phone): null
    {
        $stmt = $this->PDO->prepare("INSERT INTO orders (user_id, address, phone) VALUES (:user_id, :address, :phone)");
        $stmt->execute(['user_id' => $user_id, 'address' => $address, 'phone' => $phone]);
        return null;
    }

    public function getIdByUserId(int $user_id): int
    {
        $stmt = $this->PDO->query("SELECT id FROM orders WHERE user_id = {$user_id}");
        return $stmt->fetchColumn();
    }
}