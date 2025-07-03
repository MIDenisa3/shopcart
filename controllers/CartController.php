<?php

require_once __DIR__ . '/../models/Product.php';

class CartController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handle() {
        if (isset($_POST['remove_id'])) {
            $removeId = (int)$_POST['remove_id'];
            unset($_SESSION['cart'][$removeId]);
            header("Location: index.php?page=cart");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        $products = Product::getByIds($this->pdo, array_keys($cart));

        require __DIR__ . '/../views/cartView.php';
    }
}
