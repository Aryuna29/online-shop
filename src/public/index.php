<?php

$errors = [];


function ValidateName($name) {

    if (strlen($name) < 1) {
    return "Имя должно быть больше 1";
    }   elseif (is_numeric($name)) {
    return 'Имя не должно содержать цифры';
    }
}

if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (ValidateName($name)!== null) {
            $errors ['name']= ValidateName($name);
        }
    } else {
        $errors['name'] = 'Имя должно быть заполнено';
    }


function ValidateEmail($email) {

    if (strlen($email) < 3) {
        return 'email должен быть больше 3 символов';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return 'email некорректный';
    }  else  {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $identEmail = $stmt->fetch();
        if ($identEmail > 0) {
            return 'email уже существует';
        }
    }
}


if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (ValidateEmail($email)!== null) {
        $errors ['email']= ValidateEmail($email);
    }
} else {
        $errors['email'] = 'email должен быть заполнен';
    }


function ValidatePassword($password)  {
    if (strlen($password) < 4) {
        return 'пароль должен быть больше 4 символов';
    }
}


if (isset($_POST['psw']) && isset($_POST['psw-repeat']) ) {
    $password = $_POST['psw'];
    $passwordRep = $_POST['psw-repeat'];
    if (validatePassword($password)!== null) {
        $errors['password'] = ValidatePassword($password);
    } elseif ($password !== $passwordRep) {
        $errors['passwordRep'] = 'пароли не совпали';
    }
} else {
    $errors['password'] = 'пароль должен быть заполнен';
}


if (empty($errors)) {
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
