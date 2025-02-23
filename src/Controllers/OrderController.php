<?php

namespace Controllers;
use Model\Model;

class OrderController
{

    public function getOrder()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header('location: /login');
        }
        require_once '../Views/order_form.php';
    }
    public function order()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header('location: /login');
        }
        $userId = $_SESSION['userId'];

//        require_once '../Model/UserProduct.php';
        $userProductModel = new \Model\UserProduct();
        $data = $userProductModel->getByUserId($userId);
        $products =[];
        foreach ($data as $data) {
            $productId = $data['product_id'];
            require_once '../Model/Product.php';
            $productModel = new \Model\Product();
            $product = $productModel->getById($productId);
            $product['amount'] = $data['amount'];
            $products[] = $product;
        }
            if (isset($_POST['submit'])) {
                $errors = $this->Validate($_POST);
                if (empty($errors)) {
                    $address = $_POST['address'];
                    $phone = $_POST['phone'];

//                    require_once '../Model/Order.php';
                    $orderModel = new \Model\Order();
                    $orderModel->insert($userId, $address, $phone);

                    $orderId = $orderModel->getIdByUserId($userId);
//
                        $amount= $product['amount'];
//                        require_once '../Model/OrderProduct.php';
                        $orderProductModel = new \Model\OrderProduct();
                        $orderProductModel->insertData($orderId, $productId, $amount);

                }
            }

        require_once "../Views/order_form.php";
    }

    private function Validate(array $data): array|null
    {
        $errors = [];

        if (isset($data['address'])) {
            $address = $data['address'];
            if (strlen($address) < 5) {
                $errors['address'] = 'Адрес должно быть больше 5 символов';

            }

        } else {
            $errors['address'] = 'Адрес должен быть заполнен';
        }

        if (isset($data['phone'])) {
            $phone = $data['phone'];
            if (!preg_match('/^8\d{10}$/', $phone)) {
                $errors['phone'] = 'некорректный номер телефона';
            }
        } else {
            $errors['phone'] = 'Номер телефона должен быть заполнен';
        }

        return $errors;
    }


}