<?php

namespace Request;


class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getUsername(): string
    {
        return $this->data['u'];
    }
    public function getPassword(): string
    {
        return $this->data['p'];
    }
    public function validate(): array|null
    {
        $errors = [];
        if (empty($this->data['u'])) {
            $errors['username'] = 'Логин не заполнен';
        }
        if (empty($this->data['p'])) {
            $errors['password'] = 'пароль не заполнен';
        }
        return $errors;
    }
}