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
                   <form method="post" action="index.php?page=cart" style="display:inline;">
                        <input type="hidden" name="remove_id" value="<?= $p['id'] ?>">
                        <button type="submit">Șterge</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="cart-total">Total: <?= number_format($total, 2) ?> RON</div>

        <form method="post" action="index.php?page=checkout">
            <button type="submit">Finalizează comanda</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
