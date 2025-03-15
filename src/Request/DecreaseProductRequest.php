<?php

namespace Request;

class DecreaseProductRequest
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
}