<?php 
if(!isset($_SESSION)) { 
    session_start(); 
} 
?>
<!DOCTYPE HTML>
<html>  
    <head>
        <?php include 'connection.php'; ?>
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script  type="text/javascript"  src="js/general.js"></script>
    </head>
    <body class="login-page-bg">
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-box">
                                <h4>Login</h4>
                                <?php if(@$_GET['InvPass']==true){ ?>
                                    <div class="error-msg"><?php echo $_GET['InvPass'] ?></div>                                
                                <?php } ?>
                                <form method="post">
                                    <div class="form-block"> 
                                        <div class="form-row">
                                            <label for="uname"><b>Username</b></label>
                                            <input type="text" placeholder="Username" name="uname" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Password</b></label>
                                            <input type="password" placeholder="Password" name="psw" required>
                                        </div>
                                        <div class="button-row">
                                            <button name="login_submit" type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                        <div class="col-6">
                            <div class="form-box">
                                <h4>Sign Up</h4>
                                <?php if(@$_GET['InvUser']==true){ ?>
                                    <div class="error-msg"><?php echo $_GET['InvUser'] ?></div>                                
                                <?php } ?>
                                <form method="post">
                                    <div class="form-block"> 
                                        <div class="form-row">
                                            <label for="uname"><b>Username</b></label>
                                            <input type="text" placeholder="Username" name="reg_name" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Password</b></label>
                                            <input type="password" id="password" placeholder="Password" name="reg_psw" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Confirm Password</b></label>
                                            <input type="password" id="confirm_password" placeholder="Confirm Password" name="conf_psw" onchange="check_pass();">
                                        </div>
                                        <div class="button-row">
                                            <button name="reg_submit" id="submit" type="submit">Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </body>
</html>

<?php
$_SESSION["login_status"] = 0;
$conn = OpenCon();   

    if(isset($_POST["login_submit"])){
        $name = $_POST["uname"];
        $password = $_POST["psw"];
        $query_pass = " select * from users_table where Username = '$name' ";
        $result_pass = mysqli_query( $conn, $query_pass );
        $num = mysqli_num_rows( $result_pass ); 
        if( $num === 1 ){
            $row = mysqli_fetch_row( $result_pass );
        }
        if( password_verify( $password, $row[1] ) ){
            $_SESSION["login_status"] = 1;
            $_SESSION['User'] = $_POST["uname"];
            header("location:dashboard");
        }else{
            $_SESSION["login_status"] = 0;  
            header("location:?InvPass=The password you entered is invalid.");
        }
    }

    if(isset($_POST["reg_submit"])){
        $reg_name = $_POST["reg_name"];
        $reg_pass = $_POST["reg_psw"];
        $reg_query = " SELECT * FROM users_table WHERE Username = '$reg_name'";
        $reg_result = mysqli_query( $conn, $reg_query );
        $reg_num = mysqli_num_rows( $reg_result );

        if( $reg_num === 0 ){
            $hash_pass = password_hash($reg_pass, PASSWORD_DEFAULT);
            if($reg_name !== '' || $reg_pass !== ''){
                $reg = "INSERT INTO users_table( Username, Password) value( '$reg_name', '$hash_pass')";
                mysqli_query( $conn, $reg );
                header("location:dashboard");
                $_SESSION["login_status"] = 1;
                $_SESSION['User'] = $_POST["reg_name"];
            }     
        }else{
            $_SESSION["login_status"] = 0;
            header("location:?InvUser=Username Already Taken.");
        }
    }

CloseCon($conn);
?> 