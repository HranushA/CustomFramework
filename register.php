<?php
include 'connection.php';
session_start();
  
$conn = OpenCon();

    $name = $_POST["uname"];
    $password = $_POST["psw"];

    $query = " SELECT * FROM users_table WHERE Username = '$name'";
    $result = mysqli_query( $conn, $query );
    $num = mysqli_num_rows( $result );

    if( $num === 0 ){
        $pass = password_hash($password, PASSWORD_DEFAULT);
        
        if($name !== '' || $pass !== ''){
            $reg = "INSERT INTO users_table( Username, Password) value( '$name', '$pass')";
            mysqli_query( $conn, $reg );
            echo "Registration Successful";
        }     
    }else{
        echo "Username Already Taken";
    }

CloseCon($conn);
?>
                
        