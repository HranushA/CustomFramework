<?php

class Autoload{

    private $autoloadable = [];

    public function __construct(){
        try {
          echo "bbb"; 
        } catch (PDOException $e) {
           die($e->getMessage());
        }
    }

    public function load(){
        echo "aaa";
        // $name = strtolower($name);
        // $filepath = BASEPATH.'/core/'.$name.'/'.$name.'.php';
        // if( !empty($this->autoloadable[$name]) ){
        //     return $this->autoloadable[$name]($name);
        // }
        // if( file_exists($filepath) ){
        //     return require($filepath);
        // }
        // throw new Exception($name.' is not loaded or registred for autoloading');
    }
}