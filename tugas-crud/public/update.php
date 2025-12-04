<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$config = include __DIR__ . '/../src/Config.php';
$uploadCfg = $config['upload'];

$repo = new ProductRepository();
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$existing = $repo->find($id);
if (!$existing) {
    echo "Not found. <a href='index.php'>Back</a>"; exit;
}

$errors = [];

// validations
$name = trim($_POST['name'] ?? '');
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? '';
$stock = $_POST['stock'] ?? '';
$status = $_POST['status'] ?? 'inactive';

if ($name === '') $errors[] = "Name is required.";
if ($category === '') $errors[] = "Category is required.";
if (!is_numeric($price) || $price < 0) $errors[] = "Price must be numeric >= 0.";
if (!is_numeric($stock) || (int)$stock < 0) $errors[] = "Stock must be integer >= 0.";
$allowedStatuses = ['active','inactive'];
if (!in_array($status, $allowedStatuses)) $errors[] = "Invalid status.";

$image_path = $existing['image_path']; // keep old by default
if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['image'];
    if ($f['error'] !== UPLOAD_ERR_OK) $errors[] = "Upload error.";
    else {
        if ($f['size'] > $uploadCfg['max_size']) $errors[] = "File too large.";
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($f['tmp_name']);
        if (!in_array($mime, $uploadCfg['allowed_mime'])) $errors[] = "Invalid file type.";
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $uploadCfg['allowed_ext'])) $errors[] = "Invalid file extension.";

        if (empty($errors)) {
            if (!is_dir($uploadCfg['dir'])) mkdir($uploadCfg['dir'], 0755, true);
            $newName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = $uploadCfg['dir'] . '/' . $newName;
            if (!move_uploaded_file($f['tmp_name'], $dest)) {
                $errors[] = "Failed to move uploaded file.";
            } else {
                // remove old file if exists
                if ($existing['image_path']) {
                    $old = __DIR__ . '/' . basename($existing['image_path']);
                    $oldFull = $uploadCfg['dir'] . '/' . basename($existing['image_path']);
                    if (file_exists($oldFull)) @unlink($oldFull);
                }
                $image_path = 'uploads/' . $newName;
            }
        }
    }
}

if (!empty($errors)) {
    echo "<h3>Errors:</h3><ul>";
    foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>";
    echo "</ul><p><a href='edit.php?id={$id}'>Back</a></p>";
    exit;
}

// update
$product = new Product([
    'name' => $name,
    'category' => $category,
    'price' => $price,
    'stock' => (int)$stock,
    'image_path' => $image_path,
    'status' => $status
]);

$repo->update($id, $product);
header("Location: index.php");
exit;
