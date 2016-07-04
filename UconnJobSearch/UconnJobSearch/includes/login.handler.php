<?php

/*
 * handles logging in of user, and redirecting of users who are not
 * Austin - [2015-04-26]
 */
require(dirname((__FILE__)) . "/DatabaseConnector.php");
	
function login(){
	$database = new DatabaseConnector();
	$database->connect();
	
	if(isLoggedIn()){
		echo "<script>alert('You are already logged in!')</script>";
		redirect();	
	}
	
	if(isset($_POST['submit'])){
		if(!empty($_POST['username'])){
			$username = $_POST['username'];
			$password = $_POST['pass'];
			$query = "SELECT * FROM user 
					  WHERE UName='$username' AND UPasswd='$password' LIMIT 1";
			if(!empty($database->query($query))){
			   $_SESSION['username'] = $_POST['username'];
			   $_SESSION['usertype'] = getUserType();
			   echo $username . " + " . $_SESSION['usertype'];
			   redirect();	
			}  else {
				echo "<script>alert('Invalid username and/or password!')</script>";
			}
		} else {
			echo "<script>alert('Please fill out form correctly')</script>";
		}
	}
	$database->closeCon();
}
		
function redirect(){
	// redirect me to my user page type
		if(!isLoggedIn()){
			echo "<script>alert('You are not logged in!')</script>";
			header('Location : index.php');
		} elseif($_SESSION['usertype'] == 'admin'){
			//admin page here
			header("refresh:0; url=/UconnJobSearch/Admin/AdminMainPage.php");			
		} elseif($_SESSION['usertype'] == 'poster'){
			//poster page here
			header("refresh:0; url=/UconnJobSearch/Poster/PosterJobs.php");			
			
		} elseif($_SESSION['usertype'] == 'seeker'){
			//seeker page here
			header("refresh:0; url=/UconnJobSearch/Seeker/seeker-jobs.php");
		}
}

function getUserType(){
	$database = new DatabaseConnector();
	$database->connect();
	$username = $_POST['username'];
	$query = "SELECT 1 FROM administrator WHERE UName='$username'";
	if(!empty($database->query($query))){
		$database->closeCon();
		return "admin";
	}
	$query = "SELECT 1 FROM seeker WHERE UName='$username'";
	if(!empty($database->query($query))){
		$database->closeCon();
		return "seeker";
	}
	$database->closeCon();
	return "poster";
}
	
function isLoggedIn(){
	if(!empty($_SESSION['username']) && !empty($_SESSION['usertype'])){
		return true;
	}
	return false;
}

function validLogin($page_type){
	if(isLoggedIn()){
		if($page_type != $_SESSION['usertype']){
			echo "<script>alert('Wrong usertype for this content! \\nClick for redirect')</script>";
			redirect();
			return false;
		} else {
			return true;
		}
	}	
	echo "<script>alert('You are not logged in!')</script>";
	header("refresh:0; url=/UconnJobSearch/index.php");
	return false;
}

?>
