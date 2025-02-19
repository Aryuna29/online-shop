<?php

namespace Controllers;
class ProductController
{
    public function getCatalog()
    {
        require_once '../Views/catalog_form.php';
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

//        require_once '../Model/Product.php';
        $productModel = new \Model\Product();
        $products = $productModel->getProduct();

        if (isset($_POST['submit'])) {
            $errors = $this->validateCatalog($_POST);
            if (empty($errors)) {
                $amountNew = $_POST['amount'];
                $product_id = $_POST['product_id'];
                $user_id = $_SESSION['userId'];
//                require_once '../Model/UserProduct.php';
                $userProductModel = new \Model\UserProduct();
                $ident = $userProductModel->getById($product_id, $user_id);
                if ($ident !== false) {
                    $amount = $amountNew + $ident['amount'];

                    $userProductModel->updateById($product_id, $user_id ,$amount);
                } else {

                    $userProductModel->insertId($user_id, $product_id, $amountNew);
                }
                header('Location: http://localhost:81/cart');
            }
        }
        require_once '../Views/catalog_form.php';
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
        require_once '../Views/cart_form.php';
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

//        require_once '../Model/UserProduct.php';
        $userProductModel = new \Model\UserProduct();
        $data = $userProductModel->getByUserId($user_id);

        $products =[];
        foreach ($data as $data) {
            $productId = $data['product_id'];

//            require_once '../Model/Product.php';
            $productModel = new \Model\Product();
            $product = $productModel->getById($productId);

            $product['amount'] = $data['amount'];
            $products[] = $product;

            if (isset($_POST['submit'])) {
                $user_id = $_SESSION['userId'];
                    $userProductModel->deleteById($productId, $user_id);
                    header('Location: http://localhost:81/catalog');
            }
        }


        require_once '../Views/cart_form.php';
    }

}