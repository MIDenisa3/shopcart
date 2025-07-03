<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class CheckoutController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handle() {
        $cart = $_SESSION['cart'] ?? [];

        if (!$cart) {
            header("Location: index.php?page=cart");
            exit;
        }

        $products = Product::getByIds($this->pdo, array_keys($cart));

        $total = 0;
        foreach ($products as $p) {
            $subtotal = $p['price'] * $cart[$p['id']];
            $total += $subtotal;
        }

        $orderId = Order::create($this->pdo, $total, $cart);
        unset($_SESSION['cart']);

        require __DIR__ . '/../views/checkoutSuccess.php';
    }
}
