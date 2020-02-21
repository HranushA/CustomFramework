<?php
class DB
{
    protected static $instance = null;
    protected static $DB_CONNECTION = 'mysql';
    protected static $DB_HOST = 'localhost';
    protected static $DB_DATABASE = 'custom_mvc_db';
    protected static $DB_USERNAME = 'root';
    protected static $DB_PASSWORD = '1234';

    public static function instance() {
        if (self::$instance === null) {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
                PDO::ATTR_EMULATE_PREPARES   => FALSE,
            );
            $dsn = self::$DB_CONNECTION . ':host=' . self::$DB_HOST . ';dbname=' . self::$DB_DATABASE;
            self::$instance = new PDO($dsn, self::$DB_USERNAME, self::$DB_PASSWORD, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args) {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function query($sql, $args = []) {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
 



   
