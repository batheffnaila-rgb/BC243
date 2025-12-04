<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$repo = new ProductRepository();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$p = $repo->find($id);
if (!$p) { echo "Not found. <a href='index.php'>Back</a>"; exit; }
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Detail</title></head>
<body>
<h1>Product Detail</h1>
<p><strong>ID:</strong> <?=htmlspecialchars($p['id'])?></p>
<p><strong>Name:</strong> <?=htmlspecialchars($p['name'])?></p>
<p><strong>Category:</strong> <?=htmlspecialchars($p['category'])?></p>
<p><strong>Price:</strong> <?=number_format($p['price'],2)?></p>
<p><strong>Stock:</strong> <?=htmlspecialchars($p['stock'])?></p>
<p><strong>Status:</strong> <?=htmlspecialchars($p['status'])?></p>
<?php if ($p['image_path']): ?>
    <p><img src="uploads/<?=htmlspecialchars(basename($p['image_path']))?>" width="200"></p>
<?php endif; ?>
<p><a href="index.php">Back to list</a></p>
</body>
</html>
