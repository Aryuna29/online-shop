<?php

namespace Request;

class AddProductRequest
{
    public function __construct(private array $data)
    {
    }
    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function validate()
    {

    }
}