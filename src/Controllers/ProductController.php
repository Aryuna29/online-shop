<?php

namespace Controllers;

use Model\User;
use Model\UserProduct;
use Model\Product;
use Model\Review;
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
    public function addProductCatalog()
    {

        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        if (isset($_POST['submit'])) {

               $data = $_POST;
                $user = $this->authService->getCurrentUser();
                $this->cartService->addProduct($data['product_id'], $user->getId(), $data['amount']);
                header('Location: /catalog');
            }
        require_once '../Views/catalog_form.php';
    }

    public function decreaseProductCatalog()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        if (isset($_POST['submit'])) {
                $data = $_POST;
                $user = $this->authService->getCurrentUser();
                $result = $this->cartService->decreaseProduct($data['product_id'], $user->getId(), $data['amount']);
                if (!$result) {
                    header('Location: /catalog');
                }
            }
        require_once '../Views/catalog_form.php';
    }


    public function cart()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();

        $userProducts = $this->userProductModel->getALLByUserId($userId);

        $products =[];
        foreach ($userProducts as $userProduct) {
            $product = $this->productModel->getById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $products[] = $userProduct;
            if (isset($_POST['submit'])) {
                $user = $_SESSION['userId'];
                    $this->userProductModel->deleteById($userProduct->getProductId(), $userId);
                    header('Location: http://localhost:81/cart');
            }
        }

        require_once '../Views/cart_form.php';
    }

    public function getProduct()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();
        $productId = $_POST['product_id'];
        $product = $this->productModel->getById($productId);
        $reviews = $this->reviewModel->getAllReviews($productId);
        foreach ($reviews as $review) {
            $review->setUser($this->userModel->getById($review->getUserId()));
        }
            require_once '../Views/review_form.php';
    }

    public function addReviews()
    {
        if (!$this->authService->check()) {
            header('Location:http://localhost:81/login');
            exit();
        }
            $errors = $this->validateReview($_POST);

            if (empty($errors)) {
                $user = $this->authService->getCurrentUser();
                $userId = $user->getId();
                $productId = $_POST['product_id'];
                $review = $_POST['review'];
                $this->reviewModel->create($userId, $productId, $review);
                header('Location: /catalog');
            }
        require_once '../Views/review_form.php';
    }
    private function validateReview(array $data): array|null
    {
        $errors = [];

        if (isset($data['review'])) {
            $review = $data['review'];
            if (strlen($review) > 255) {
                $errors['review'] = 'больше 255 символов!';
            }
        }
        return $errors;
    }
}