<?php
//error_reporting(0);
/* For time sake i dont take it from .env file but... i could */
define("HOST","127.0.0.1");
define("USERNAME", "root");
define("PASSWORD","");
define("DBNAME","analytics");
class DBConnection {
private $conn = null;

  public static function getDB() {
      $dbConnection = new DBConnection();
      return $dbConnection->connect();
  }
  public function __construct($host = HOST, $username = USERNAME, $password = PASSWORD, $dbName = DBNAME) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->dbName = $dbName;
    if (isset($this->conn)) { 
      return $this->conn;
    }
    else { 
      return $conn = $this->connect($host,$username,$password,$dbName);
    }
  }
  public function connect() {
    $conn = new mysqli($this->host, $this->username,$this->password);
    if ($conn->connect_errno) {
	    return null;
    }
	$this->createDBIfNotExisting($conn);
    return $this->conn;
  }
  private function createDBIfNotExisting($conn) {
	$dbSelected = mysqli_select_db($conn,DBNAME );
	if (!$dbSelected) {
		// If we couldn't, then it either doesn't exist, or we can't see it.
		$sql = 'CREATE DATABASE '.DBNAME.'';
		if (mysqli_query($conn,$sql )) {
			echo "Created the database!";
		}
		else {
			echo 'Error creating database: ' . mysql_error() . "\n";
		}
    }
	$this->conn = new mysqli(HOST,  USERNAME ,PASSWORD, DBNAME);
  }
}