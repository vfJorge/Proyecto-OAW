<?php
    
class Database
{

  private static $db_host = '127.0.0.1';
  private static $db_user = 'root';
  private static $db_password = '';
  private static $db_name = 'elbuenrss';

  private static $instances = [];

  protected function __construct(){
  }

  protected function __clone(){
  }

  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize a singleton.");
  }
 
  public static function getInstance(): Database
  {
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
      self::$instances[$cls] = new static();
    }
    return self::$instances[$cls];
  }

  public function getConnection()
  {
    $connection = mysqli_connect(self::$db_host, self::$db_user, self::$db_password, self::$db_name);

    if (!$connection) {
      echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
      echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
      echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }
    return $connection;
  }


}
?>