<?php

// need config
require_once("config.php");

class Database 
{
  // localhost db
	private static $dbName = 'igloosof_homecontrol'; 
	//private static $dbHost = 'localhost' ;
	private static $dbHost = 'igloosof-homecontrol-orig.ciw169h7kx6c.ap-southeast-2.rds.amazonaws.com';
	private static $dbUsername = 'igloosof_hmctrl';
	private static $dbUserPassword = 'C!H7=xLZcgOu';
	
  // static connection
	private static $cont  = null;
	
  // constructor
	public function __construct() {
		exit('Init function is not allowed');
	}
	
  // connect
	public static function connect()
	{
		global $ca_path;

		// One connection through whole application
    if ( null == self::$cont )
    {      
    	try 
      {
				// https://stackoverflow.com/questions/9738712/connect-to-remote-mysql-server-with-ssl-from-php
				// If connect to localhost db, no need
				$opt = array(
					PDO::MYSQL_ATTR_SSL_CA => $ca_path
				);

				/*        
        //test
        print_r("here --- ");
        print_r($opt);
        die;
				*/

        // actual connection and assign to self::$cont
        // mysql:host=host;dbname=dbname, username, pass, opt
      	self::$cont = new PDO("mysql:host=". self::$dbHost.";". "dbname=". self::$dbName, self::$dbUsername, self::$dbUserPassword, $opt);  
      }
      catch(PDOException $e) 
      {
      	die($e->getMessage());  
      }
    } 
    return self::$cont;
	}
	
  // disconnect
	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>
