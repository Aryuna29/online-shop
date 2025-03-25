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
    private int $total;

    protected static function getTableName(): string
    {
        return 'order_products';
    }
    public static function create(int $orderId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (order_id, product_id, amount) 
                   VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function getALLByOrderId(int $order_id): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $order_id]);
        $data = $stmt->fetchAll();
        if ($data === false) {
            return null;
        }
        $result = [];
        foreach ($data as $orderProduct) {
            $result[] =static::createObj($orderProduct);
        }
        return $result;
    }
    public static function getALLByOrderIdWithProduct(int $order_id): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} op inner join products p on op.product_id = p.id WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $order_id]);
        $data = $stmt->fetchAll();
        if ($data === false) {
            return null;
        }
        $result = [];
        foreach ($data as $orderProduct) {
            $result[] =static::createObjWithProduct($orderProduct);
        }
        return $result;
    }
    public static function createObjWithProduct(array $orderProduct): self|null
    {
        if (!$orderProduct) {
            return null;
        }
        $obj = new self();
        $obj->id = $orderProduct['id'];
        $obj->order_id = $orderProduct['order_id'];
        $obj->product_id = $orderProduct['product_id'];
        $obj->amount = $orderProduct['amount'];
            $productsData['id'] = $orderProduct['id'];
            $productsData['name'] = $orderProduct['name'];
            $productsData['description'] = $orderProduct['description'];
            $productsData['price'] = $orderProduct['price'];
            $productsData['image_url'] = $orderProduct['image_url'];

        $product = Product::createObj($productsData);
        $obj->setProduct($product);
        return $obj;
    }

    public static function createObj(array $orderProduct): self|null
    {
        if (!$orderProduct) {
            return null;
        }
        $obj = new self();
        $obj->id = $orderProduct['id'];
        $obj->order_id = $orderProduct['order_id'];
        $obj->product_id = $orderProduct['product_id'];
        $obj->amount = $orderProduct['amount'];
        return $obj;
    }
    public function setTotal(int $total)
    {
        $this->total = $total;
    }
    public function getTotal(): int
    {
        return $this->total;
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