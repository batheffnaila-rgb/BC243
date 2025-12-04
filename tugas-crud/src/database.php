<?php
class Database {
    private static $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            $cfg = include __DIR__ . '/Config.php';
            $db = $cfg['db'];

            $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            self::$pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
        }

        return self::$pdo;
    }

    public static function query($sql, $params = []) {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
