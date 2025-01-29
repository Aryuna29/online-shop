<?php
$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];
$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

if ( strlen($name) >= 2 && str_ends_with($email, '@mail.ru') && $password >= 4 && $passwordRep == $password ) {

    $pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
} else {
    echo "Данные введены некорректно!";
}

$test = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$result = $test->fetch();

echo "<pre>";
print_r($result);
echo "<pre>";