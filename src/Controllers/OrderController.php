<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Request\HandleCheckoutRequest;
use Service\CartService;
use Service\OrderService;

class OrderController extends BaseController
{

    private OrderService $orderService;
    private CartService $cartService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        parent::__construct();
    }


    public function getCheckoutForm()
    {
        if (!$this->authService->check()) {
            header('location: /login');
        }

        $userProducts = $this->cartService->getUserProducts();
        if (empty($userProducts)) {
            header('location: /catalog');
            exit();
        }
            require_once '../Views/order_form.php';
    }

    public function handleCheckout(HandleCheckoutRequest $request)
    {
        if (!$this->authService->check()) {
            header('location: /login');
        }
        $errors = $request->Validate();
        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getContactName(),
                $request->getContactPhone(),
                $request->getAddress(),
                $request->getComment(),
            );

            $this->orderService->createOrder($dto);
            header('location: /catalog');
        } else {
            $userProducts = $this->cartService->getUserProducts();
            require_once "../Views/order_form.php";
        }


    }

    public function getUserOrder()
    {

        if (!$this->authService->check()) {
            header('location: /login');
        }
        $userOrders = $this->orderService->getAll();
        require_once '../Views/orderUsers_form.php';
    }


}