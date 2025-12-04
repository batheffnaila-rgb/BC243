<?php
return [
    'db' => [
        'host' => '127.0.0.1',
        'dbname' => 'tugas_crud',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'upload' => [
        'dir' => __DIR__ . '/../public/uploads',
        'max_size' => 2 * 1024 * 1024, // 2MB
        'allowed_mime' => ['image/jpeg', 'image/png'],
        'allowed_ext' => ['jpg','jpeg','png'],
    ]
];
