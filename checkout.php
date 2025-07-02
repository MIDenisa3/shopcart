<?php
session_start();
require 'db/connect.php';

// Verifică dacă coșul există și are produse
$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    header("Location: cart.php");
    exit;
}

// Obține produsele din coș
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$products = $stmt->fetchAll();

// Calculează totalul
$total = 0;
foreach ($products as $p) {
    $subtotal = $p['price'] * $cart[$p['id']];
    $total += $subtotal;
}

// Salvează comanda în baza de date
$pdo->beginTransaction();

$stmt = $pdo->prepare("INSERT INTO orders (total) VALUES (?)");
$stmt->execute([$total]);
$orderId = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
foreach ($products as $p) {
    $stmt->execute([$orderId, $p['id'], $cart[$p['id']]]);
}

$pdo->commit();

// Golește coșul
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comandă finalizată</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Comandă finalizată ✅</h1>
    </header>

   <div class="container">
     <p>Mulțumim pentru comandă! Totalul este <strong><?= number_format($total, 2) ?> RON</strong>.</p>
     <div class="back-link">
        <a href="index.php" class="btn">← Înapoi la produse</a>
     </div>
    </div>

</body>
</html>
