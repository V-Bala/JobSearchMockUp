<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<body>
<?php

require "./../includes/DatabaseConnector.php";

class DeleteJob{
	
	public function DeleteJob($jobInfo){
			$this->removeDB($jobInfo); 
			echo("You have successfully deleted the job...Redirecting");
			header("refresh:5; url=/UconnJobSearch/Poster/PosterJobs.php");
		} 
	
	public function removeDB($jobInfo){
		$jobid = $jobInfo['jobid'];	
		$database = new DatabaseConnector();
		$database->connect();
		$query = "DELETE FROM jdegreetypes WHERE JobID = $jobid";
		$database->query($query);
		$query = "DELETE FROM jdegreeareas WHERE JobID = $jobid";
		$database->query($query);
		$query = "DELETE FROM requiresskill WHERE JobID = $jobid";
		$database->query($query);
		$query = "DELETE FROM jobapp WHERE JobID=$jobid";
		$database->query($query);
		$query = "DELETE FROM job WHERE JobID =$jobid";
		$database->query($query);
		$query1 = "DELETE FROM postpay WHERE JobID =$jobid";
		$database->query($query1);
		$database->closeCon();
	}
	
			}
session_start();
new DeleteJob($_POST);
?>
</body>
</html>
		