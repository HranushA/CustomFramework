<?php 
class UserController{
    public function login(){
        echo "this is Login User";
    }
    public function index(){
        echo "Main page";
    }
    public function aboutUser(){
        echo "this is About User";
    }
    public function __call( $funName, $arguments ){
        require __DIR__ . '/View/404.php';
    }
}