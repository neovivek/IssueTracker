<?php

class ConnectionManager{
	private $database;
	private $username;
	private $password;
	private $pdo;
	private $sth;
	protected $connection;
	
	function __construct($username = "root", $password = "", $database = ""){
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
	}
	final public function createConnection(){
		$dsn = "mysql:host=localhost;dbname=".$this->database;
		try {
			$this->connection = new PDO($dsn, $this->username, $this->password);
		}catch (PDOException $e){
			die("Connection exception" . $e->getMessage());
		}
		return $this->connection;
	}
	public function getConnection(){
		return $this->connection;
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
	public function execute($query, $arguments = array()){
		try {
			$this->connection->beginTransaction();
			$this->sth = $this->connection->prepare($query);
			$this->sth->execute($arguments) or die( var_dump($this->sth->errorInfo()) );
			try {
				$this->connection->commit();
			}catch (PDOException $e){
				$this->connection->rollBack();
			}
			return $this->sth;
		}catch (PDOException $e){
			echo "Execution failed : ". $e->getMessage();
		}
	}
	public function createDatabase($db){
		$query = "CREATE DATABASE IF NOT EXISTS $db";
		$this->execute($query);
		$this->selectDatabase($db);
	}
}

?>