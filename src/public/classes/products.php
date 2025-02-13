<?php

class products
{
    public function getCatalog()
    {
        require_once './form/catalog_form.php';
    }
public function catalog()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['userId'])) {
        header('Location:http://localhost:81/login');
        exit();
    }
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll();

    if (isset($_POST['submit'])) {
        $errors = $this->validateCatalog($_POST);
        if (empty($errors)) {
            $amountNew = $_POST['amount'];
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['userId'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
            $ident = $stmt->fetch();
            if ($ident !== false) {
                $amount = $amountNew + $ident['amount'];
                $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
                $stmt->execute(['amount' => $amount, 'product_id' => $product_id, 'user_id' => $user_id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
                $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amountNew]);
            }
            header('Location: http://localhost:81/cart');
        }
    }
    require_once './form/catalog_form.php';
  }

  private function validateCatalog(array $data): null|array
    {
        $errors = [];

        if (isset($data['amount'])) {
            $amountNew = $data['amount'];
            if (!is_numeric($amountNew)) {
                $errors['amount'] = 'amount должен содержать только цифры';
            }
} else {
    $errors['amount'] = 'Не заполнено!';
}
return $errors;
}

public function getCart()
{
    require_once './form/cart_form.php';
}
public function cart()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['userId'])) {
        header('Location:http://localhost:81/login');
        exit();
    }
    $user_id = $_SESSION['userId'];

    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id ='$user_id'");
    $data = $stmt->fetchALL();


    require_once './form/cart_form.php';
}

}