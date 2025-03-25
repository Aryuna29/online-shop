<?php

namespace Model;

class Order extends Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string $comment;
    private int $user_id;
    private string $address;
    private int $total;
    private array $orderProducts;
    private int $sum;

    protected static function getTableName(): string
    {
        return 'orders';
    }
    public static function create(
        string $contactName,
        string $contactPhone,
        string $address,
        string $comment,
        int $userId
    )
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (contact_name, contact_phone, address, comment, user_id)
                    VALUES (:name, :phone,  :address, :comment, :user_id) RETURNING id"
        );
        $stmt->execute([
            'name' => $contactName,
            'phone' => $contactPhone,
            'address' => $address,
            'comment' => $comment,
            'user_id' =>$userId
            ]);
        $data = $stmt->fetch();
        return $data['id'];
    }
    public static function getALLByUserId(int $user_id): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetchAll();
        if ($data == false) {
            return null;
        }
        $orders = [];
        foreach ($data as $order) {
            $orders[] = static::createObj($order);
        }
        return $orders;
    }


    public static function createObj(array $order): self|null
    {
        if (!$order) {
            return null;
        }
        $obj = new self();
        $obj->id = $order['id'];
        $obj->contact_name = $order['contact_name'];
        $obj->contact_phone = $order['contact_phone'];
        $obj->comment = $order['comment'];
        $obj->user_id = $order['user_id'];
        $obj->address = $order['address'];
        return $obj;
    }

public function setOrderProducts(array $orderProducts)
{
    $this->orderProducts = $orderProducts;
}

    public function setSum(int $sum)
    {
        $this->sum = $sum;
    }
    public function getSum(): int
    {
        return $this->sum;
    }
    public function getOrderProducts()
    {
        return $this->orderProducts;
    }
    public function setTotal(int $total)
    {
        $this->total = $total;
    }
    public function getTotal(): int
    {
        return  $this->total;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getContactName(): string
    {
        return $this->contact_name;
    }
    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getAddress(): string
    {
        return $this->address;
    }

}