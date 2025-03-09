<?php
//require_once '../Model/Model.php';
namespace Model;
class UserProduct extends Model
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;
    private Product $product;
    private int $sum;

    public function getById(int $product_id, int $user_id): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $result['id'];
        $obj->user_id = $result['user_id'];
        $obj->product_id = $result['product_id'];
        $obj->amount = $result['amount'];

        return $obj;
    }

    public function updateById(int $product_id, int $user_id, int $amount)
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :userId");
        $stmt->execute(['amount' => $amount, 'product_id' => $product_id, 'userId' => $user_id]);
    }

    public function insertId(int $user_id, int $product_id, int $amount)
    {
        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function getALLByUserId(int $user_id):array|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $result = $stmt->fetchALL();
        $data = [];
        foreach ($result as $product) {
            $obj = new self();
            $obj->id = $product['id'];
            $obj->user_id = $product['user_id'];
            $obj->product_id = $product['product_id'];
            $obj->amount = $product['amount'];
            $data[] = $obj;
        }
        return $data;
    }

    public function deleteById(int $product_id, int $user_id)
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
    }

    public function deletelByUserId(int $user_id)
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
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

