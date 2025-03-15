<?php

namespace Request;

use Model\User;

class ProfileEditedRequest
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

    public function validate(): null|array
    {
        $errors = [];
        $name = $this->data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = 'Имя быть больше 2 символов';
        } elseif (is_numeric($name)) {
            $errors['name'] = 'Имя не должно содержать цифры';
        }
        $email = $this->data['email'];
        if (strlen($email) < 3) {
            $errors['email'] = 'email должен быть больше 3 символов';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email некорректный';
        } else {
            $user = $this->userModel->getByEmail($email);
            $userId = $_SESSION['userId'];
            if (!empty($user)) {
                if ($user->getId() !== $userId) {
                    $errors['email'] = 'email уже существует';
                }
            }
        }

        return $errors;
    }
}