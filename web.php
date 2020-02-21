<!DOCTYPE HTML>
<html>  
<body>
<?php 
spl_autoload_register(function ($classname) {
    $hot_key = "/";
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $hot_key = "\\";
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
Route::get('/logout', 'UserController@logout');
Route::get('/about', 'UserController@aboutUser');

Route::go($_SERVER['REQUEST_URI']);

?>

</body>
</html>
