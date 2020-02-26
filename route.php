<?php 
if(!isset($_SESSION)) { 
  session_start(); 
} 

class Route {
  private static $instance;
  private static $route_list = [];
  private static $post_method = [];
  
  public function __construct() {
      try { } catch (PDOException $e) {
         die($e->getMessage());
      }
  }

  public static function get($route, $file) {
    if( $_SERVER['REQUEST_METHOD'] === "GET" ){
      if($route !== ""){
        self::$route_list[$route] = $file;
      } 
        if( !isset(self::$instance) ) {
          $request = $_SERVER['REQUEST_URI'];
          $new_route = $request . "/";
          if(preg_match($new_route, $route)){ 
            self::$instance = new Route();
          } 
        }
        return self::$instance;
    }
  }

  public static function post($route, $file) {
    if( $_SERVER['REQUEST_METHOD'] === "POST" ){
      if($route !== ""){
        self::$post_method[$route] = $file;
      } 
      if( !isset(self::$instance) ) { 
        $request = $_SERVER['REQUEST_URI'];
        $new_route = $request . "/";
        if(preg_match($new_route, $route)){
          self::$instance = new Route();
        } 
      }
      return self::$instance;
    }
  } 

  public static function go($url) {
    if($_SERVER['REQUEST_METHOD'] === "POST"){
      if (array_key_exists($url, self::$post_method)){
        $action = explode("@", self::$post_method[$url]);
      }  
    }
    if($_SERVER['REQUEST_METHOD'] === "GET"){
      if( $_SESSION["login_status"] === 1 ){
        if( $url !== "/login"){
          $action = ["Route", "not_found_page"];
          if (array_key_exists($url, self::$route_list)){
            $action = explode("@", self::$route_list[$url]);
          } 
        }else{
          $action = ["Route", "not_found_page"];
        }
      }else{
        $action = ["UserController", "showLogin"];
      }
    }
    $controller_name = $action[0];
    $method = $action[1];
    $controller = new $controller_name;
    call_user_func(array( $controller, $method ));
  }

  public function not_found_page() {
    require __DIR__ . '/View/404.php';
  }

}

?>