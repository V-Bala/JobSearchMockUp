<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-30] Allows user to view resume, skills, 
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
		<?php 
			
			$obj = $text = $min = '';
			$res = 0;
			
			if(isset($_POST['update'])){
				
				$query = "SELECT *
						  FROM user
						  WHERE UName='$username'";
						  
				$name = $database->query($query);
				$fname = $name[0]['UFName'];
				$lname = $name[0]['ULName'];
				
				$obj = $_POST['obj'];
				$text = $_POST['text'];
				$min = $_POST['min'];
				$res = $_POST['res'];
					
				if($res==0){
					$query = "INSERT INTO resume
							  (RFName, RLName, UName,
							  RObjective, RSalaryMin, RText)
							  VALUES ('$fname', '$lname',
							  '$username', '$obj', '$min', '$text')";
					$database->query($query);
				} else {
					$query = "UPDATE resume
							  SET RFName='$fname', RLName='$lname',
							  RObjective='$obj', RSalaryMin=$min,
							  RText='$text'
							  WHERE UName='$username'";
					$database->query($query);
				}
				
				$query = "DELETE FROM hasskill
						  WHERE ResumeID IN(
						  	SELECT ResumeID
							FROM resume 
							WHERE UName ='$username')";
				$database->query($query);
				// skill insert here
				if(!empty($_POST['skill'])){
					$skills = $_POST['skill'];
					$resume = $database->query("SELECT ResumeID
												FROM resume
												WHERE UName='$username'");
					$resume = $resume[0]['ResumeID'];
					
					foreach($skills as $skill){
						$query = "INSERT INTO hasskill
								  (SSkillName, ResumeID)
								  VALUES
								  ('$skill', '$resume')";
						$database->query($query);
					}
					
				}
				
				header("refresh:0; url=/UconnJobSearch/Seeker/seeker-resume.php");				
				
			}
			
			echo '<div class="left-jobs">';
			
			$query = "SELECT *
					  FROM resume
					  WHERE UName = '$username'";
			
			$resume = $database->query($query);
			if(!empty($resume)){
				$resume = $resume[0];	
				$obj = $resume['RObjective'];
				$text = $resume['RText'];	
				$min = $resume['RSalaryMin'];	
				$res = 1;		
			}
			echo '<form method="post" class="login" action="seeker-resume-text.php">
				  <label>Objective</label><br />
				  <input type="text" name="obj" value="'.$obj.'" />
				  <br />
				  <label>Text</label>
				  <textarea rows="5" name="text" style="width:100%;">'.$text.'</textarea>
				  <br />
				  <label>Salary Min (Digits only)</label>
				  <input type="number" name="min" value="'.$min.'"/>
				  <br />';
				  
			echo '<input type="submit" name="update" value="Submit"/>
				  <br /><a href="seeker-resume.php">Cancel</a>
				  </div>
				  <div class="right-jobs">';
			//skill stuff here ALSO start of right half
			$query = "SELECT SSkillName
					  FROM hasskill
					  WHERE ResumeID IN(
					  	SELECT ResumeID
					  	FROM resume
					  	WHERE UName = '$username')";
			$mySkills = $database->query($query);
			
			$query = "SELECT *
					  FROM skill";
			
			$allSkills = $database->query($query);
			
			echo '<table>';
			
			foreach($allSkills as $skill){
				$skill = $skill['SSkillName'];
				echo '<tr><td><input type="checkbox" name="skill[]" value="'.$skill.'"';
				if(!empty($mySkills)){
					foreach($mySkills as $mySkill){
						$mySkill = $mySkill['SSkillName'];
						if($mySkill == $skill) echo 'checked';
					}
				}
				echo '/></td>
					 <td><p>'.$skill.'</p></td></tr>';
			}
			
			
			echo '</table>
				  <input type="hidden" name="res" value="'.$res.'"/>
				  </form>';
		
		
		?>
		
		</div>
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>
</html>