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
            if (strlen($review) < 2 || strlen($review) > 255) {
                $errors['review'] = 'длина строки должна быть больше 2 и меньше 255 символов!';
            }
        }
        if (isset($this->data['rating'])) {
            $rating = $this->data['rating'];

            if (!is_numeric($rating)) {
                $errors['rating'] = 'оценка не может быть строкой';
            } elseif ($rating > 5 || $rating < 1) {
                $errors['rating'] = 'укажите верную оценку';
            }
        } else {
            $errors['rating'] = 'укажите оценку';
        }
        return $errors;
    }

}