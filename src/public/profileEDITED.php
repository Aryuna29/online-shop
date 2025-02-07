<?php
session_start();
function valid(array $data): null|array
{
    $errors = [];

    $name = $data['name'];
    if (strlen($name) < 2) {
        $errors['name'] = 'Имя быть больше 2 символов';
    } elseif (is_numeric($name)) {
        $errors['name'] = 'Имя не должно содержать цифры';
    }
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

    return $errors;
}

if (isset($_SESSION['userId'])) {
    require_once 'FORMeditedProfile.php';
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id =:id");
    $stmt->execute(array(":id" => $_SESSION['userId']));
    $user = $stmt->fetch();
    if (isset($_POST['submit'])) {
        $errors = valid($_POST);
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $stmt = $pdo->prepare("UPDATE users SET name = '$name', email = '$email'  WHERE id = :id");
            $stmt->execute([':id' => $_SESSION['userId']]);
            header('Location: http://localhost:81/profile');
        }

    }
} else {
    header('Location: http://localhost:81/login');
}
?>

