<?php
class DB{
    protected static $instance;
    protected static $DB_CONNECTION = 'mysql';
    protected static $DB_HOST = 'localhost';
    protected static $DB_DATABASE = 'custom_mvc_db';
    protected static $DB_USERNAME = 'root';
    protected static $DB_PASSWORD = '1234';
    protected static $table_name = '';
    protected static $column_name = '';
    protected static $args = '';
    protected static $selected_columns = '*';
    protected static $sql;
    protected $name;
        public function __construct(){
            try { } catch (PDOException $e) {
                die($e->getMessage());
             }
        }
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
        public static function __callStatic( $method, $args ) {
            return call_user_func_array(array(self::instance(), $method), $args);
        }
        public function __call( $method, $args ) {
            return call_user_func_array(array($this, $method), $args);
        }
        public static function query( $sql, $args = [] ) {
            $stmt = self::instance()->prepare( $sql );
            $stmt->execute( $args );
            return $stmt;
        }
        public static function table( $table_name ) {
            self::$table_name = $table_name;
            return new DB;    
        }
        public function where( $column_name, $args ) {
            self::$column_name = $column_name;
            self::$args = $args;
            return new DB;  
        }
        public function select($columns) {
            if(isset($columns)){
                self::$selected_columns = $columns;
            }
            echo self::$sql;
            // return new DB;  
        }
        public function get(){
            self::$sql = "SELECT" . self::$selected_columns . " FROM " . self::$table_name;
            if( self::$column_name !== "" || self::$args !== "" ){
                self::$sql .= " WHERE ". self::$column_name . "='" . self::$args . "'";
            }
            $stmt = self::instance()->prepare(self::$sql);
            $stmt->execute();
            return $stmt;
        }
        public function insert( $columns, $values ){
            // self::$sql = "INSERT INTO" . self::$DB_DATABASE . "(" . $columns . ") value( " . $values . ")" ;

            self::$sql = 'INSERT INTO ' . self::$table_name . ' (';
            foreach ($columns as $key => $column) {
                self::$sql .=  $column;
                if($key+1 !== count($columns)){
                    self::$sql .=  ', ';
                }
            }
            self::$sql .= ') VALUES (';
            foreach ($values as $key => $value) {
                self::$sql .= '"' . $value . '"';
                if($key+1 !== count($values)){
                    self::$sql .=  ', ';
                }
            }
            self::$sql .= ')';

            $stmt = self::instance()->prepare(self::$sql);
            $stmt->execute();
            return $stmt;
        }

        public function update( $set, $where ){
            // self::$sql = "UPDATE Customers SET Status='close' WHERE Id=1";
            self::$sql = 'UPDATE ' . self::$table_name . ' SET ' . $set . ' WHERE ' . $where;
            $stmt = self::instance()->prepare(self::$sql);
            $stmt->execute();
            return $stmt;
        }

        public function delete( $where ){
            // DELETE FROM table_name WHERE condition;
            self::$sql = 'DELETE FROM ' . self::$table_name . ' WHERE ' . $where;
            $stmt = self::instance()->prepare(self::$sql);
            $stmt->execute();
            return $stmt;
        }
}

   
