<?php

namespace Request;

class HandleCheckoutRequest
{

    public function __construct(private array $data)
    {
    }

    public function getContactName(): string
    {
        return $this->data['contact_name'];
    }
    public function getContactPhone(): string
    {
        return $this->data['contact_phone'];
    }
    public function getAddress(): string
    {
        return $this->data['address'];
    }
    public function getComment(): string
    {
        return $this->data['comment'];
    }
    public function Validate(): array|null
    {
        $errors = [];

        if (isset($this->data['address'])) {
            $address = $this->data['address'];
            if (strlen($address) < 5) {
                $errors['address'] = 'Адрес должно быть больше 5 символов';

            }

        } else {
            $errors['address'] = 'Адрес должен быть заполнен';
        }

        if (isset($this->data['contact_phone'])) {
            $phone = $this->data['contact_phone'];
            if (!preg_match('/^8\d{10}$/', $phone)) {
                $errors['contact_phone'] = 'некорректный номер телефона';
            }
        } else {
            $errors['contact_phone'] = 'Номер телефона должен быть заполнен';
        }

        if (isset($this->data['contact_name'])) {
            $name = $this->data['contact_name'];
            if (strlen($name) < 2) {
                $errors['contact_name'] = 'Имя должно быть больше 2';
            } elseif (is_numeric($name)) {
                $errors['contact_name'] = 'Имя не должно содержать цифры';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }
        if (isset($this->data['comment'])) {
            $name = $this->data['comment'];
            if (strlen($name) > 255) {
                $errors['comment'] = 'комментарий не может быть больше 255 символов';
            }
        }
        return $errors;
    }
}