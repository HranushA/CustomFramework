<?php if(!isset($_SESSION)) { 
    session_start(); 
} ?>
<!DOCTYPE HTML>
<html>  
    <body>
        <?php 
            if( $_SESSION["login_status"] == 0 ){
                include 'login_reg.php';    
            }else{
                include 'web.php';
            }
        ?>  
    </body>
</html>