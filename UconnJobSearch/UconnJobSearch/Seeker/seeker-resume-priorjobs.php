<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-29] Allows user to edit, add, or delete
		prior jobs-->
</head>

<?php
	session_start();
	$page_title = "Seeker | Resume";
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
			<li><a href="seeker-jobapps.php" id="jobApps">Job Apps</a></li>
			<li><a class="selected" href="seeker-resume.php" id="resume">Resume</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
		
		<?php
		
		$pjname = $pjtitle = $pjduty = $pjcity = $pjstart = $pjend = '';
		$edit = 0; $pjID=0;	
	
		if(isset($_POST['update'])){
				$username = $_SESSION['username'];			
						
				$query = "SELECT ResumeID
						  FROM resume
						  WHERE UName = '$username'";	
				$resumeID = $database->query($query);
				$resumeID = $resumeID[0];
				$resumeID = $resumeID['ResumeID'];
				
				$pjname = $_POST['pjname'];
				$pjtitle = $_POST['pjtitle'];
				$pjduty = $_POST['pjduty'];
				$pjcity = $_POST['pjcity'];
				$pjstart = $_POST['pjstart'];
				$pjend = $_POST['pjend'];
				$edit = $_POST['edit'];
				if($edit == 1){
					$pjID = $_POST['pjID'];		
					$query = "UPDATE priorjobs
							  SET PJCompanyName='$pjname',
							  PJJobTitle='$pjtitle',
							  PJDuties='$pjduty',
							  ResumeID='$resumeID',
							  PJCity='$pjcity',
							  PJStartDate='$pjstart',
							  PJEndDate='$pjend'
							  WHERE PJID=$pjID";
					$database->query($query);
					header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");
				} else {
					
					$query = "INSERT INTO priorjobs
							  (PJCompanyName, PJJobTitle, PJDuties,
							   ResumeID, PJCity, PJStartDate, PJEndDate)
							   VALUES ('$pjname', '$pjtitle', '$pjduty', '$resumeID',
							   		   '$pjcity', '$pjstart', '$pjend')";
					$database->query($query);
					header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");					
				}	
			
		}
		
		if(isset($_POST['editPJ'])){
			$pjID = $_POST['pjID'];
			
			$query = "SELECT *
					  FROM priorjobs
					  WHERE PJID=$pjID";
			
			$pj = $database->query($query);
			$pj = $pj[0];
			
			$pjname = $pj['PJCompanyName'];
			$pjtitle = $pj['PJJobTitle'];
			$pjduty = $pj['PJDuties'];
			$pjcity = $pj['PJCity'];
			$pjstart = $pj['PJStartDate'];
			$pjend = $pj['PJEndDate'];		
			$edit = 1;
		} elseif(isset($_POST['delPJ'])){
			
			$pjID = $_POST['pjID'];
			$query = "DELETE FROM
					  priorjobs
					  WHERE PJID=$pjID";
			$database->query($query);
			header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");
			
		}		
		
		echo '<form class="login" method="post" action="seeker-resume-priorjobs.php">
			  <label>Company Name:</label><br />
			  <input type="text" name="pjname" value="'.$pjname.'" required/>
			  <br />
			  <label>Job Title</label><br />
			  <input type="text" name="pjtitle" value="'.$pjtitle.'"required/>';
		echo '<br />
			  <label>Duties</label><br />
			  <textarea name="pjduty">'.$pjduty.'</textarea>
			  <br />
			  <label>City</label><br />
			  <input type="text" name="pjcity" value="'.$pjcity.'"/>
			  <br />
			  <label>Start Date - End Date</label>
			  <input type="date" name="pjstart" value="'.$pjstart.'"/>
			  <input type="date" name="pjend" value="'.$pjend.'" />
			  <br /><br />
			  <input type="hidden" name="edit" value="'.$edit.'"/>
			  <input type="hidden" name="pjID" value="'.$pjID.'"/>
			  <input type="submit" name="update" value="Submit"/>
			  </form>';
		
		?>
			
		<a href="seeker-resume.php">Cancel</a>	
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>
</html>