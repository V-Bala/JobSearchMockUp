<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Date: 2015-04-27 -->
</head>

<?php
	session_start();
	$page_title = "Seeker | Apps";
	include("./../includes/header.php");
	include("seeker.handler.php");
	if(!validLogin('seeker')) die();
	if(!hasResume()) die();			
	$database = new DatabaseConnector();
	$database->connect();		
?>

<body>
	<div class="wrapper">
		<ul class="nav"><!--Nav start-->
			<li><a href="seeker-profile.php" id="profile">Profile</a></li>
			<li><a href="seeker-jobs.php" id="jobs">Jobs</a></li>
			<li><a class="selected" href="seeker-jobapps.php" id="jobApps">Job Apps</a></li>
			<li><a href="seeker-resume.php" id="resume">Resume</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
	
	<!--my summary, again-->
	<div class="right-jobs">
	<h5>Summary of selected job</h5>
	<?php
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
				  <p>'.$results['JFillStatus'].'
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
				  	  										
		unset($_GET['jobID']);
	}		
	?>	
	</div>
	<!--show my apps-->
	<div class="left-jobs">
	<h5>Your job applications</h5>
	<?php
		$username = $_SESSION['username'];
		
		if(!empty($_POST['toDelete'])){
			$arr = $_POST['toDelete'];
			foreach($arr as $ar){
				$query = "DELETE FROM jobapp
					 	  WHERE AppID=$ar";	
				$database->query($query);		  
			}
			unset($_POST);
		}
		
		$query = "SELECT J.JobID, J.JTitle, JA.DateApplied, JA.AppID, J.JFillStatus 
				  FROM jobapp AS JA
				  INNER JOIN job AS J
				  ON J.JobID = JA.JobID
				  WHERE UName='$username'";
		
		$results = $database->query($query);
		if(!empty($results)){
			echo '<form method="post" action="seeker-jobapps.php">
				  <input type="hidden" name="toDelete[]" />
				  <table><tr>
					<td width="10%"><b>Delete?</b></td>
					<td width="10%"><b>Fill Status</b></td>
					<td width="25%"><b>Job Title</b></td>
					<td width="25%"><b>Date Applied</b></td>
					</tr>';
			foreach($results as $result){
				echo '<tr>
						<td><input type="checkbox" name="toDelete[]" value="'.$result['AppID'].'"</td>
						<td>'.$result['JFillStatus'].'</td>
						<td><a href="seeker-jobapps.php?jobID='.$result['JobID'].'">'.$result['JTitle'].'</a></td>
						<td>'.$result['DateApplied'].'</td>
					  </tr>';
			}
			echo '</table>
					<input style="margin-left:2px;"type="submit" name="deleteApps" value="Delete" />
				  </form>';
		}
				  
	?>
	</div><!--Left job, table of apps-->
	
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>
</html>