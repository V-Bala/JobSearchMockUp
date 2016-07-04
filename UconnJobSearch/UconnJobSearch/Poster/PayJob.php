<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>



<?php
	$page_title = "Pay for a job!";
	$page_type = "poster";
	include("./../includes/header.php");
		session_start();
		if(!empty($_SESSION['errMsg'])){
			$errMsg = $_SESSION['errMsg'];
	 		echo "<script>alert('$errMsg')</script>"; 
		}
?>	


<body>
	<div class wrapper>
				<ul class="nav"><!--Nav start-->

			<li><a href="PosterJobs.php" id="jobs">Jobs</a></li>
			<li><a href="poster-profile.php" id="logout">Profile</a></li>
			<li><a class="selected" href="Post.php" id="post">Post A Job</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
	<form class="login" action="PayPostedJob.php" method='post'
	 accept-charset='UTF-8'>
	<fieldset>
	<legend>Pay By Credit Card</legend>
	<input type="hidden" name="username" value="<?php echo($_SESSION['username']);?>"/>
	<input type="hidden" name="type" value="credit"/>
	
	<label for='Job ID' >JobID:</label><br />
	<input type='text' name='jobid' id='jobid' maxlength="50" />
	<br />
	
	<label for='Credit Card Number' >CCNumber:</label><br />
	<input type='text' name='ccnumber' id='ccnumber' maxlength="50" />
	<br />
	<label for='Credit Card Type' >CC Type:</label><br />
	<input type='text' name='cctype' id='cctype' maxlength="50" />
	<br />
	<label for='Credit Card Expiration Date' >CC Expiration Date:</label><br />
	<input type='text' name='ccexpirdate' id='ccexpirdate' maxlength="50" />
	<br />
	<input type='submit' name='Submit' value='Submit' />
	</form>
	<br />
	<form class="login" action="/UconnJobSearch/Poster/PosterJobs.php">
	<input type="submit" name="submit" value="Cancel" />
	</fieldset>
	</form>
	
	
	
	<form class="login" action="PayPostedJob.php" method='post'
	 accept-charset='UTF-8'>
	<fieldset>
	<legend>Pay By Bank</legend>
	<input type="hidden" name="type" value="bank"/>
	<input type="hidden" name="username" value="<?php echo($_SESSION['username']);?>"/>
	<label for='Job ID' >JobID:</label><br />
	<input type='text' name='jobid' id='jobid' maxlength="50" />
	<br />
	<label for='Bank Number' >Bank Account Number:</label><br />
	<input type='text' name='baccountnumber' id='baccountnumber' maxlength="50" />
	<br />
	<label for='Bank Name' >Bank Name:</label><br />
	<input type='text' name='bname' id='bname' maxlength="50" />
	<br />
	<input type='submit' name='Submit' value='Submit' />
	</form>
	<br />
	<form class="login" action="/UconnJobSearch/Poster/PosterJobs.php">
	<input type="submit" name="submit" value="Cancel" />
	</fieldset>
	</form>
	
	
	<form class="login" action="PayPostedJob.php" method='post'
	 accept-charset='UTF-8'>
	<fieldset>
	<legend>Pay By Online Service</legend>
	<input type="hidden" name="type" value="online"/>
	<input type="hidden" name="username" value="<?php echo($_SESSION['username']);?>"/>
	<label for='Job ID' >JobID:</label><br />
	<input type='text' name='jobid' id='jobid' maxlength="50" />
	<br />
	<label for='Service Name' >Service Name:</label><br />
	<input type='text' name='sname' id=''baccountnumber'sname' maxlength="50" />
	<br />
	<label for='Service Fee' >Service Fee:</label><br />
	<input type='text' name='sfee' id='sfee' maxlength="50" />
	<br />
	<input type='submit' name='Submit' value='Submit' />
	</form>
	<br />
	<form class="login" action="/UconnJobSearch/Poster/PosterJobs.php">
	<input type="submit" name="submit" value="Cancel" />
	</fieldset>
	</form>

<div class="push"></div>
</div>
</body>
<?php include("./../includes/footer.php"); ?>
</html>