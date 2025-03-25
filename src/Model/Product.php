<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private string $price;
    private string $image_url;
    private array $reviewsNew;
    private int $amount;

    protected static function getTableName(): string
    {
        return 'products';
    }
    public static function getProducts(): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM {$tableName}");
        $products = $stmt->fetchAll();
        $data = [];
        foreach ($products as $product) {
            $data[] = static::createObj($product);
        }
        return $data;
    }

    public static function getById(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        return static::createObj($result);
    }

    public static function createObj(array $products): self|null
    {
        if (!$products) {
            return null;
        }
        $obj = new self();
        $obj->id = $products['id'];
        $obj->name = $products['name'];
        $obj->description = $products['description'];
        $obj->price = $products['price'];
        $obj->image_url = $products['image_url'];

        return $obj;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }
    public function getAmount(): int
    {
        return $this->amount;
    }
    public function setReviewsNew(array $reviewsNew)
    {
        $this->reviewsNew = $reviewsNew;
    }
    public function getReviewsNew()
    {
        return $this->reviewsNew;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }




}