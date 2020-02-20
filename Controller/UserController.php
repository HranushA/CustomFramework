<?php 
if(!isset($_SESSION)) { 
    session_start(); 
} 
class UserController{
    public function login(){
        if(isset($_SESSION['User']))
        {
            echo ' Wellcome ' . $_SESSION['User'].'<br/>';
            echo '<a href="logout">Logout</a>';
        } else{
            $server_name = $_SERVER['SERVER_NAME'];
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
            $url = $protocol.'://'.$server_name."/";
            header('location:' . $url);
        }
    }
    public function logout() {
        $_SESSION["login_status"] = 0;  
        unset($_SESSION["User"]);
        $server_name = $_SERVER['SERVER_NAME'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        $url = $protocol.'://'.$server_name."/";
        header('location:' . $url);
    }
    public function index(){
        echo "Main page";
    }
    public function aboutUser(){
        echo "About Users page";
    }
    public function __call( $funName, $arguments ){
        require __DIR__ . '/View/404.php';
    }
}