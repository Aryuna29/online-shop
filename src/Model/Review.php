<?php

namespace Model;

class Review extends Model
{
private int $id;
private int $user_id;
private int $product_id;
private string $review;
private User $user;

    public function create(int $product_id, int $user_id, string $review)
    {
        $stmt = $this->PDO->prepare("INSERT INTO reviews (product_id, user_id, review) VALUES (:product_id, :user_id, :review)");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id, 'review' => $review]);
    }

    public function getAllReviews(int $product_id): array| null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetchAll();
        if ($data === false) {
            return null;
        }
        $result = [];
        foreach ($data as $value) {
            $obj = new Review();
            $obj->id = $value['id'];
            $obj->user_id = $value['user_id'];
            $obj->product_id = $value['product_id'];
            $obj->review = $value['review'];
            $result[] = $obj;
        }
        return $result;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getReview(): string
    {
        return $this->review;
    }

}