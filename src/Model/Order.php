<?php

namespace Model;
//require_once '../Model/Model.php';
use PDO;

class Order extends Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string $comment;
    private int $user_id;
    private string $address;

    public function create(
        string $contactName,
        string $contactPhone,
        string $comment,
        string $address,
        int $userId
    )
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO orders (contact_name, contact_phone, comment, address, user_id)
                    VALUES (:name, :phone, :comment, :address, :user_id) RETURNING id"
        );
        $stmt->execute(
            ['name' => $contactName,
                'phone' => $contactPhone,
                'comment' => $comment,
                'address' => $address,
                'user_id' =>$userId
            ]);
        $data = $stmt->fetch();
        return $data['id'];
    }
    public function getALLByUserId($user_id): array|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId' => $user_id]);
        $data = $stmt->fetchAll();
        if ($data == false) {
            return null;
        }
        $orders = [];
        foreach ($data as $order) {
            $obj = new self();
            $obj->id = $order['id'];
            $obj->contact_name = $order['contact_name'];
            $obj->contact_phone = $order['contact_phone'];
            $obj->comment = $order['comment'];
            $obj->user_id = $order['user_id'];
            $obj->address = $order['address'];
            $orders[] = $obj;
        }
        return $orders;
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