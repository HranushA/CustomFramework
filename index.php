<?php if(!isset($_SESSION)) { 
    session_start(); 
} ?>
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

if(!isset($_SESSION["login_status"])){
    $_SESSION["login_status"] = 0;
}

Route::get('/', 'UserController@index');
Route::get('/login', 'UserController@showLogin');
Route::get('/logout', 'UserController@logout');
Route::get('/about', 'UserController@aboutUser');
Route::get('/blog', 'UserController@blog');
Route::post('/login', 'UserController@login');
Route::post('/getTasks', 'UserController@getTasks');
Route::post('/addTask', 'UserController@addTask');
Route::post('/doingTask', 'UserController@doingTask');
Route::post('/doneTask', 'UserController@doneTask');
Route::post('/removeTask', 'UserController@removeTask');
Route::post('/changeStatus', 'UserController@changeStatus');

Route::go($_SERVER['REQUEST_URI']);

?>

</body>
</html>
