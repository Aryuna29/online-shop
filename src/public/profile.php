<?php

session_start();

if (isset($_SESSION['userId'])) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id =:id");
    $stmt->execute(array(":id" => $_SESSION['userId']));
    $user = $stmt->fetch();
    require_once 'profile_form.php';
} else {
    header('Location: http://localhost:81/login');
}
?>


