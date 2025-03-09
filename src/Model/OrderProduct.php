<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $order_id;
    private int $product_id;
    private int $amount;
    private int $sum;
    private Product $product;
    private OrderProduct $orderProduct;
    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO order_products (order_id, product_id, amount)
                VALUES (:orderId, :productId, :amount)
                ");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getALLByOrderId(int $order_id): array|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM order_products WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $order_id]);
        $data = $stmt->fetchAll();
        if ($data === false) {
            return null;
        }
        $result = [];
        foreach ($data as $value) {
            $obj = new self();
            $obj->id = $value['id'];
            $obj->order_id = $value['order_id'];
            $obj->product_id = $value['product_id'];
            $obj->amount = $value['amount'];
            $result[] = $obj;
        }
        return $result;
    }


    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setSum(int $sum)
    {
        $this->sum = $sum;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


}