<?php
require_once "DBConnect.php";

class MySQLConnect extends DBConnect {

    private $db;
    // private $dbconfig;

    public function __construct(){
		// $dbconfig = require 'dbconfig.php';
	}

    public function connect($host, $port, $database, $username, $password){
        try {
            $this->db = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database, $username, $password);
            echo "Database connection established<br><br>";
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query($sql, $params = []){
        $stmt = $this->db->prepare($sql);
        if ( !empty($params) ) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->execute();

        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
    }
}

?>