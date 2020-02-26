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
            $db = DB::table("users_table")->where("Username", "User1")->select();
            $result = $db->fetch(PDO::FETCH_ASSOC);
            var_dump( $result ) ;    

            // $get = new DB;
            // $get->get("aaa");
            // var_dump($get);
            include 'View/dashboard.php'; 
    }

    public function login(){
        if( $_SESSION["login_status"] === 0){
            if(isset($_REQUEST["login_submit"]) & $_SERVER['REQUEST_METHOD'] === "POST"){
                $name = $_REQUEST["uname"];
                $password = $_REQUEST["psw"];
                $sth = DB::query("SELECT * FROM users_table WHERE Username = '$name'");
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                $count = $sth->rowCount();
                if( $count == 1 ){
                    if( password_verify( $password, $result["Password"] ) ){
                        $_SESSION["login_status"] = 1;
                        $_SESSION['User'] = $_REQUEST["uname"];
                        $url = $this->server_url();
                        header('location:' . $url);
                    }else{
                        $_SESSION["login_status"] = 0;  
                        header("location:?InvPass=The password you entered is invalid.");
                    }
                }else{
                    header("location:?InvPass=The username or password you entered is invalid.");
                }
            }
            if(isset($_REQUEST["reg_submit"]) & $_SERVER['REQUEST_METHOD'] === "POST"){
                $reg_name = $_REQUEST["reg_name"];
                $reg_pass = $_REQUEST["reg_psw"];
                $sth = DB::query(" SELECT * FROM users_table WHERE Username = '$reg_name' ");
                $reg_num = $sth->rowCount();
                if( $reg_num === 0 ){
                    $hash_pass = password_hash($reg_pass, PASSWORD_DEFAULT);
                    if($reg_name !== '' || $reg_pass !== ''){
                        DB::query(" INSERT INTO users_table( Username, Password ) value( '$reg_name', '$hash_pass') ");
                        $_SESSION["login_status"] = 1;
                        $_SESSION['User'] = $_REQUEST["reg_name"];
                        $url = $this->server_url();
                        header('location:' . $url);
                    }     
                }else{
                    $_SESSION["login_status"] = 0;
                    header("location:?InvUser=Username Already Taken.");
                }
            }  
        }else{
            $url = $this->server_url();
            header( 'location:login' );
        } 
    }

    public function showLogin(){
        include 'loginReg.php';
    }

    public function logout(){
        $_SESSION["login_status"] = 0;  
        unset($_SESSION["User"]);
        $url = $this->server_url();
        header( 'location:login' );
    }

    public function aboutUser(){
        include 'View/about.php'; 
    }

    public function blog(){
        include 'View/blog.php'; 
    }

    public function __call( $funName, $arguments ){
        require __DIR__ . '/View/404.php';
    }

    public function server_url() {
        $server_name = $_SERVER['SERVER_NAME'];
        $protocol = strtolower( substr( $_SERVER["SERVER_PROTOCOL"], 0,5 ) ) == 'https'?'https':'http';
        $url = $protocol . '://' . $server_name . "/";
        return $url;
    }
}