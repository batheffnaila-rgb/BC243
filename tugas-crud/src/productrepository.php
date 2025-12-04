<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Product.php';

class ProductRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(Product $p): int {
        $sql = "INSERT INTO products (name, category, price, stock, image_path, status) VALUES (:name,:category,:price,:stock,:image_path,:status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $p->name,
            ':category' => $p->category,
            ':price' => $p->price,
            ':stock' => $p->stock,
            ':image_path' => $p->image_path,
            ':status' => $p->status,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, Product $p): bool {
        $sql = "UPDATE products SET name=:name, category=:category, price=:price, stock=:stock, image_path=:image_path, status=:status WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $p->name,
            ':category' => $p->category,
            ':price' => $p->price,
            ':stock' => $p->stock,
            ':image_path' => $p->image_path,
            ':status' => $p->status,
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
