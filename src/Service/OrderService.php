<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private AuthService $authService;
    private Product $productModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->authService = new AuthService();
        $this->productModel = new Product();
    }

    public function createOrder (OrderCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getAddress(),
            $data->getComment(),
            $user->getId()
        );
        $userProducts = $this->userProductModel->getALLByUserId($user->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();
            $this->orderProductModel->create($orderId, $productId, $amount);
        }
        $this->userProductModel->deletelByUserId($user->getId());
    }

    public function getAll(): array | null
    {
        $user = $this->authService->getCurrentUser();
        $orders = $this->orderModel->getALLByUserId($user->getId());

        if ($orders != null) {
            foreach ($orders as $userOrder) {
                $orderProducts = $this->orderProductModel->getALLByOrderId($userOrder->getId());
                $total = 0;

                foreach ($orderProducts as $orderProduct) {

                    $product = $this->productModel->getById($orderProduct->getProductId());
                    $orderProduct->setProduct($product);

                    $itemSum = $orderProduct->getAmount() * $product->getPrice();
                    $orderProduct->setSum($itemSum);

                    $total += $itemSum;
                }

                $userOrder->setOrderProducts($orderProducts);
                $userOrder->setTotal($total);
            }
        }
        return $orders;
    }
}