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

    private UserProduct $userProductModel;
    private Product $productModel;
    private Review $reviewModel;
    private CartService $cartService;
    private User $userModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->reviewModel = new Review();
        parent::__construct();
        $this->cartService = new CartService();
        $this->userModel = new User();
    }
    public function catalog()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $user = $this->authService->getCurrentUser();

        $products = $this->productModel->getProducts();

        foreach ($products as $product) {
            $userProduct = $this->userProductModel->getById($product->getId(), $user->getId());
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
                header('Location: /catalog');

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
        $product = $this->productModel->getById($productId);
        $reviews = $this->reviewModel->getAllReviews($productId);
        if ($reviews === null) {
            $ratingTotal = 0;
        } else {
            $count = count($reviews);
            $rating = 0;
            foreach ($reviews as $review) {
                $review->setUser($this->userModel->getById($review->getUserId()));
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
                $this->reviewModel->create($productId, $userId, $review, $time, $rating);
                header('Location: /catalog');
            }
        require_once '../Views/review_form.php';
    }

}