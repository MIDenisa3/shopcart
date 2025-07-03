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
