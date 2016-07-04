<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-26] Allows user to see jobs related
		by degree type, or degree area, or skill. Also allows
		viewing job details, and applying to jobs-->
</head>

<?php
	session_start();
	$page_title = "Seeker | Jobs";
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
			<li><a class="selected" href="seeker-jobs.php" id="jobs">Jobs</a></li>
			<li><a href="seeker-jobapps.php" id="jobApps">Job Apps</a></li>
			<li><a href="seeker-resume.php" id="resume">Resume</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
		<!--Show me a summary of a job, if there is one, and apply if we did-->
		<div class="right-jobs">
		<h5>Summary of selected job</h5>
			<?php				
				
				getInfo();
				
				apply();								

			?>

		</div><!--Right-half of Jobs (Summary)-->
		<!--Show me relevant jobs I haven't applied to-->
		<div class="left-jobs">
		<h5>Jobs that match a skill, degree area, or degree type of yours</h5>
		<h5>If you want to browse non-matching jobs, please click below</h5>		
		<?php
		echo '<h5 style="border:1px solid #000000;display:block;width:90%;background-color:#DCDCDC;"><a href="seeker-jobs-search.php">SEARCH FOR JOBS</a></h5>';
		$username = $_SESSION['username'];
		// MEGAAAA QUEERRRRY - probably a more efficient way to do it but I couldn't find it
		$query ="SELECT * 
				FROM job
				WHERE ((JobID IN(
   		 					SELECT JobID
    						FROM jdegreeareas
    						WHERE DegreeArea IN(
       		 					SELECT EDegreeArea
       	 						FROM education
        						WHERE ResumeID IN(
            						SELECT ResumeID
            						FROM resume
            						WHERE UName='$username'))))
					OR (JobID IN(
        				SELECT JobID
        				FROM jdegreetypes
     		   			WHERE DegreeType IN(
            				SELECT edegreetype
            				FROM education
            				WHERE ResumeID IN(
                				SELECT ResumeID
                				FROM resume
                				WHERE UName='$username'))))
  					OR (JobID IN(
        				SELECT JobID
        				FROM requiresskill
        				WHERE SSkillName IN(
            				SELECT SSkillName
            				FROM hasskill
            				WHERE ResumeID IN(
                				SELECT ResumeID
                				From resume
                				WHERE UName='$username')))))
     				AND JobID NOT IN(SELECT JobID
                      FROM jobapp
                      WHERE UName='$username')";
		$results = $database->query($query);
		if(!empty($results)){
			echo '<table><tr>
							<td width = "40%"><b>Job Title</b></td>
							<td width = "40%"><b>Company Name</b></td>
							<td width = "20%"><b>Job Salary</b></td>
							</tr>';
			foreach($results as $result){
				echo '<tr>
						<td><a href="seeker-jobs.php?jobID='.$result['JobID'].'">'.$result['JTitle'].'</a></td>
						<td>'.$result['CName'].'</td>
						<td>$'.$result['JLowRange'].' - $'.$result['JHighRange'].'</td>
						</tr>';
			}
			echo '</table>';
		}	
		?>
		</div><!--Left-half of Jobs (Bulk output)-->
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>
</html>