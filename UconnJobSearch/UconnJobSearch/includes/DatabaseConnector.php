<?php

/*
 * OOP Styled class for creating, using, and closing database connections
 * Created by Vijay and Austin
 * [2015-04-24] 
 */
 
class DatabaseConnector{
	
	private $server;
	private $username;
	private $password;
	private $database;
	private $connection;
	
	public function DatabaseConnector(){
		$this->server = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'UCJS';
	}
	public function connect(){
		$this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->database);
		if (mysqli_connect_errno()){
			print("Failed to connect: ".mysqli_connect_error());
		
		}
	}
	
	public function getConn(){
		return $this->connection;
	}
	
	public function closeCon(){
		mysqli_close($this->connection);
	}

	public function query($query){
		$results = mysqli_query($this->connection, $query);
		if (is_object($results)){
		$rows = array();
		if ($results->num_rows > 0){
			while ($row = mysqli_fetch_array($results)){
				$rows[] = $row;
			}
		}
		return $rows;
		}
	}
}

?>