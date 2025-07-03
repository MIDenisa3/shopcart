<!DOCTYPE html>
<html>
<head>
    <title>ShopCart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="notification" style="display:none; position:fixed; top:10px; right:10px; background:#4caf50; color:white; padding:10px; border-radius:5px; box-shadow:0 0 5px rgba(0,0,0,0.3); z-index:1000;">
    Produs adăugat în coș!
</div>
<script>
if (window.location.search.indexOf('added=1') !== -1) {
    const notif = document.getElementById('notification');
    notif.style.display = 'block';
    setTimeout(() => {
        notif.style.display = 'none';
        if (history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('added');
            history.replaceState(null, '', url.toString());
        }
    }, 3000);
}
</script>

<header>
    <h1>ShopCart</h1>
   <a href="index.php?page=cart" style="color: white; text-decoration: none;">🛒 Vezi coșul</a>
</header>

<div class="container">
    <h2>Produse disponibile</h2>
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            <div class="product-details">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p>Preț: <?= number_format($p['price'], 2) ?> RON</p>
            </div>
            <form method="post" action="index.php?page=products">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <input type="number" name="qty" value="1" min="1" style="width: 60px;">
                <button type="submit">Adaugă în coș</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
