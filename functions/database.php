<?php /** @noinspection ALL */
function getDb(){
    static $db;
    if ($db instanceof PDO){
        return $db;
    }
    require_once __DIR__.'/../config/database.php';
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s',DB_HOST,DB_DATABASE,DB_CHARSET);
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $db = new PDO($dsn, DB_USERNAME, DB_PASSWORD,$options);
    } catch (PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    return $db;
}
