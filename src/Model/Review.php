<?php

namespace Model;

use DateTime;

class Review extends Model
{
private int $id;
private int $user_id;
private int $product_id;
private string $review;
private User $user;
private string $time;
private int $rating;

    public function create(int $product_id, int $user_id, string $review, string $time, int $rating)
    {
        $stmt = $this->PDO->prepare
            ("INSERT INTO reviews (product_id, user_id, review, time, rating) VALUES (:product_id, :user_id, :review, :time, :rating)");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id, 'review' => $review, 'time' => $time, 'rating' => $rating]);
    }

    public function getAllReviews(int $product_id): array| null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetchAll();
        if ($data == false) {
            return null;
        }
        $result = [];
        foreach ($data as $value) {
            $obj = new self();
            $obj->id = $value['id'];
            $obj->user_id = $value['user_id'];
            $obj->product_id = $value['product_id'];
            $obj->review = $value['review'];
            $obj->time = $value['time'];
            $obj->rating = $value['rating'];
            $result[] = $obj;
        }
        return $result;
    }

    public function getRating(): int
    {
        return $this->rating;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getTime(): string
    {
        return $this->time;
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