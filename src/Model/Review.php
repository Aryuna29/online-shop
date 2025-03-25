<?php

namespace Model;


class Review extends Model
{
private int $id;
private int $user_id;
private int $product_id;
private string $review;
private User $user;
private string $time;
private int $rating;

    protected static function getTableName(): string
    {
        return 'reviews';
    }
    public static function create(int $product_id, int $user_id, string $review, string $time, int $rating)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare
            ("INSERT INTO {$tableName} (product_id, user_id, review, time, rating)
                    VALUES (:product_id, :user_id, :review, :time, :rating)");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id, 'review' => $review, 'time' => $time, 'rating' => $rating]);
    }

    public static function getAllReviews(int $product_id): array| null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetchAll();
        if ($data == false) {
            return null;
        }
        $result = [];
        foreach ($data as $value) {
            $result[] = static::createObj($value);
        }
        return $result;
    }

    public static function createObj(array $review): self|null
    {
        if (!$review) {
            return null;
        }
        $obj = new self();
        $obj->id = $review['id'];
        $obj->user_id = $review['user_id'];
        $obj->product_id = $review['product_id'];
        $obj->review = $review['review'];
        $obj->time = $review['time'];
        $obj->rating = $review['rating'];
        return $obj;
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