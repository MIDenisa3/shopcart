<?php
session_start();
require 'db/connect.php';

if (isset($_POST['remove_id'])) {
    $removeId = (int)$_POST['remove_id'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit;
}


//verifica daca sunt produse in cos
$cart = $_SESSION['cart'] ?? [];
$products = [];

if ($cart) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $products = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Coșul meu</title>
</head>
<body>
   <header>
        <h1>Coșul de cumpărături</h1>
        <a href="index.php" style="color: #007bff; text-decoration: none;">← Înapoi la produse</a>
    </header>

    <div class="container">
        <?php if (!$products): ?>
            <p>Coșul este gol.</p>
        <?php else: ?>
            <ul class="cart-list">
                <?php $total = 0; ?>
                <?php foreach ($products as $p): ?>
                    <?php $subtotal = $p['price'] * $cart[$p['id']]; ?>
                    <?php $total += $subtotal; ?>
                    <li>
                        <strong><?= htmlspecialchars($p['name']) ?></strong> – <?= $cart[$p['id']] ?> x <?= number_format($p['price'], 2) ?> RON = <?= number_format($subtotal, 2) ?> RON
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="remove_id" value="<?= $p['id'] ?>">
                            <button type="submit">Șterge</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="cart-total">Total: <?= number_format($total, 2) ?> RON</div>

            <form method="post" action="checkout.php">
                <button type="submit">Finalizează comanda</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
