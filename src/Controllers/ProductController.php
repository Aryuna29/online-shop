<?php

namespace Controllers;

use Model\UserProduct;
use Model\Product;


class ProductController
{

    private UserProduct $userProductModel;
    private Product $productModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
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

        $products = $this->productModel->getProduct();


        if (isset($_POST['submit'])) {
            $errors = $this->validateCatalog($_POST);
            if (empty($errors)) {
                $amountNew = $_POST['amount'];
                $product_id = $_POST['product_id'];
                $user_id = $_SESSION['userId'];

                $ident = $this->userProductModel->getById($product_id, $user_id);
                if ($ident !== null) {
                    $amount = $amountNew + $ident->getAmount();

                    $this->userProductModel->updateById($product_id, $user_id ,$amount);
                } else {

                    $this->userProductModel->insertId($user_id, $product_id, $amountNew);
                }
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

        $userProducts = $this->userProductModel->getALLByUserId($user_id);

        $products =[];
        foreach ($userProducts as $userProduct) {
            $product = $this->productModel->getById($userProduct->getProductId());
            $userProduct[] = $product;
            $products[] = $userProduct;

            if (isset($_POST['submit'])) {
                $user_id = $_SESSION['userId'];
                    $this->userProductModel->deleteById($userProduct->getProductId(), $user_id);
                    header('Location: http://localhost:81/catalog');
            }
        }

        require_once '../Views/cart_form.php';
    }

}