<?php
session_start();
require_once 'db/connect.php';
require_once 'controllers/ProductController.php';

$page = $_GET['page'] ?? 'products';

switch ($page) {
    case 'cart':
        require_once 'controllers/CartController.php';
        $controller = new CartController($pdo);
        $controller->handle();
        break;
    case 'checkout':
        require_once 'controllers/CheckoutController.php';
        $controller = new CheckoutController($pdo);
        $controller->handle();
        break;
    case 'products':
    default:
        require_once 'controllers/ProductController.php';   
        $controller = new ProductController($pdo);
        $controller->handle();
        break;
}