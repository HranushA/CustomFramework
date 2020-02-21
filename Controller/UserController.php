<?php 
if(!isset($_SESSION)) { 
    session_start(); 
} 
spl_autoload_register(function ($classname) {
    $filename = $classname .".php";
    include_once($filename);   
});
class UserController{

    public function index(){
        if(isset($_SESSION['User'])) {
            include 'View/dashboard.php'; 
        } else{
            header('location:login');
        } 
    }

    public function login(){
        if( $_SESSION["login_status"] == 0 ){
            include 'loginReg.php'; 
            if(isset($_POST["login_submit"])){
                $name = $_POST["uname"];
                $password = $_POST["psw"];
                $sth = DB::query("SELECT * FROM users_table WHERE Username = '$name'");
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                $count = $sth->rowCount();
                if( $count == 1 ){
                    if( password_verify( $password, $result["Password"] ) ){
                        $_SESSION["login_status"] = 1;
                        $_SESSION['User'] = $_POST["uname"];
                        header("location:login");
                    }else{
                        $_SESSION["login_status"] = 0;  
                        header("location:?InvPass=The password you entered is invalid.");
                    }
                }else{
                    header("location:?InvPass=The username or password you entered is invalid.");
                }
            }
            if(isset($_POST["reg_submit"])){
                $reg_name = $_POST["reg_name"];
                $reg_pass = $_POST["reg_psw"];
                $sth = DB::query(" SELECT * FROM users_table WHERE Username = '$reg_name' ");
                $reg_num = $sth->rowCount();
                if( $reg_num === 0 ){
                    $hash_pass = password_hash($reg_pass, PASSWORD_DEFAULT);
                    if($reg_name !== '' || $reg_pass !== ''){
                        DB::query(" INSERT INTO users_table( Username, Password) value( '$reg_name', '$hash_pass') ");
                        header("location:login");
                        $_SESSION["login_status"] = 1;
                        $_SESSION['User'] = $_POST["reg_name"];
                    }     
                }else{
                    $_SESSION["login_status"] = 0;
                    header("location:?InvUser=Username Already Taken.");
                }
            }
                
        }else{
            $server_name = $_SERVER['SERVER_NAME'];
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
            $url = $protocol.'://'.$server_name."/";
            header('location:' . $url);
        } 
    }

    public function logout(){
        $_SESSION["login_status"] = 0;  
        unset($_SESSION["User"]);
        header('location:login');
    }

    public function aboutUser(){
        include 'View/about.php'; 
    }

    public function __call( $funName, $arguments ){
        require __DIR__ . '/View/404.php';
    }
}