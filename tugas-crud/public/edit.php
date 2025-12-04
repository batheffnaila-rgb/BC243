<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$repo = new ProductRepository();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $repo->find($id);
if (!$product) {
    echo "Not found. <a href='index.php'>Back</a>";
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Product</title></head>
<body>
<h1>Edit Product</h1>
<form action="update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=htmlspecialchars($product['id'])?>">
    <label>Name: <input type="text" name="name" required maxlength="100" value="<?=htmlspecialchars($product['name'])?>"></label><br><br>
    <label>Category:
        <select name="category" required>
            <option value="">--select--</option>
            <?php foreach (['Electronics','Clothing','Book'] as $cat): ?>
                <option value="<?= $cat ?>" <?= $product['category'] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <label>Price: <input type="number" name="price" step="0.01" min="0" required value="<?=htmlspecialchars($product['price'])?>"></label><br><br>
    <label>Stock: <input type="number" name="stock" min="0" required value="<?=htmlspecialchars($product['stock'])?>"></label><br><br>
    <label>Current Image:
        <?php if ($product['image_path']): ?>
            <img src="uploads/<?=htmlspecialchars(basename($product['image_path']))?>" width="80" alt="">
        <?php else: ?> No image
        <?php endif; ?>
    </label><br><br>
    <label>Replace Image: <input type="file" name="image"></label><br>
    <small>Leave empty to keep existing image.</small><br><br>
    <label>Status:
        <select name="status" required>
            <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </label><br><br>
    <button type="submit">Update</button>
</form>
<p><a href="index.php">Back to list</a></p>
</body>
</html>
