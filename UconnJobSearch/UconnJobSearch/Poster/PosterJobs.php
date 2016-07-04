<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
	<!-- Date: 2015-04-22 -->
</head>

<?php
	session_start();
	$page_title = "Poster Jobs";
	include("./../includes/header.php");
	include("poster.handler.php");
	if(!validLogin('poster')) 
	die();	
	$database = new DatabaseConnector();
	$database->connect();
?>

<body>
	<div class="wrapper">
		<ul class="nav"><!--Nav start-->
			<li><a class="selected" href="PosterJobs.php" id="jobs">Jobs</a></li>
			<li><a href="poster-profile.php" id="profile">Profile</a></li>
			<li><a href="Post.php" id="logout">Post A Job</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
		
		<div class="right-jobs">
		<br>
		<br>
			<?php						
			$username = $_SESSION['username'];
				if(isset($_GET['jobID'])){
					$jobID = $_GET['jobID'];
					$query = "SELECT * FROM job NATURAL JOIN payment WHERE JobID=$jobID";
					$results = $database->query($query);
					$results = $results[0];
				echo '<p><b><center>The Selected Job is Job #: </center></b></p> 
				  <p><center>'.$results['JobID'].'</center></p>
				<p><b><center>The Current Job is: </center></b></p> 
				  <p><center>'.$results['JFillStatus'].'</center><p>
				  <p><b><center>And the payment is:</center></b></p> 
				  <p><center>'.$results['PStatus'].'</center><p>';
				}else{
					echo '<p><b><center>Clicking on a job allows you to either delete the Post, or edit its status!</center></b></p>'; 
				}			
		?>		
	<?php if(isset($_GET['jobID'])) :?>	
	<form class="login" action="UpdateFillStatus.php" method='post'
	 accept-charset='UTF-8'>
	<input type="hidden" name="jobid" value="<?php echo($results['JobID']);?>"/>
	<input type="hidden" name="jfillstatus" value="<?php echo($results['JFillStatus']);?>"/>
	<fieldset>
	<input type='submit' name='Submit' value='Update Job Status!' />
	</fieldset>
	</form>
	
	<form class="login" action="DeleteJob.php" method='post'
	 accept-charset='UTF-8'>
	<input type="hidden" name="jobid" value="<?php echo($results['JobID']);?>"/>
	<fieldset>
	<input type='submit' name='Submit' value='Delete This Job' />
	</fieldset>
	</form>
	
	<form class="login" action="PayJob.php" method='post'
	 accept-charset='UTF-8'>
	<input type="hidden" name="jobid" value="<?php echo($results['JobID']);?>"/>
	<input type="hidden" name="paymentid" value="<?php echo($results['PaymentID']);?>"/>
	<fieldset>
	<input type='submit' name='Submit' value='Pay This Job' />
	</fieldset>
	
	</fieldset>
	</form>
	<?php endif;?>
	</div>
		
		<?php	
		$username = $_SESSION['username'];	
		$database = new DatabaseConnector();
		$database->connect();
		$query = "SELECT * FROM poster NATURAL JOIN user WHERE UName ='$username'";	
		$results = $database->query($query);
		if(!empty($results)){
			$results = $results[0];
		}
		$companyname = $results['CName'];
		if(empty($companyname)){
			echo "<script>alert('You cannot view this list until you enter a Company Name!')</script>";
			header("refresh:0; url=/UconnJobSearch/Poster/RequiredCompanyName.php");
		}else	
				$query = "SELECT * 
				  	  FROM company
				      WHERE cname= '$companyname'";
				  if(empty($database->query($query))){
				  	"<script>alert('Your company has not yet posted any jobs!')</script>";
				  }
				  ?>
				  
		<div class="left-jobs">	
			<h5>List of Jobs you've posted</h5>
			<?php
			echo '<h5 style="border:1px solid #000000;display:block;width:100%;background-color:#DCDCDC;"></h5>';
			$username = $_SESSION['username'];	  
			$query = "SELECT * FROM poster NATURAL JOIN user WHERE UName ='$username'";	
			$results = $database->query($query);
			if(!empty($results)){
				$results = $results[0];
			}
			$companyname = $results['CName'];
			
			$query = "SELECT * FROM job WHERE CName = '$companyname'";
			$results = $database->query($query);	  
			if(!empty($results)){
				echo '<table><tr>
							<td width = "40%"><b>Job Title</b></td>
							<td width = "40%"><b>Company Name</b></td>
							<td width = "20%"><b>Job Salary</b></td>
							</tr>';
			foreach($results as $result){
					$tempID = $result['JobID'];
					$query1 = "SELECT * FROM job WHERE jobID = '$tempID'";
					$nextresult = $database->query($query1);
					if(!empty($nextresult)){
						$nextresult = $nextresult[0];
					}
				echo '<tr>
						<td><a href="PosterJobs.php?jobID='.$nextresult['JobID'].'">'.$nextresult['JTitle'].'</a></td>
						<td>'.$nextresult['CName'].'</td>
						<td>$'.$nextresult['JLowRange'].' - $'.$nextresult['JHighRange'].'</td>
						</tr>';
			}
			echo '</table>';
			}else
				/** echo "<script>alert('Query found no results!')</script>"; */
		?>
		</div>
	<div class="push"></div>
	</div> 
</body>
	<?php 
	include("./../includes/footer.php"); 
	$database->closeCon();
	?>	
</html>			
	