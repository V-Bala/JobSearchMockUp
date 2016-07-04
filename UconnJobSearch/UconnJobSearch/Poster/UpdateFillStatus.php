<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<body>
<?php

require "./../includes/DatabaseConnector.php";

class UpdateFillStatus{
	
	public function UpdateFillStatus($jobInfo){
			$jobid = $jobInfo['jobid'];
			$this->insertDB($jobInfo); 
			echo("You have successfully updated the status...Redirecting");
			header("refresh:5; url=/UconnJobSearch/Poster/PosterJobs.php");
		} 
	
	public function insertDB($jobInfo){
		$jfillstatus = $jobInfo['jfillstatus'];
		$jobid = $jobInfo['jobid'];	
		$database = new DatabaseConnector();
		$database->connect();
		if($jfillstatus == 'Unfilled'){
			$Filled = "Filled";
			$query = "UPDATE job SET JFillStatus = '$Filled' WHERE JobID=$jobid";
			$database->query($query);
		}else{
			$Unfilled = "Unfilled";
			$query = "UPDATE job SET JFillStatus = '$Unfilled' WHERE JobID=$jobid";
			$database->query($query);
		}
		$database->closeCon();
	}
	
			}
session_start();
new UpdateFillStatus($_POST);
?>
</body>
</html>
		