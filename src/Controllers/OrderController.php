<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController
{

    private  UserProduct $userProductModel;
    private Product $productModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
    }
    public function getCheckoutForm()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header('location: /login');
        }
        $userId = $_SESSION['userId'];

        $products = $this->userProductModel->getALLByUserId($userId);
        $newProductOrder =[];
        $totalCost = 0;
        foreach ($products as $product) {
            $productId = $product->getProductId();

            $productData = $this->productModel->getById($productId);

            $newProduct['product'] = $productData;
            $newProduct['amount'] = $product->getAmount();
            $newProduct['cost'] = $product->getAmount() * $productData->getPrice();
            $newProductOrder[] = $newProduct;
            $totalCost += $newProduct['cost'];
        }
            require_once '../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header('location: /login');
        }

        $errors = $this->Validate($_POST);
        if (empty($errors)) {
            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];
            $userId = $_SESSION['userId'];

            $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $userId);

            $userProducts = $this->userProductModel->getALLByUserId($userId);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $this->orderProductModel->create($orderId, $productId, $amount);
            }

            $this->userProductModel->deletelByUserId($userId);

            header('location: /catalog');
        } else {
            require_once "../Views/order_form.php";
        }


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

        if (isset($data['contact_phone'])) {
            $phone = $data['contact_phone'];
            if (!preg_match('/^8\d{10}$/', $phone)) {
                $errors['contact_phone'] = 'некорректный номер телефона';
            }
        } else {
            $errors['contact_phone'] = 'Номер телефона должен быть заполнен';
        }

        if (isset($data['contact_name'])) {
            $name = $data['contact_name'];
            if (strlen($name) < 2) {
                $errors['contact_name'] = 'Имя должно быть больше 2';
            } elseif (is_numeric($name)) {
                $errors['contact_name'] = 'Имя не должно содержать цифры';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }
        if (isset($data['comment'])) {
            $name = $data['comment'];
            if (strlen($name) > 255) {
                $errors['comment'] = 'комментарий не может быть больше 255 символов';
            }
        }

        return $errors;
    }

    public function getUserOrder()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header('location: /login');
        }
        $userId = $_SESSION['userId'];


        $userOrders = $this->orderModel->getALLByUserId($userId);
            $newUserOrders = [];
            foreach ($userOrders as $userOrder) {

                $orderProducts = $this->orderProductModel->getALLByOrderId($userOrder->getId());
                $newOrderProducts = [];
                $sum = 0;
                foreach ($orderProducts as $orderProduct) {
                    $product = $this->productModel->getById($orderProduct->getProductId());
                    $newOrderProduct['product'] = $product;
                    $newOrderProduct['amount'] = $orderProduct->getAmount();
                    $newOrderProduct['totalSum'] = $orderProduct->getAmount() * $product->getPrice();
                    $newOrderProducts[] = $newOrderProduct;

                    $sum += $newOrderProduct['totalSum'];
                }
                $userOrderNew['user'] = $userOrder;
                $userOrderNew['total'] = $sum;
                $userOrderNew['products'] = $newOrderProducts;
                $newUserOrders[] = $userOrderNew;
            }
        require_once '../Views/orderUsers_form.php';
    }


}