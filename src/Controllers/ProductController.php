<?php

namespace Controllers;

use DTO\CartAddProductDTO;
use DTO\CartDecreaseProductDTO;
use Model\User;
use Model\UserProduct;
use Model\Product;
use Model\Review;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Request\AddReviewsRequest;
use Request\GetProductRequest;
use Service\CartService;

class ProductController extends BaseController
{

    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
    }
    public function catalog()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $cart = UserProduct::getCount($user->getId());
        $products = Product::getProducts();
        foreach ($products as $product) {
            $userProduct = UserProduct::getById($product->getId(), $user->getId());
            if ($userProduct === null) {
                $product->setAmount(0);
            } else {
                $amount = $userProduct->getAmount();
                $product->setAmount($amount);
            }
        }

        require_once '../Views/catalog_form.php';
    }
    public function addProduct(AddProductRequest $request)
    {

        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
                $dtoAdd = new CartAddProductDTO($request->getProductId(), $request->getAmount());
                $this->cartService->addProduct($dtoAdd);

        require_once '../Views/catalog_form.php';
    }

    public function decreaseProduct(DecreaseProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
                $dtoDecrease = new CartDecreaseProductDTO($request->getProductId(), $request->getAmount());
                $result = $this->cartService->decreaseProduct($dtoDecrease);
                if (!$result) {
                    header('Location: /catalog');
                }
        require_once '../Views/catalog_form.php';
    }


    public function cart()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $userProducts = $this->cartService->getUserProducts();

        require_once '../Views/cart_form.php';
    }

    public function getProduct(GetProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();
        $productId = $request->getProductId();
        $product = Product::getById($productId);
        $reviews = Review::getAllReviews($productId);
        if ($reviews === null) {
            $ratingTotal = 0;
        } else {
            $count = count($reviews);
            $rating = 0;
            foreach ($reviews as $review) {
                $review->setUser(User::getById($review->getUserId()));
                $rating += $review->getRating();
            }
            $ratingTotal = $rating / $count;
        }
            require_once '../Views/review_form.php';
    }

    public function addReviews(AddReviewsRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
            $errors = $request->validate();

            if (empty($errors)) {
                $user = $this->authService->getCurrentUser();
                $userId = $user->getId();
                $productId = $request->getProductId();
                $review = $request->getReview();
                $time = date("Y-m-d H:i:s");
                $rating = $request->getRating();
                Review::create($productId, $userId, $review, $time, $rating);
                header('Location: /catalog');
            } else {
                print_r($errors);
                die();
            }
        require_once '../Views/review_form.php';
    }

}