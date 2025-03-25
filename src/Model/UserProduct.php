<?php

namespace Model;
class UserProduct extends Model
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;
    private Product $product;
    private int $sum;
    private int $totalSum;
    protected static function getTableName(): string
    {
        return 'user_products';
    }
    public static function getById(int $product_id, int $user_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        return self::createObj($result);
    }

    public static function updateById(int $product_id, int $user_id, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE {$tableName} SET amount = :amount WHERE product_id = :product_id AND user_id = :userId");
        $stmt->execute(['amount' => $amount, 'product_id' => $product_id, 'userId' => $user_id]);
    }

    public static function insertId(int $user_id, int $product_id, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO {$tableName} (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public static function getALLByUserId(int $user_id):array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $result = $stmt->fetchALL();
        $data = [];
        foreach ($result as $product) {
           $data[] = self::createObj($product);
        }
        return $data;
    }

    public static function getAllByUserIdWithProducts(int $user_id):array|null
    {

        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM {$tableName} 
                   INNER JOIN products  
                   on {$tableName}.product_id = products.id 
                   WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetchALL();
        $userProducts = [];
        foreach ($result as $userProduct) {

            $userProducts[] = static::createObjWithProduct($userProduct);
        }
        return $userProducts;
    }

     public static function createObjWithProduct(array $userProduct): self|null
    {
        if (!$userProduct) {
            return null;
        }
        $obj = new self();
        $obj->id = $userProduct['id'];
        $obj->user_id = $userProduct['user_id'];
        $obj->product_id = $userProduct['product_id'];
        $obj->amount = $userProduct['amount'];
            $productsData['id'] = $userProduct['id'];
            $productsData['name'] = $userProduct['name'];
            $productsData['description'] = $userProduct['description'];
            $productsData['price'] = $userProduct['price'];
            $productsData['image_url'] = $userProduct['image_url'];

        $product = Product::createObj($productsData);
        $obj->setProduct($product);
        return $obj;
    }
    public static function getCount(int $user_id): int
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT COUNT(*) FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetchColumn();
        return $result;
    }

    public static function deleteById(int $product_id, int $user_id)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM {$tableName} WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
    }

    public static function deletelByUserId(int $user_id)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }

    public static function createObj(array $userProduct): self|null
    {
        if (!$userProduct) {
            return null;
        }
        $obj = new self();
        $obj->id = $userProduct['id'];
        $obj->user_id = $userProduct['user_id'];
        $obj->product_id = $userProduct['product_id'];
        $obj->amount = $userProduct['amount'];
        return $obj;
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
    public function setTotalSum(int $totalSum)
    {
        $this->totalSum = $totalSum;
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int|null
    {
        return $this->amount;
    }

}

