<?php

function Validate(array $data): array|null
{
    $errors = [];

    if (isset($data['name'])) {
        $name = $data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = 'Имя должно быть больше 2';
        } elseif (is_numeric($name)) {
            $errors['name'] = 'Имя не должно содержать цифры';
        }
    } else {
        $errors['name'] = 'Имя должно быть заполнено';
    }

    if (isset($data['email'])) {
        $email = $data['email'];
        if (strlen($email) < 3) {
            $errors['email'] = 'email должен быть больше 3 символов';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email некорректный';
        } else {
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $identEmail = $stmt->fetch();
            if ($identEmail > 0) {
                $errors['email'] = 'email уже существует';
            }
        }
    } else {
        $errors['email'] = 'email должен быть заполнен';
    }

    if (isset($data['psw'])) {
        $password = $data['psw'];
        if (strlen($password) < 4) {
            $errors['password'] = 'пароль должен быть больше 4 символов';
        }
        $passwordRep = $data['psw-repeat'];
        if ($password !== $passwordRep) {
            $errors['passwordRep'] = 'пароли не совпали';
        }
    } else {
        $errors['password'] = 'пароль должен быть заполнен';
    }

    return $errors;
}

$errors = Validate($_POST);

if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRep = $_POST['psw-repeat'];
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    print_r($result);
}


require_once './registration_form.php';
