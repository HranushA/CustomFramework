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
            include 'View/dashboard.php'; 
    }

    public function login(){
        if( $_SESSION["login_status"] === 0){
            if(isset($_REQUEST["login_submit"]) & $_SERVER['REQUEST_METHOD'] === "POST"){
                $name = $_REQUEST["uname"];
                $password = $_REQUEST["psw"];
                $sth = DB::table("users_table")->where( "Username", $name)->get();
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
                $sth = DB::table("users_table")->where( "Username", $reg_name)->get();
                $reg_num = $sth->rowCount();
                if( $reg_num === 0 ){
                    $hash_pass = password_hash($reg_pass, PASSWORD_DEFAULT);
                    if($reg_name !== '' || $reg_pass !== ''){
                        $columns = [ "Username", "Password"];
                        $values = [ $reg_name, $hash_pass];
                        $db = DB::table("users_table")->insert( $columns, $values);
                        $result = $db->fetch(PDO::FETCH_ASSOC);
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

    public function getTasks(){
        ob_clean();
        $task_status = Task::get_status();
        $set =  "Status='".$task_status["to_do_status"]."'"; 
        $where = "Status='open'"; 
        $db = DB::table("tasks")->update( $set, $where );
        $set =  "Status='".$task_status["doing_status"]."'"; 
        $where = "Status='current'"; 
        $db = DB::table("tasks")->update( $set, $where );
        $set =  "Status='".$task_status["done_status"]."'"; 
        $where = "Status='close'"; 
        $db = DB::table("tasks")->update( $set, $where );

        $sth = DB::table("tasks")->where( "Status", "open")->get();
        $open = $sth->fetchAll(PDO::FETCH_ASSOC);

        $sth = DB::table("tasks")->where( "Status", $task_status["to_do_status"])->get();
        $openResult = $sth->fetchAll(PDO::FETCH_ASSOC);

        $sth_1 = DB::table("tasks")->where( "Status",  $task_status["doing_status"])->get();
        $carrentResult = $sth_1->fetchAll(PDO::FETCH_ASSOC);

        $sth_2 = DB::table("tasks")->where( "Status",  $task_status["done_status"])->get();
        $closeResult = $sth_2->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(
            [
                "openResult"=> $openResult,
                "carrentResult"=> $carrentResult,
                "closeResult"=> $closeResult,
            ]
        );
        die;
    }

    public function addTask(){
        ob_clean();
        $task_status = Task::get_status();
        $data_request = json_decode(file_get_contents('php://input'), true);
        $params = $data_request["params"];

        $columns = ["Title", "Content", "Status"];
        $values = [$params["Title"], $params["Content"], $task_status["to_do_status"]];
        $db = DB::table("tasks")->insert( $columns, $values);

        echo json_encode(
            [
                "status"=> "ok"
            ]
        );  
        die;
    }

    public function removeTask(){
        ob_clean();
        $data_request = json_decode(file_get_contents('php://input'), true);
        $params = $data_request["params"];
        $where = "Id = " . $params["Id"];
        $db = DB::table("tasks")->delete( $where );
        echo json_encode(
            [
                "status"=> "ok"
            ]
        );  
        die;
    }

    public function changeStatus(){
        ob_clean();
        $data_request = json_decode(file_get_contents('php://input'), true);
        $params = $data_request["params"];
        $task_status = Task::get_status();
        $status = $task_status["to_do_status"];
        if( $params["Status"] === "Doing" ){
            $status = $task_status["doing_status"];
        }elseif( $params["Status"] === "Done" ){
            $status = $task_status["done_status"];
        }
        $set = "Status='" . $status . "'";
        $where = "Id = " . $params["Id"];
        $db = DB::table("tasks")->update( $set, $where );
        echo json_encode(
            [
                "status"=> "ok",
            ]
        );  
        die;
    }
}

?>