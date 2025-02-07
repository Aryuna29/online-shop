<?php

function Validate(array $data): array|null
{
    $errors = [];
    if (empty($data['u'])) {
        $errors['username'] = 'Логин не заполнен';
    }
    if (empty($data['p'])) {
        $errors['password'] = 'пароль не заполнен';
    }
    return $errors;
}


$errors = Validate($_POST);

if (empty($errors)) {
    $username = $_POST['u'];
    $password = $_POST['p'];
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
            $_SESSION['userId'] = $user['id'];
            //setcookie('user_id', $user['id']);
            header("Location: http://localhost:81/catalog");
        } else {
            $errors['username'] = 'логин или пароль указаны неверно';
        }
    }

}
require_once './login_form.php';