<?php

namespace Request;

use Model\User;

class RegistrateRequest
{
    private User $userModel;
    public function __construct(private array $data)
    {
        $this->userModel = new User();
    }

    public function getName(): string
    {
        return $this->data['name'];
    }
    public function getEmail(): string
    {
        return $this->data['email'];
    }
    public function getPassword(): string
    {
        return $this->data['psw'];
    }
    public function getPasswordRep(): string
    {
        return $this->data['psw-repeat'];
    }
    public function Validate(): array|null
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно быть больше 2';
            } elseif (is_numeric($name)) {
                $errors['name'] = 'Имя не должно содержать цифры';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = 'email должен быть больше 3 символов';
            } elseif (!ctype_lower($email)) {
                $errors['email'] = 'email должен состоять только из букв в нижнем регистре';
            }
            elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                $result = User::getByEmail($email);
                if ($result !== null) {
                    $errors['email'] = 'email уже существует';
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (strlen($password) < 4) {
                $errors['password'] = 'пароль должен быть больше 4 символов';
            }
            $passwordRep = $this->data['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['passwordRep'] = 'пароли не совпали';
            }
        } else {
            $errors['password'] = 'пароль должен быть заполнен';
        }

        return $errors;
    }
}