<?php
class Order {
    public static function create($pdo, $total, $items) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO orders (total) VALUES (?)");
        $stmt->execute([$total]);
        $orderId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        foreach ($items as $productId => $qty) {
            $stmt->execute([$orderId, $productId, $qty]);
        }
        $pdo->commit();
        return $orderId;
    }
}
