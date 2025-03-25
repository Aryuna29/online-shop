<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private AuthInterface $authService;
    private CartService $cartService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function createOrder (OrderCreateDTO $data)
    {
        $sum = $this->cartService->getSum();

        if ($sum < 1000) {
            throw new \Exception('Для оформления заказа сумма корзины должна быть больше 1000');
        }

        $user = $this->authService->getCurrentUser();
        $orderId = Order::create(
            $data->getName(),
            $data->getPhone(),
            $data->getAddress(),
            $data->getComment(),
            $user->getId()
        );
        $userProducts = UserProduct::getALLByUserId($user->getId());
        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();
            OrderProduct::create($orderId, $productId, $amount);
        }
        UserProduct::deletelByUserId($user->getId());
    }

    public function getAll(): array | null
    {
        $user = $this->authService->getCurrentUser();
        $orders = Order::getALLByUserId($user->getId());
        if ($orders != null) {
            foreach ($orders as $userOrder) {
                $orderProducts = OrderProduct::getALLByOrderIdWithProduct($userOrder->getId());
                $total = 0;
                foreach ($orderProducts as $orderProduct) {
                    $itemSum = $orderProduct->getAmount() * $orderProduct->getProduct()->getPrice();
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