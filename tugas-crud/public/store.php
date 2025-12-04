<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$config = include __DIR__ . '/../src/Config.php';
$uploadCfg = $config['upload'];

$errors = [];

// input validation
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

$image_path = null;
if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['image'];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Upload error.";
    } else {
        if ($f['size'] > $uploadCfg['max_size']) {
            $errors[] = "File too large. Max 2MB.";
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($f['tmp_name']);
        if (!in_array($mime, $uploadCfg['allowed_mime'])) {
            $errors[] = "Invalid file type. Only JPG/PNG allowed.";
        }
        // determine ext
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext);
        if (!in_array($ext, $uploadCfg['allowed_ext'])) {
            $errors[] = "Invalid file extension.";
        }
        if (empty($errors)) {
            if (!is_dir($uploadCfg['dir'])) {
                mkdir($uploadCfg['dir'], 0755, true);
            }
            $newName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = $uploadCfg['dir'] . '/' . $newName;
            if (!move_uploaded_file($f['tmp_name'], $dest)) {
                $errors[] = "Failed to move uploaded file.";
            } else {
                $image_path = 'uploads/' . $newName; // store relative to public
            }
        }
    }
}

if (!empty($errors)) {
    echo "<h3>Errors:</h3><ul>";
    foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>";
    echo "</ul><p><a href='create.php'>Back</a></p>";
    exit;
}

// ✅ RESET AUTO INCREMENT JIKA TABEL KOSONG (VERSI AMAN)
require_once __DIR__ . '/../src/Database.php';

$db = new Database();

$check = $db->query("SELECT COUNT(*) as total FROM products")->fetch(PDO::FETCH_ASSOC);

if ($check['total'] == 0) {
    $db->query("ALTER TABLE products AUTO_INCREMENT = 1");
}

require_once __DIR__ . '/../src/Database.php';

$dbObj = new Database();
$conn = $dbObj->getConnection(); // ambil koneksi PDO

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM products");
$stmt->execute();
$check = $stmt->fetch(PDO::FETCH_ASSOC);

if ($check['total'] == 0) {
    $conn->exec("ALTER TABLE products AUTO_INCREMENT = 1");
}

// create product
$product = new Product([
    'name' => $name,
    'category' => $category,
    'price' => $price,
    'stock' => (int)$stock,
    'image_path' => $image_path,
    'status' => $status
]);

$repo = new ProductRepository();
$id = $repo->create($product);
header("Location: index.php");
exit;
