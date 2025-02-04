<?php

$errors = [];
function ValidateLogin($username)
    {
        if (strlen($username) < 4) {
            return 'Логин должен иметь больше 4 символов';
        } elseif (filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
            return 'Логин некорректный';
        }
    }
function ValidatePassword($password) {
         if (strlen($password) < 4) {
         return 'Пароль должен иметь больше 4 символов';
        }
    }

    if (isset($_POST['u'])) {
        $username = $_POST['u'];
        if (ValidateLogin($username)!== null) {
            $errors ['username']= ValidateLogin($username);
        }
    } else {
            $errors['username'] = 'login должен быть заполнен';
    }

    if (isset($_POST['p']) ) {
        $password = $_POST['p'];
        if (validatePassword($password)!== null) {
            $errors['password'] = ValidatePassword($password);
        }
    } else {
    $errors['password'] = 'пароль должен быть заполнен';
    }

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);

    $user = $stmt->fetch();

    if ($user === false) {
        $errors['username'] = 'логин или пароль указаны неверно';
    } else {
        $passwordDB = $user['password'];
        if (password_verify($password, $passwordDB)) {
            session_start();
            $_SESSION['user_id'] = $user;
            //setcookie('user_id', $user['id']);
            header("Location: /catalog.php");
            require_once './login_form.php';
        } else {
            $errors['username'] = 'логин или пароль указаны неверно';
        }
    }

}
