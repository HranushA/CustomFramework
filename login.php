<?php
include 'connection.php';
include 'web.php';
session_start();
  
$conn = OpenCon();

    $name = $_POST["uname"];
    $password = $_POST["psw"];
    $pass = md5( $password );
 
    $query = " select * from users_table where Username = '$name' && Password = '$pass'";
    $result = mysqli_query( $conn, $query );
    $num = mysqli_num_rows( $result );
    $_SESSION["Username"] = $_POST["uname"];
    if( $num === 1 ){
        header("location:login");
    }else{
        header("location:");
    }   

CloseCon($conn);
?>
                
        