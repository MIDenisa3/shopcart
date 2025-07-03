<?php
class Product {
    public static function getAll($pdo) {
        return $pdo->query("SELECT * FROM products")->fetchAll();
    }

    public static function getByIds($pdo, $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }
}
