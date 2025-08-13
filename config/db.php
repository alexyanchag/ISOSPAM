<?php
// config/db.php
// Ajusta según tus credenciales reales
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_PORT = getenv('DB_PORT') ?: '5432';
$DB_NAME = getenv('DB_NAME') ?: 'isospam';
$DB_USER = getenv('DB_USER') ?: 'postgres';
$DB_PASS = getenv('DB_PASS') ?: 'R34lM4dr1d*+*';
$DB_SEARCH_PATH = getenv('DB_SEARCH_PATH') ?: 'pesca,public'; // ej. 'pesca'

if (!function_exists('db')) {
    function db() {
        global $DB_HOST, $DB_PORT, $DB_NAME, $DB_USER, $DB_PASS, $DB_SEARCH_PATH;
        static $pdo = null;
        if ($pdo === null) {
            $dsn = "pgsql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
            if ($DB_SEARCH_PATH) {
                $pdo->exec(
                    "SET search_path TO " . preg_replace('/[^a-zA-Z0-9_,]/', '', $DB_SEARCH_PATH) . ";"
                );
            }
        }

        return $pdo;
    }
}

return [];
