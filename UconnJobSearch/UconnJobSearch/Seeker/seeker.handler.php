<?php

/*
 * Class for handling functonalities unique to seeker role
 * Austin - [2015-04-28]
 */

function updateLogin($userInfo){
		$database = new DatabaseConnector();
		$database->connect();
		//reset validation
		$errMsg = "";
		
		//declare variables
		$username = $userInfo['username']; $oldusername = $userInfo['oldusername'];
		$password = $userInfo['pass'];
		$fname = $userInfo['fname'];
		$lname = $userInfo['lname'];
		$street1 = $userInfo['street1'];
		$street2 = $userInfo['street2'];
		$city = $userInfo['city'];
		$zip = $userInfo['zip'];
		$state = $userInfo['state'];
		$email = $userInfo['email']; $oldemail = $userInfo['oldemail'];
		$phone = $userInfo['phone'];
		$fax = $userInfo['fax'];
		$cell = $userInfo['cell'];
		$www = $userInfo['www'];
		
		//validate username
		if(empty($username)){
			$errMsg .= "Missing username!\\n";
		} elseif (!ctype_alnum($username)) {
			$errMsg .= "Invalid username format! Alphanumeric characters only, please.\\n";
		} else {
			$query = "SELECT * FROM user WHERE UName <> '$oldusername'";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UName']==$username){
					$errMsg .= "Username already used!\\n";
				}
			}
		}
		//validate password
		if(empty($password)){
			$errMsg .= "Missing password!\\n";
		}
		//validate email
		if(empty($email)){
			$errMsg .= "Missing email!\\n";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errMsg .= "Invalid email format!\\n";
		} else {
			$query = "SELECT * FROM user WHERE UEmail <> '$oldemail'";
			$users = $database->query($query);
			foreach($users as $user){
				if ($user['UEmail']==$email){
					$errMsg .= "Email already used!\\n";
				}
			}
		}
		//validate names
		if(empty($fname)){
			$errMsg .= "Missing first name!\\n";
		}
		if(empty($lname)){
			$errMsg .= "Missing last name!\\n";
		}
		//phone number
		if(empty($phone)){
			$errMsg .= "Missing phone number!\\n";
		} elseif (!ctype_digit($userInfo['phone'])){
			$errMsg .= "Please use digits only for phone number!\\n";
		}
		//address
		if(empty($street1)){
			$errMsg .= "Missing address!\\n";
		}
		//city
		if(empty($city)){
			$errMsg .= "Missing city!\\n";
		}
		//zip
		if(empty($zip)){
			$errMsg .= "Missing zip-code!\\n";
		} elseif (!ctype_digit($zip)){
			$errMsg .= "Please only use digits for zip-code\\n";
		}
		if(!empty($fax)){
			if(!ctype_digit($fax)){
			$errMsg .= "Please use digits only for fax number!\\n";
			}
		}
		if(!empty($cell)){
			if(!ctype_digit($cell)){
			$errMsg .= "Please use digits only for cell number!\\n";
			}
		}
		if(!empty($www)){
			if(!filter_var($www, FILTER_VALIDATE_URL)){
				$errMsg .=	"Please format your homepage correctly!\\n";	
			}	
		}
	
		if(empty($errMsg)){
			$_SESSION['username'] = $username;
			$query = "UPDATE user SET UName='$username', UState='$state',
			UPasswd='$password', UFName='$fname', ULName = '$lname', 
			UStreet1='$street1', UStreet2='$street2', UCity='$city',
			UZip='$zip', UEmail='$email', UPhone='$phone', UFax='$fax',
			UCell='$cell', UHomePage = '$www' WHERE UName = '$oldusername'";
			
			$database->query($query);
			
			$query = "UPDATE resume SET RLName = '$lname', RFName = '$fname'
			WHERE UName = '$username'";
			
			$database->query($query);
			
		}

		$database->closeCon();

		return $errMsg;
}

	function getInfo(){
		// return info about a specific job
				$database = new DatabaseConnector();
				$database->connect();
				if(isset($_GET['jobID'])){
					$jobID = $_GET['jobID'];
					$query = "SELECT * FROM job WHERE JobID=$jobID";
					$results = $database->query($query);
					$results = $results[0];
					echo '<p><b>Job Title</b></p> 
						  <p>'.$results['JTitle'].'<p>
						  <p><b>Company Name</b></b>
						  <p>'.$results['CName'].'
						  <p><b>Job List Date</b></p>
						  <p>'.$results['JListDate'].'</p>
						  <p><b>Job City</b></b>
						  <p>'.$results['JCity'].'
						  <p><b>Job Zip</b></p>
						  <p>'.$results['JZip'].'
						  <p><b>Job Salary</b></p>
						  <p>$'.$results['JLowRange'].' - $'.$results['JHighRange'].'
						  <p><b>Job Duties</b></p>
						  <p>'.$results['JDuties'].'
						  <p><b>Fill Status</b></p>
						  <p>'.$results['JFillStatus'].'</p>
						  <p><b>Desired Degree Type(s)</b></p>';
						  
						  $query = "SELECT DegreeType 
						  			FROM jdegreetypes
						  			WHERE JobID=$jobID";
						  $results=$database->query($query);
						  if(!empty($results)){
						  	$results = array_column($results, 'DegreeType');
						  	echo implode(", ", $results);
						  }
						  echo '<p><b>Desired Degree Area(s)</b></p>';
						  $query = "SELECT DegreeArea 
						  			FROM jdegreeareas
						  			WHERE JobID=$jobID";
						  $results=$database->query($query);
						  if(!empty($results)){
						  	$results = array_column($results, 'DegreeArea');
						  	echo implode(", ", $results);
						  }						  
					  	  echo '<p><b>Desired Skill(s)</b></p>';
						  $query = "SELECT SSkillName 
						  			FROM requiresskill
						  			WHERE JobID=$jobID";
						  $results=$database->query($query);
						  if(!empty($results)){
						  	$results = array_column($results, 'SSkillName');
						  	echo implode(", ", $results);
						  }		
					echo '<br /><br /><a style="background-color:#DCDCDC;border:1px solid #000000;" 
						  href="seeker-jobs.php?applyID='.$jobID.'">Apply</a>';
						  										
					unset($_GET['jobID']);
				}
				$database->closeCon();
			}

function apply(){
	//apply to a specific job
	$database = new DatabaseConnector();
	$database->connect();
				if(isset($_GET['applyID'])){
					$applyID = $_GET['applyID'];
					$username = $_SESSION['username'];
					$query = "INSERT INTO jobapp(JobID, UName, DateApplied) 
							  VALUES ('$applyID', '$username', now())";
					
					$database->query($query);
					echo 'You have succesfully applied!';
					unset($_GET['applyID']);
				}
				$database->closeCon();
}

function hasResume(){
	// make sure the user has a resume before they start dabbling!
	$database = new DatabaseConnector();
	$database->connect();
	
	$username = $_SESSION['username'];
	$query = "SELECT *
			  FROM resume
			  WHERE UName ='$username'";
	if(empty($database->query($query))){
		echo "<script>alert('You need to create a resume!')</script>";
		header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");
		$database->closeCon();
		return false;
	}	  
	$database->closeCon();
	return true;
}

function generateDegree($gradT, $gradA){
	$database = new DatabaseConnector();
	$database->connect();
	
	$query = "SELECT *
			  FROM degreetypes";
	$degTypes = $database->query($query);
	echo '<select name="degT">';
	foreach($degTypes as $dT){
		$dType = $dT['DegreeType'];
		echo '<option value="'.$dType.'"
		 ';
		 if($dType == $gradT) echo 'selected';
		 echo '>'.$dType.'</option>';
	}
	echo '</select>';
	
	$query = "SELECT *
			  FROM degreeareas";
	$degAreas = $database->query($query);
	echo '<select name="degA">';
	foreach($degAreas as $dA){
		$dArea = $dA['DegreeArea'];
		echo '<option value="'.$dArea.'"
		 ';
		 if($dArea == $gradA) echo 'selected';
		 echo '>'.$dArea.'</option>';
	}
	echo '</select>';	
	
}

?>
