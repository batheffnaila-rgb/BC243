<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$repo = new ProductRepository();
$products = $repo->all();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Products - List</title></head>
<style>
* {
  font-family: 'Segoe UI', sans-serif;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  background: #f4f6f9;
  padding: 40px;
}

.container {
  max-width: 900px;
  margin: auto;
  background: white;
  padding: 25px;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

h1 {
  margin-bottom: 20px;
  color: #222;
}

a {
  text-decoration: none;
  background: #2563eb;
  color: white;
  padding: 10px 16px;
  border-radius: 8px;
  display: inline-block;
  margin-bottom: 15px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

table th {
  background: #f1f3f8;
  text-align: left;
  padding: 12px;
}

table td {
  padding: 12px;
  border-top: 1px solid #eee;
}

form input,
form select {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  margin-bottom: 15px;
}

button {
  background: #2563eb;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

button:hover {
  background: #1e4fd8;
}

</style>
<body>
<h1>Products</h1>
<p><a href="create.php">+ Add Product</a></p>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Image</th><th>Action</th></tr>
    </thead>
    <tbody>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?=htmlspecialchars($p['id'])?></td>
            <td><?=htmlspecialchars($p['name'])?></td>
            <td><?=htmlspecialchars($p['category'])?></td>
            <td><?=number_format($p['price'],2)?></td>
            <td><?=htmlspecialchars($p['stock'])?></td>
            <td><?=htmlspecialchars($p['status'])?></td>
            <td>
                <?php if ($p['image_path']): ?>
                    <img src="uploads/<?=htmlspecialchars(basename($p['image_path']))?>" alt="" width="60">
                <?php endif; ?>
            </td>
            <td>
                <a href="detail.php?id=<?= $p['id'] ?>">Detail</a> |
                <a href="edit.php?id=<?= $p['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
