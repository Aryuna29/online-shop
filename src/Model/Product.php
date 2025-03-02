<?php

namespace Model;
//require_once '../Model/Model.php';
class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private string $price;
    private string $image_url;

    public function getProduct(): array|null
    {
        $stmt = $this->PDO->query('SELECT * FROM products');
        $result = $stmt->fetchAll();
        $data = [];
        foreach ($result as $product) {
            $obj = new self();
            $obj->id = $product['id'];
            $obj->name = $product['name'];
            $obj->description = $product['description'];
            $obj->price = $product['price'];
            $obj->image_url = $product['image_url'];
            $data[] = $obj;
        }
        return $data;
    }


    public function getById(int $productId): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $result['id'];
        $obj->name = $result['name'];
        $obj->description = $result['description'];
        $obj->price = $result['price'];
        $obj->image_url = $result['image_url'];
        return $obj;

    }


    public function setProduct($product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->description = $product->getDescription();
        $this->price = $product->getPrice();
        $this->image_url = $product->getImageUrl();
        return $product;
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




}