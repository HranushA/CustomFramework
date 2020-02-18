<!DOCTYPE HTML>
<html>  
<body>
<?php 

// include 'route.php';
spl_autoload_register(function ($classname) {
    $hot_key = "";
    switch (PHP_OS) {
    case "WINNT":
        $hot_key = "/";
        break;
    default;
        $hot_key = "/";
        break;
    }

    if(strpos($classname, "Controller") !== false){
        $filename = 'Controller' . $hot_key . $classname  .".php";
        include_once($filename);
    }else{
        $filename = $classname .".php";
        include_once($filename);
    }
});

Route::get('/', 'UserController@index');
Route::get('/login', 'UserController@login');
Route::get('/about', 'UserController@aboutUser');

Route::go($_SERVER['REQUEST_URI']);

?>

</body>
</html>
