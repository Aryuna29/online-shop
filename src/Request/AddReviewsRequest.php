<?php

namespace Request;

class AddReviewsRequest
{

    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }
    public function getReview(): string
    {
        return $this->data['review'];
    }
    public function getRating(): int
    {
        return $this->data['rating'];
    }
    public function validate(): array|null
    {
        $errors = [];

        if (isset($this->data['review'])) {
            $review = $this->data['review'];
            if (strlen($review) > 255) {
                $errors['review'] = 'больше 255 символов!';
            }
        }
        return $errors;
    }

}