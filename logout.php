<?php
session_start();
$_SESSION["login_status"] = 0;
// unset($_SESSION["login_status"]);
unset($_SESSION["User"]);
header("Location:login_reg.php");
?>