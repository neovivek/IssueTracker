<?php

class ConnectionManager{
	private $database;
	private $username;
	private $password;
	private $pdo;
	private $sth;
	static protected $connection;
	
	function __construct($username = "root", $password = "", $database = ""){
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
	}
	function __destruct(){
		$this->closeConnection();
	}
	final public function createConnection(){
		$dsn = "mysql:host=localhost;dbname=".$this->database;
		try {
			ConnectionManager::$connection = new PDO($dsn, $this->username, $this->password);
		}catch (PDOException $e){
			die("Connection exception" . $e->getMessage());
		}
		return ConnectionManager::$connection;
	}
	final public function closeConnection(){
		$this->sth = null;
		ConnectionManager::$connection = null;
	}
	public function getConnection(){
		return ConnectionManager::$connection;
	}
	public function getDatabase(){
		return $this->database;
	}
	public function getStateHandle(){
		return $this->sth;
	}
	public function selectDatabase($database){
		try {
			$this->database = $database;
			$this->createConnection();
			return $this->database;
		}catch (PDOException $e){
			echo "Database Changing failed : ". $e->getMessage();
		}
	}
	public function executeQuery($query, $arguments = array()){
		try {
			ConnectionManager::$connection->beginTransaction();
			$this->sth = ConnectionManager::$connection->prepare($query);
			$this->sth->execute($arguments) or die( var_dump($this->sth->errorInfo()) );
			try {
				ConnectionManager::$connection->commit();
			}catch (PDOException $e){
				ConnectionManager::$connection->rollBack();
				echo "Query cannot be executed";
			}
			return $this->sth;
		}catch (PDOException $e){
			echo "Execution failed : ". $e->getMessage();
		}
	}
	public function createDatabase($db){
		$query = "CREATE DATABASE IF NOT EXISTS $db";
		$this->executeQuery($query);
		$this->selectDatabase($db);
		$this->sth = null;
	}
}

?>