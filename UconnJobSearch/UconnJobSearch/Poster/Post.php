<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<?php
	$page_title = "Post a new Job!";
	$page_type = "poster";
	include("./../includes/header.php");
		session_start();
		if(!empty($_SESSION['errMsg'])){
			$errMsg = $_SESSION['errMsg'];
	 		echo "<script>alert('$errMsg')</script>"; 
		}

?>	

<body>
<div class="wrapper">

		<ul class="nav"><!--Nav start-->

			<li><a href="PosterJobs.php" id="jobs">Jobs</a></li>
			<li><a href="poster-profile.php" id="logout">Profile</a></li>
			<li><a class="selected" href="Post.php" id="post">Post A Job</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
	<form class="login" action="PostJobs.php" method='post'
	 accept-charset='UTF-8'>
	<fieldset>
	<legend>Post</legend>
	<input type="hidden" name="username" value="<?php echo($_SESSION['username']);?>"/>
	<label for='Job ID' >JobID:</label><br />
	<input type='text' name='jobID' id='jobID' maxlength="50" />
	<br />
	<label for='Company Name' >Company Name:</label><br />
	<input type='text' name='cname' id='cname' maxlength="50" />
	<br />
	<label for='Job List Date' >Job List Date:</label><br />
	<input type='text' name='jlistdate' id='jlistdate' maxlength="50" />
	<br />
	<label for='Job Title' >Job Title:</label><br />
	<input type='tel' name='jtitle' id='jtitle' maxlength="50" />
	<br />
	<label for='Job City' >Job City:</label><br />
	<input type='text' name='jcity' id='jcity' maxlength="50" />
	<br />
	<label for='Job Duties' >Job Duties:</label><br />
	<input type='text' name='jduties' id='jduties' maxlength="50" />
	<br />
	<label for='Job Zip Code' >Job Zip Code:</label><br />
	<input type='text' name='jzip' id='jzip' maxlength="50" />
	<br />
	<label for='Job Years Experience' >Job Years Experience</label><br />
	<input type='text' name='jyrsexperience' id='jyrsexperience' maxlength="50" />
	<br />
	<label for='Job Low Range' >Job Low Range</label><br />
	<input type='text' name='jlowrange' id='jlowrange' maxlength="50" />
	<br />
	<label for='Job Low Range' >Job High Range</label><br />
	<input type='text' name='jhighrange' id='jhighrange' maxlength="50" />
	<br />
	
	<label for='Degree Area' >Degree Area:</label><br />
	<select name='darea' id='darea' >
		<option value="AH">Art History</option>
		<option value="CS">Computer Science</option>
		<option value="CSE">Computer Science & Engineering</option>
		<option value="EE">Electrical Engineering</option>
		<option value="LA">Liberal Arts</option>
		<option value="MA">Mathematics</option>
		<option value="PR">Pharmacy</option>
		<option value="PH">Physics</option>
	</select>
	<br />	
	
	<label for='Degree Type' >Degree Type:</label><br />
	<select name='dtype' id='dtype' >
		<option value="AA">Associate Arts</option>
		<option value="AS">Associate Science</option>
		<option value="BA">Bachelor Arts</option>
		<option value="BS">Bachelor Science</option>
		<option value="MS">Master Science</option>
		<option value="DA">Doctoral Arts</option>
		<option value="DS">Doctoral Science</option>
	</select>
	<br />	
	
	<label for='Filled' >Unfilled</label><br />
	<input type="radio" name="jfillstatus" value="Unfilled" />
	<br />
	<label for='Unfilled' >Filled</label><br />
	<input type="radio" name="jfillstatus" value="Filled" />
	<br />
	<label for='Invoice' >Invoice</label><br />
	<input type="radio" name="payment" value="Invoice" />
	<br />
	<label for='Bank' >Bank Payment</label><br />
	<input type="radio" name="payment" value="Filled" />
	<br />
	<label for='Online Service' >Online Service</label><br />
	<input type="radio" name="payment" value="Online" />
	<br />
	<label for='Credit Card' >Credit Card</label><br />
	<input type="radio" name="payment" value="Credit Card" />
	<br />
	<input type='submit' name='Submit' value='Submit' />
	</form>
	<br />
	<form class="login" action="/UconnJobSearch/index.php">
	<input type="submit" name="submit" value="Cancel" />
	</fieldset>
	</form>
<div class="push"></div>
</div>
</body>
<?php include("./../includes/footer.php"); ?>
</html>
