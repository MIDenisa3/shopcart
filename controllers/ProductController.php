<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $qty = max(1, (int)$_POST['qty']);
            $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;

            header("Location: index.php?added=1");
            exit;
        }

        $products = Product::getAll($this->pdo);
        require __DIR__ . '/../views/productsList.php';
    }
}
