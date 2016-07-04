<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<body>
<?php

require "./../includes/DatabaseConnector.php";

class SetCompanyName{
	
	public function SetCompanyName($Info){
			$cname = $Info['cname'];
			$this->insertDB($Info); 
			echo("You have successfully updated your company...Redirecting");
			header("refresh:5; url=/UconnJobSearch/Poster/PosterJobs.php");
		} 
	
	public function insertDB($Info){
		$cname = $Info['cname'];
		$username = $Info['username'];
		echo($cname);
		$database = new DatabaseConnector();
		$database->connect();
		$query = "UPDATE poster SET CName = '$cname' WHERE UName='$username'";
		$database->query($query);
		$database->closeCon();	
	}
}

session_start();
new SetCompanyName($_POST);
?>
</body>
</html>
		
