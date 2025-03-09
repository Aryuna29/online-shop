<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController extends BaseController
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
        parent::__construct();
    }


    public function getCheckoutForm()
    {
        if (!$this->authService->check()) {
            header('location: /login');
        }
        $user = $this->authService->getCurrentUser();

        $products = $this->userProductModel->getALLByUserId($user->getId());
        $newProductOrder =[];
        $totalCost = 0;

        foreach ($products as $product) {
            $productId = $product->getProductId();

            $productData = $this->productModel->getById($productId);

            $product->setProduct($productData);
            $product->setSum($product->getAmount() * $productData->getPrice());
            $cost = $product->getSum();
            $newProductOrder[] = $product;
            $totalCost += $cost;
        }
            require_once '../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (!$this->authService->check()) {
            header('location: /login');
        }

        $errors = $this->Validate($_POST);
        $user = $this->authService->getCurrentUser();
        if (empty($errors)) {
            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];


            $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $user->getId());

            $userProducts = $this->userProductModel->getALLByUserId($user->getId());

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();
                $this->orderProductModel->create($orderId, $productId, $amount);
            }
            $this->userProductModel->deletelByUserId($user->getId());

            header('location: /catalog');
        } else {
            $products = $this->userProductModel->getALLByUserId($user->getId());
            $newProductOrder =[];
            $totalCost = 0;

            foreach ($products as $product) {
                $productId = $product->getProductId();

                $productData = $this->productModel->getById($productId);

                $product->setProduct($productData);
                $product->setSum($product->getAmount() * $productData->getPrice());
                $cost = $product->getSum();
                $newProductOrder[] = $product;
                $totalCost += $cost;
            }
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

        if (!$this->authService->check()) {
            header('location: /login');
        }
        $user = $this->authService->getCurrentUser();

        $userOrders = $this->orderModel->getALLByUserId($user->getId());
            $newUserOrders = [];
            if ($userOrders != null) {
                foreach ($userOrders as $userOrder) {
                    $orderProducts = $this->orderProductModel->getALLByOrderId($userOrder->getId());
                    $total = 0;
                    $newOrderProducts = [];
                    foreach ($orderProducts as $orderProduct) {
                        $product = $this->productModel->getById($orderProduct->getProductId());
                        $orderProduct->setProduct($product);
                        $orderProduct->setSum($orderProduct->getAmount() * $product->getPrice());
                        $total += $orderProduct->getSum();
                        $newOrderProducts[] = $orderProduct;
                    }
                    $userOrder->setNewOrderProducts($newOrderProducts);
                    $userOrder->setTotal($total);
                    $newUserOrders[] = $userOrder;
                }
            }
        require_once '../Views/orderUsers_form.php';
    }


}