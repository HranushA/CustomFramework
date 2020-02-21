<?php 
if(!isset($_SESSION)) { 
  session_start(); 
} 

class Route {
  private static $instance;
  private static $login_route;
  private static $route_list = [];
  
  public function __construct() {
      try { } catch (PDOException $e) {
         die($e->getMessage());
      }
  }

  public static function get($route, $file) {
    if($route !== ""){
      self::$route_list[$route] = $file;
      // self::$login_route = '';
      // $_SESSION["login_status"] = 0; 
    } 
      if( !isset(self::$instance) && $_SESSION["login_status"] != 0  ) {
        self::$login_route = '';
        $request = $_SERVER['REQUEST_URI'];
        $new_route = $request . "/";
        if(preg_match($new_route, $route)){
          self::$instance = new Route();
        } 
      }
      return self::$instance;
  }

  public static function post($route, $file) {
    if($route !== ""){
      // self::$login_route = $file;
      // $_SESSION["login_status"] = 1; 
    } 
      if( !isset(self::$instance) && $_SESSION["login_status"] == 0 ) { 
        self::$login_route = $file;
        $request = $_SERVER['REQUEST_URI'];
        $new_route = $request . "/";
        if(preg_match($new_route, $route)){
          self::$instance = new Route();
        } 
      }
      return self::$instance;
  } 

  public static function go($url) {
      echo self::$login_route;
      
      if( self::$login_route !== '' ){
        $action = ["Route", "not_found_page"];
        if (array_key_exists($url, self::$route_list)){
          $action = explode("@", self::$route_list[$url]);
        }  
      }else{
        $action = ["UserController", "login"];
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