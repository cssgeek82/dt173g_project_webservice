<?php

// Database connection settings 
$onlineMode = false;  // false when run locally, put true before upload

if ($onlineMode) {
    define('DB_HOST', "localhost");    
    define('DB_USER', "cssgeek_portfolio");   
    define('DB_PASSWORD', "");    // PASSWORD REMOVED BEFORE COMMITTING TO GITHUB!!!!!!!!!!!!!
    define('DB_NAME', "cssgeek_portfolio");  
} 
else {    // db-settings when run locally
    define('DB_HOST', "localhost");
    define('DB_USER', "dt173g");  
    define('DB_PASSWORD', "password");  
    define('DB_NAME', "dt173g");     
}

// Class with functions for connecting to and closing connection to database
class Database{
  
    public $db;  

    public function connect() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->db->connect_errno > 0 ? die('Error when connecting to the database[' . $db->connect_error . ']') : null;
        return $this->db; 
      }

    public function close() {
      $this->db->close();
    }
}

