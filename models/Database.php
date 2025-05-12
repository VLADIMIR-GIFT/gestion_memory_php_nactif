<?php
class Database {
    private static $connection = null;

    public static function getConnection() {
        if (!self::$connection) {
            try {
                self::$connection = new PDO(
                    'mysql:host=localhost;dbname=memory',
                    'root',
                    ''
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>