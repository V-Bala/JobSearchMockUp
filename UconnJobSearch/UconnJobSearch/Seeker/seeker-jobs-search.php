<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!--Austin - [2015-04-26] - allows user to search jobs
		unrestricted, also allows job detail viewing, and applying-->
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
				
			$username = $_SESSION['username'];
			getInfo();
			apply();
			
			?>

		</div><!--Right-half of Jobs (Summary)-->
		<!--Show me jobs I search for which I haven't applied to-->
		<div class="left-jobs">
		<h5>Manually search for jobs! Click below to revert to related jobs</h5>		
		<?php		
		// make our query! pull data from post and get to keep list correct
		if(isset($_POST) || isset($_GET)){
			$query = "SELECT * FROM job WHERE ";
		}
		$title = $sal = $loc = $cname = '';
		if(isset($_POST['title'])){
			$title = $_POST['title'];
		} elseif(isset($_GET['title'])){
			$title = $_GET['title'];	
		}
		$query .= "JTitle LIKE '%$title%' ";
		if(isset($_POST['cname'])){
			$cname = $_POST['cname'];
		} elseif(isset($_GET['cname'])){
			$cname = $_GET['cname'];		
		}		
		$query .="AND CName LIKE '%$cname%' ";
		if(isset($_POST['sal'])){
			$sal = $_POST['sal'];
		} elseif(isset($_GET['sal'])){
			$sal = $_GET['sal'];
		}
		$query .= "AND JLowRange >= '$sal'";
		if(isset($_POST['loc'])){
			$loc = $_POST['loc'];
		} elseif(isset($_GET['loc'])){
			$loc = $_GET['loc'];
		}
		$query .= "AND jcity LIKE '%$loc%'
				   AND JobID NOT IN 
				   (SELECT JobID
				   FROM jobapp
				   WHERE UName = '$username')";
		//echo $query;
		echo '<form class="login" style="width:100%;" method="post" action="seeker-jobs-search.php">
			  <input type="text" name="title" placeholder="Job Title" value="'.$title.'" />
			  <input type="text" name="cname" placeholder="Company Name" value="'.$cname.'" />
			  <input type="number" name="sal" placeholder="Min. Salary (ONLY DIGITS)" value="'.$sal.'" />
			  <input type="text" name="loc" placeholder="Location (City)" value="'.$loc.'"/><br /><br />
			  <input type="submit" name="searchJobs" value="Search" /><br /><br />
			  </form>';
		
		echo '<h5 style="border:1px solid #000000;display:block;width:95%;background-color:#DCDCDC;"><a href="seeker-jobs.php">VIEW RELATED JOBS INSTEAD</a></h5>';
		
		$results = $database->query($query);
		if(!empty($results)){
			echo '<table><tr>
							<td width = "40%"><b>Job Title</b></td>
							<td width = "40%"><b>Company Name</b></td>
							<td width = "20%"><b>Job Salary</b></td>
							</tr>';
			foreach($results as $result){
				// echo out table, attach info for query and appid
				echo '<tr>
						<td><a href="seeker-jobs-search.php?jobID='.$result['JobID'].'
						&title='.$title.'&cname='.$cname.'&sal='.$sal.'&loc='.$loc.'">
						'.$result['JTitle'].'</a></td>
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