<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-29] Allows user to view resume, skills, 
		education, and prior jobs. Also hosts links to pages which
		allow user to edit/add to resume-->
</head>

<?php
	session_start();
	$page_title = "Seeker | Resume";
	include("./../includes/header.php");
	include("seeker.handler.php");
	if(!validLogin('seeker')) die();	
	$database = new DatabaseConnector();
	$database->connect();
	$username = $_SESSION['username'];

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
		<!--Show me my prior jobs, and education. Let me add and edit-->
		
		<!--Show me my resume fields (name, objective, text, skills)-->
		<div class="left-jobs">
			<?php
				$query = "SELECT *
						  FROM resume
						  WHERE UName = '$username'";
				$resume = $database->query($query);
				
				$query = "SELECT *
						  FROM hasskill
						  WHERE ResumeID IN(
						  	SELECT ResumeID
						  	FROM resume
						  	WHERE UName = '$username')";
				$skills = $database->query($query);
				
				$query = "SELECT *
						  FROM education
						  WHERE ResumeID IN(
						  	SELECT ResumeID
							FROM resume
							WHERE UName = '$username')";	
				$education = $database->query($query);
				
				$query = "SELECT *
						  FROM priorjobs
						  WHERE ResumeID IN(
						  	SELECT ResumeID
						  	FROM resume
						  	WHERE UName = '$username')";
				$priorjobs = $database->query($query);
					  
				echo '<br /><a href="seeker-resume-text.php" 
					style="background-color:#DCDCDC;border:1px solid #000000">
					Edit/Add Resume</a><br />';					  
					  
				if(!empty($resume)){
					$resume = $resume[0];
					echo '<h5>Static Content</h5>
						  <p><b>First Name:</b><br /> '.$resume['RFName'].'</p>
						  <p><b>Last Name:</b><br /> '.$resume['RLName'].'</p>
						  <br /><br />';		
					echo  '<h5>Resume Text and Skills</h5>
						  <label><b>Objective:</b></label><br />
						  <p>'.$resume['RObjective'].'</p><br />
						  <label><b>Text:</b></label><br />
						  <p>'.$resume['RText'].'</p>
						  <p><b>Salary Min</b></p>
						  <p>$'.$resume['RSalaryMin'].'</p>
						  <p><b>Skills:</b></p>';
						  
						if(!empty($skills)){
						  $skills = array_column($skills, 'SSkillName');
						  echo implode(", ", $skills);
						 }	 					 						  						  
				}			  
			?>
		</div><!--Left-half of Jobs (Static stuff/Text/File)-->
		
		<div class="right-jobs">
			<?php 
				echo '<br /><a href="seeker-resume-education.php" 
				style="background-color:#DCDCDC;border:1px solid #000000">
				Add Education</a><br />';		
				
						
				$cnt = 1;
				if(!empty($education)){
					foreach($education as $ed){
						echo '<h5>Education '.$cnt.'</h5>
							  <p><b>University</b></p>
							  <p>'.$ed['EUniversity'].'
							  <p><b>Degree</b></p>
							  <p>'.$ed['EDegreeType'].' in '.$ed['EDegreeArea'].'</p>
							  <p><b>GPA</b></p>
							  <p>'.$ed['EGPA'].'</p>
							  <p><b>Enrollment Period</b></p>
							  <p>'.$ed['EStartDate'].' to '.$ed['EGradDate'].'
							  <form method="post" action="seeker-resume-education.php">
							  <input type="hidden" name="edID" value="'.$ed['EducationID'].'"/>
							  <input type="submit" name="editEd" value="Edit Education '.$cnt.'"/>
							  <input type="submit" name="delEd" value="Delete Education '.$cnt.'"/>
							  </form>';
							  $cnt++;
					}
				}
				echo '<br /><a href="seeker-resume-priorjobs.php" 
						style="background-color:#DCDCDC;border:1px solid #000000">
						Add Prior Job</a><br />';

				$cnt=1;
				if(!empty($priorjobs)){
					foreach($priorjobs as $pj){
						echo '<h5>Prior Job '.$cnt.'</h5>
							  <p><b>Company Name</b></p>
							  <p>'.$pj['PJCompanyName'].'</p>
							  <p><b>Job Title</b></p>
							  <p>'.$pj['PJJobTitle'].'</p>
							  <p><b>Duties</b></p>
							  <p>'.$pj['PJDuties'].'</p>
							  <p><b>Location</b></p>
							  <p>'.$pj['PJCity'].'</p>
							  <p><b>Employment Period</b></p>
							  <p>'.$pj['PJStartDate'].' - '.$pj['PJEndDate'].'
							  <form method="post" action="seeker-resume-priorjobs.php">
							  <input type="hidden" name="pjID" value="'.$pj['PJID'].'"/>
							  <input type="submit" name="editPJ" value="Edit Prior Job '.$cnt.'"/>
							  <input type="submit" name="delPJ" value="Delete Prior Job '.$cnt.'"/>
							  </form>';
							  $cnt++;
					}
				}
			
			?>
			
		</div><!--Right-half of Jobs (Education/PriorJobs)-->
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>
</html>