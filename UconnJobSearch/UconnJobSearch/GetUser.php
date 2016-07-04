<?php
 
 include_once "./includes/DatabaseConnector.php";

	class GetUser{
		public function GetUser($username){
			$query = "SELECT * FROM User WHERE UName ='$username'";  
			$database = new DatabaseConnector();
			$database->connect();
			print(json_encode($database->query($query)));
		}
	}
	new GetUser($_GET['username']);
?>