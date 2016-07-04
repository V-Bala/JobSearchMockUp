<?php

/*
 * php file for basic registration, Vijay & Austin
 */

require "./includes/DatabaseConnector.php";

class RegisterUser{
	
	public function RegisterUser($userInfo){
		//print(json_encode($userInfo));
		if (!$this->validate($userInfo)){
			header('Location: '. $_SERVER['HTTP_REFERER']);
		} else{
			$this->insertIntoDatabase($userInfo);
			echo("Success! Redirecting you to login...");
			header("refresh:5; url=index.php");
		} 
	}
	
	private function insertIntoDatabase($userInfo){
		$username = $userInfo['username'];
		$state = $userInfo['state'];
		$password = $userInfo['password'];
		$fname = $userInfo['fname'];
		$lname = $userInfo['lname'];
		$phone = $userInfo['phone'];
		$add = $userInfo['add'];
		$city = $userInfo['city'];
		$zip = $userInfo['zip'];
		$email = $userInfo['email'];
		
		$query = "INSERT INTO user
						(UName, UState, UPasswd, UFName, ULName, UStreet1, UCity, UZip, UEmail, UPhone) 
						VALUES ('$username','$state', '$password','$fname','$lname','$add','$city','$zip','$email', '$phone')";
		$database = new DatabaseConnector();
		$database->connect();
		$database->query($query);
				
		if (!empty($userInfo['type'])){
			if ($userInfo['type'] == "admin"){
				$query = "INSERT INTO administrator (UName) VALUES ('$username')";
				$database->query($query);			
			}	
			if ($userInfo['type']=="seeker"){
				$query = "INSERT INTO seeker (UName) VALUES ('$username')";
				$database->query($query);
			}
			if ($userInfo['type']=="poster"){
				$query = "INSERT INTO poster (UName) VALUES ('$username')";
				$database->query($query);
			}
		}
		$database->closeCon();
	}
	private function validate($userInfo){
		$database = new DatabaseConnector();
		$database->connect();
		//reset validation
		$errMsg = "";
		$errCnt = 0;
		//validate username
		if(empty($userInfo['username'])){
			$errMsg .= "Missing username!\\n";
			$errCnt++;
		} elseif (!ctype_alnum($userInfo['username'])) {
			$errMsg .= "Invalid username format! Alphanumeric characters only, please.\\n";
			$errCnt++;
		} else {
			$query = "SELECT * FROM user";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UName']==$userInfo['username']){
					$errMsg .= "Username already used!\\n";
					$errCnt++;
				}
			}
		}
		//validate password
		if(empty($userInfo['password'])){
			$errMsg .= "Missing password!\\n";
			$errCnt++;
		}
		//validate email
		if(empty($userInfo['email'])){
			$errMsg .= "Missing email!\\n";
			$errCnt++;
		} elseif (!filter_var($userInfo['email'], FILTER_VALIDATE_EMAIL)) {
			$errMsg .= "Invalid email format!\\n";
			$errCnt++;
		} else {
			$query = "SELECT * FROM user";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UEmail']==$userInfo['email']){
					$errMsg .= "Email already used!\\n";
					$errCnt++;
				}
			}
		}
		//validate names
		if(empty($userInfo['fname'])){
			$errMsg .= "Missing first name!\\n";
			$errCnt++;
		}
		if(empty($userInfo['lname'])){
			$errMsg .= "Missing last name!\\n";
			$errCnt++;
		}
		//phone number
		if(empty($userInfo['phone'])){
			$errMsg .= "Missing phone number!\\n";
			$errCnt++;
		} elseif (!ctype_digit($userInfo['phone'])){
			$errMsg .= "Please use digits only for phone number!\\n";
			$errCnt++;
		}
		//address
		if(empty($userInfo['add'])){
			$errMsg .= "Missing address!\\n";
			$errCnt++;
		}
		//city
		if(empty($userInfo['city'])){
			$errMsg .= "Missing city!\\n";
			$errCnt++;
		}
		//zip
		if(empty($userInfo['zip'])){
			$errMsg .= "Missing zip-code!\\n";
			$errCnt++;
		} elseif (!ctype_digit($userInfo['zip'])){
			$errMsg .= "Please only use digits for zip-code";
			$errCnt++;
		}
		//type
		if(empty($userInfo['type'])){
			$errMsg .= "Please select an account type! (Admin/Poster/Seeker)\\n";
			$errCnt++;
		}
		$database->closeCon();
		if($errCnt > 0){
			$_SESSION['errMsg'] = $errMsg;
			return false;
		} else{
			return true;
		}
	}
}
session_start();
new RegisterUser($_POST);

?>