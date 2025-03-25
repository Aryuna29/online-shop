<?php

namespace Service;

use DTO\CartAddProductDTO;
use DTO\CartDecreaseProductDTO;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private AuthInterface $authService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }
    public function addProduct(CartAddProductDTO $dataAdd)
    {
            $user = $this->authService->getCurrentUser();
            $userProduct = UserProduct::getById($dataAdd->getProductId(), $user->getId());
            if ($userProduct !== null) {
                $amount = $dataAdd->getAmount() + $userProduct->getAmount();

                UserProduct::updateById($dataAdd->getProductId(), $user->getId(), $amount);
            } else {
                UserProduct::insertId($user->getId(), $dataAdd->getProductId(), $dataAdd->getAmount());
            }
    }

    public function decreaseProduct(CartDecreaseProductDTO $dataDecrease)
    {
        $user = $this->authService->getCurrentUser();
        $userProduct = UserProduct::getById($dataDecrease->getProductId(), $user->getId());
        if (!$userProduct) {
           return false;
        }
        $amountNew = $userProduct->getAmount();
        if ($amountNew > 1) {
            $amount =$amountNew - $dataDecrease->getAmount();
            UserProduct::updateById($dataDecrease->getProductId(), $user->getId(), $amount);
        }
        else {
            UserProduct::deleteById($dataDecrease->getProductId(), $user->getId());
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();
        if ($user === null) {
            return [];
        }
        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());
        $totalSum = 0;
        foreach ($userProducts as $userProduct) {
            $sum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setSum($sum);
            $totalSum += $sum;
            $userProduct->setTotalSum($totalSum);
        }
        return $userProducts;
    }

    public function getSum(): int
    {
        $totalSum = 0;
        foreach ($this->getUserProducts() as $userProduct) {
            $totalSum += $userProduct->getSum();
        }
        return $totalSum;
    }

}