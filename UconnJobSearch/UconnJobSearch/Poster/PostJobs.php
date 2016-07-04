<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<body>
<?php

require "./../includes/DatabaseConnector.php";

class PostJobs{
	
	public function PostJobs($jobInfo){
		if (!$this->validate($jobInfo)){
			header('Location: '. $_SERVER['HTTP_REFERER']);
		}else{
			$this->insertInDatabase($jobInfo); 
			$this->insertPayment($jobInfo);
			$this->insertPostPay($jobInfo);
			echo("You have successfully entered this job into the database...Redirecting");
			header("refresh:5; url=/UconnJobSearch/Poster/PosterJobs.php");
		} 
	}
	
	public function insertInDatabase($jobInfo){
		$jobID = $jobInfo['jobID'];
		$cname = $jobInfo['cname'];
		$jlistdate = $jobInfo['jlistdate'];
		$jtitle = $jobInfo['jtitle'];
		$jcity = $jobInfo['jcity'];
		$jzip = $jobInfo['jzip'];
		$jduties = $jobInfo['jduties'];
		$jyrsexperience = $jobInfo['jyrsexperience'];
		$jlowrange = $jobInfo['jlowrange'];
		$jhighrange = $jobInfo['jhighrange'];
		$jfillstatus = $jobInfo['jfillstatus'];
		$jda = $jobInfo['darea'];
		$jdt = $jobInfo['dtype'];
		
		$query = "INSERT INTO job 
				(JobID, CName, JListDate, JTitle, JCity, JZip, JDuties, JYRSExperience, JLowRange, JHighRange, JFillStatus) 
				VALUES ('$jobID', '$cname', '$jlistdate', '$jtitle', '$jcity', '$jzip', '$jduties', '$jyrsexperience', '$jlowrange', '$jhighrange', '$jfillstatus')";
		$database = new DatabaseConnector();
		$database->connect();
		$database->query($query);
		
		$query1 = "INSERT INTO jdegreeareas (JobID, DegreeArea) VALUES ('$jobID', '$jda')";
		$database->query($query1);

	
		$query2 = "INSERT INTO jdegreetypes (JobID, DegreeType) VALUES ('$jobID', '$jdt')";
		$database->query($query2);
		$database->closeCon();
}
	
	public function insertPayment($jobInfo){
		$username = $_SESSION['username'];
		$jobID = $jobInfo['jobID'];
		$paymentmethod = $jobInfo['payment'];
		$jlistdate = $jobInfo['jlistdate'];
		$query = "INSERT into payment
				(PAmount, PDate, PStatus)
				VALUES ('100', '$jlistdate', 'Incomplete')";				
				
		$database = new DatabaseConnector();	
		$database->connect();
		$database->query($query);
		$database->closeCon();
	}
	
	public function insertPostPay($jobInfo){
		$username = $jobInfo['username'];
		$jobID = $jobInfo['jobID'];
		$query = "INSERT into postpay
				(JobID, UName)
				VALUES ('$jobID', '$username')";				
				
		$database = new DatabaseConnector();	
		$database->connect();
		$database->query($query);
		$database->closeCon();
	}	
	
	
	private function validate($jobInfo){
		$database = new DatabaseConnector();
		$database->connect();
		$errMsg = "";
		$errCnt = 0;
		//validate JOB-ID
		if(empty($jobInfo['jobID'])){
			$errMsg .= "You haven't entered a Job ID!\\n";
			$errCnt++;
		} elseif (!ctype_digit($jobInfo['jobID'])) {
			$errMsg .= "Invalid JobID format! Numeric characters only, please.\\n";
			$errCnt++;
		} else {
			$query = "SELECT * FROM Job";
			$jobs = $database->query($query);
			foreach($jobs as $job){
				if ($job['JobID'] == $jobInfo['jobID']){
					$errMsg .= "This job has already been posted!\\n";
					$errCnt++;
				}
			}
		}

		//validate company name
		if(empty($jobInfo['cname'])){
			$errMsg .= "Missing company name!\\n";
			$errCnt++;
		}

		//validate list date
		if(empty($jobInfo['jlistdate'])){
			$errMsg .= "Missing post date for Job!\\n";
			$errCnt++;
		}
		//Job title
		if(empty($jobInfo['jtitle'])){
			$errMsg .= "Missing job title!\\n";
			$errCnt++;
		}
		//job city
		if(empty($jobInfo['jcity'])){
			$errMsg .= "Missing city for this job!\\n";
			$errCnt++;
		}
		//job zip
		if(empty($jobInfo['jzip'])){
			$errMsg .= "Missing zip-code for job!\\n";
			$errCnt++;
		} elseif (!ctype_digit($jobInfo['jzip'])){
			$errMsg .= "Please only use digits for the zip-code";
			$errCnt++;
		}
		//job duties
		if(empty($jobInfo['jduties'])){
			$errMsg .= "Please list the duties for this job\\n";
			$errCnt++;
		}
		
		//job years experience
		if(empty($jobInfo['jyrsexperience'])){
			$errMsg .= "Please list the years experience required\\n";
			$errCnt++;
		}
		
		//Salary low range
		if(empty($jobInfo['jlowrange'])){
			$errMsg .= "Please list the low range for this job\\n";
			$errCnt++;
		} elseif (!ctype_digit($jobInfo['jlowrange'])){
			$errMsg .= "Please only use digits for the low-end of the salary range";
			$errCnt++;
		}
		
		//Salary high range
		if(empty($jobInfo['jhighrange'])){
			$errMsg .= "Please list the high range for this job!\\n";
			$errCnt++;
		} elseif (!ctype_digit($jobInfo['jhighrange'])){
			$errMsg .= "Please only use digits for the high-end of the salary range!";
			$errCnt++;
		}
		
		//job filled status
		if(empty($jobInfo['jfillstatus'])){
			$errMsg .= "Please list the fill status for the job!\\n";
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
new PostJobs($_POST);
?>
</body>
</html>