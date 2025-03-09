<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }
    public function addProduct(int $productId, int $userId, int $amount)
    {
            $ident = $this->userProductModel->getById($productId, $userId);
            if ($ident !== null) {
                $amount = $amount + $ident->getAmount();

                $this->userProductModel->updateById($productId, $userId, $amount);
            } else {
                $this->userProductModel->insertId($userId , $productId, $amount);
            }
    }

    public function decreaseProduct(int $productId, int $userId, int $amount)
    {
        $ident = $this->userProductModel->getById($productId, $userId);
        if (!$ident) {
           return false;
        }
        $amountNew = $ident->getAmount();
        if ($amountNew > 1) {
            $amount =$amountNew - $amount;
            $this->userProductModel->updateById($productId, $userId, $amount);
        }
        else {
            $this->userProductModel->deleteById($productId, $userId);
        }
    }

}