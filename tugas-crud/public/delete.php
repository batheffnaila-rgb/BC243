<?php
require_once __DIR__ . '/../src/ProductRepository.php';
$config = include __DIR__ . '/../src/Config.php';
$uploadCfg = $config['upload'];

$repo = new ProductRepository();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$existing = $repo->find($id);
if (!$existing) {
    echo "Not found. <a href='index.php'>Back</a>"; exit;
}

// optionally delete file
if ($existing['image_path']) {
    $file = $uploadCfg['dir'] . '/' . basename($existing['image_path']);
    if (file_exists($file)) @unlink($file);
}

$repo->delete($id);
header("Location: index.php");
exit;
