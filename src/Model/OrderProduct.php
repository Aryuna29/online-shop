<?php

namespace Model;
//require_once '../Model/Model.php';
class OrderProduct extends Model
{
    public function insertData($orderId, $productId, $amount): null
    {
        $stmtProduct = $this->PDO->prepare("INSERT INTO order_products (order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)");
        $stmtProduct->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
        return null;
    }
}