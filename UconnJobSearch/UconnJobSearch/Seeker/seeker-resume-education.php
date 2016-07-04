<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-29] Allows user to edit, add, or delete
		education-->
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
		
		<?php
		
		$uni = $degT = $degA = $gpa = $start = $grad = '';
		$edit = 0; $edID=0;	
	
		if(isset($_POST['update'])){
				$username = $_SESSION['username'];			
						
				$query = "SELECT ResumeID
						  FROM resume
						  WHERE UName = '$username'";	
				$resumeID = $database->query($query);
				$resumeID = $resumeID[0];
				$resumeID = $resumeID['ResumeID'];
				
				$uni = $_POST['uni'];
				$degT = $_POST['degT'];
				$degA = $_POST['degA'];
				$gpa = $_POST['gpa'];
				$start = $_POST['start'];
				$grad = $_POST['grad'];
				$edit = $_POST['edit'];
				if($edit == 1){
					$edID = $_POST['edID'];		
					$query = "UPDATE education
							  SET EUniversity='$uni',
							  EDegreeType='$degT',
							  EDegreeArea='$degA',
							  ResumeID='$resumeID',
							  EGPA='$gpa',
							  EStartDate='$start',
							  EGradDate='$grad'
							  WHERE EducationID=$edID";
					$database->query($query);
					header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");
				} else {
					
					$query = "INSERT INTO education
							  (EUniversity, EDegreeType, EDegreeArea,
							   ResumeID, EGPA, EStartDate, EGradDate)
							   VALUES ('$uni', '$degT', '$degA', '$resumeID',
							   		   '$gpa', '$start', '$grad')";
					$database->query($query);
					header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");					
				}	
			
		}
		
		if(isset($_POST['editEd'])){
			$edID = $_POST['edID'];
			
			$query = "SELECT *
					  FROM education
					  WHERE EducationID=$edID";
			
			$ed = $database->query($query);
			$ed = $ed[0];
			
			$uni = $ed['EUniversity'];
			$degT = $ed['EDegreeType'];
			$degA = $ed['EDegreeArea'];
			$gpa = $ed['EGPA'];
			$start = $ed['EStartDate'];
			$grad = $ed['EGradDate'];			
			$edit = 1;
		} elseif(isset($_POST['delEd'])){
			
			$edID = $_POST['edID'];
			$query = "DELETE FROM
					  education
					  WHERE EducationID=$edID";
			$database->query($query);
			header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");
			
		}		
		
		echo '<form class="login" method="post" action="seeker-resume-education.php">
			  <label>University:</label><br />
			  <input type="text" name="uni" value="'.$uni.'" required/>
			  <br />
			  <label>Degree</label><br />
			  '; generateDegree($degT, $degA);
		echo '<br />
			  <label>GPA</label><br />
			  <input type="text" name="gpa" value="'.$gpa.'"/>
			  <br />
			  <label>Start Date - End Date</label>
			  <input type="date" name="start" value="'.$start.'"/>
			  <input type="date" name="grad" value="'.$grad.'" />
			  <br /><br />
			  <input type="hidden" name="edit" value="'.$edit.'"/>
			  <input type="hidden" name="edID" value="'.$edID.'"/>
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