<?php

namespace Service;

use DTO\CartAddProductDTO;
use DTO\CartDecreaseProductDTO;
use Model\Product;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    private AuthService $authService;
    private Product $productModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->productModel = new Product();
    }
    public function addProduct(CartAddProductDTO $dataAdd)
    {
            $user = $this->authService->getCurrentUser();
            $userProduct = $this->userProductModel->getById($dataAdd->getProductId(), $user->getId());
            if ($userProduct !== null) {
                $amount = $dataAdd->getAmount() + $userProduct->getAmount();

                $this->userProductModel->updateById($dataAdd->getProductId(), $user->getId(), $amount);
            } else {
                $this->userProductModel->insertId($user->getId(), $dataAdd->getProductId(), $dataAdd->getAmount());
            }
    }

    public function decreaseProduct(CartDecreaseProductDTO $dataDecrease)
    {
        $user = $this->authService->getCurrentUser();
        $userProduct = $this->userProductModel->getById($dataDecrease->getProductId(), $user->getId());
        if (!$userProduct) {
           return false;
        }
        $amountNew = $userProduct->getAmount();
        if ($amountNew > 1) {
            $amount =$amountNew - $dataDecrease->getAmount();
            $this->userProductModel->updateById($dataDecrease->getProductId(), $user->getId(), $amount);
        }
        else {
            $this->userProductModel->deleteById($dataDecrease->getProductId(), $user->getId());
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();
        if ($user === null) {
            return [];
        }
        $userProducts = $this->userProductModel->getALLByUserId($user->getId());
        $totalSum = 0;
        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $product = $this->productModel->getById($productId);
            $userProduct->setProduct($product);
            $sum = $userProduct->getAmount() * $product->getPrice();
            $userProduct->setSum($sum);
            $totalSum += $sum;
            $userProduct->setTotalSum($totalSum);
        }
        return $userProducts;
    }

}