<?php

namespace Model;
//require_once '../Model/Model.php';
class Product extends Model
{

    public function getProduct(): array|false
    {
        $stmt = $this->PDO->query('SELECT * FROM products');

        return $stmt->fetchAll();
    }


    public function getById(int $productId): array|false
    {
        $stmt = $this->PDO->query("SELECT * FROM products WHERE id = {$productId}");

        return $stmt->fetch();
    }

}