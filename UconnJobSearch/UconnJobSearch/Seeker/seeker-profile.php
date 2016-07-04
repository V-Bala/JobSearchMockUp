<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Austin" />
	<!-- Austin - [2015-04-25] Allows user to update their profile
		and add content not originally required during registration -->
</head>

<?php
	session_start();
	$page_title = "Seeker | Profile";
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
			<li><a class="selected" href="seeker-profile.php" id="profile">Profile</a></li>
			<li><a href="seeker-jobs.php" id="jobs">Jobs</a></li>
			<li><a href="seeker-jobapps.php" id="jobApps">Job Apps</a></li>
			<li><a href="seeker-resume.php" id="resume">Resume</a></li>
			<li><a href="/UconnJobSearch/includes/logout.php" id="logout">Logout</a></li>
		</ul>
		
		<!--let me update my profile-->
		<?php
		if(isset($_POST['submit'])){
		$errMsg = updateLogin($_POST);
			if(empty($errMsg)){
				echo "<script>alert('Success!')</script>";
			} else {
				echo "<script>alert('$errMsg')</script>";
			}
		}
		
		$username = $_SESSION['username'];
		$query = "SELECT * FROM user WHERE UName='$username'";
		$results = $database->query($query);
		if(!empty($results)){
			$results = $results[0];
		}
		?>
		<h3 style="text-align: center; font-family:arial;">Update your user info!</h3>
		<form class="login" method="post" action="seeker-profile.php">
			<input type="hidden" name="oldusername" value="<?php echo($results['UName']); ?>" />
			<input type="hidden" name="oldemail" value="<?php echo($results['UEmail']); ?>" />
			<label for="username">Username:</label><br />
			<input type="text" name="username" value="<?php echo($results['UName']); ?>" /> 
			<br />
			<label for="username">Password:</label><br />
			<input type="password" name="pass" value="<?php echo($results['UPasswd']); ?>" />
			<br />
			<label for="username">First Name:</label><br />
			<input type="text" name="fname" value="<?php echo($results['UFName']); ?>" />
			<br />
			<label for="username">Last Name:</label><br />
			<input type="text" name="lname" value="<?php echo($results['ULName']); ?>" />
			<br />		
			<label for="username">Street Address 1:</label><br />
			<input type="text" name="street1" value="<?php echo($results['UStreet1']); ?>" />	
			<br />	
			<label for="username">Street Address 2:</label><br />
			<input type="text" name="street2" value="<?php echo($results['UStreet2']); ?>" />	
			<br />	
			<label for="username">City:</label><br />
			<input type="text" name="city" value="<?php echo($results['UCity']); ?>" />
			<br />
			<label for="username">Zip:</label><br />
			<input type="text" name="zip" value="<?php echo($results['UZip']); ?>" />
			<br />
			<label for="username">State (Currently <?php echo($results['UState'] . ")"); ?>:</label><br />
				<select name='state' id='state' >
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select><br />
			<label for="username">Email:</label><br />
			<input type="text" name="email" value="<?php echo($results['UEmail']); ?>" />
			<br />
			<label for="username">Phone:</label><br />
			<input type="text" name="phone" value="<?php echo($results['UPhone']); ?>" />
			<br />
			<label for="username">Fax:</label><br />
			<input type="text" name="fax" value="<?php echo($results['UFax']); ?>" />
			<br />
			<label for="username">Cell:</label><br />
			<input type="text" name="cell" value="<?php echo($results['UCell']); ?>" />
			<br />
			<label for="username">Home Page:</label><br />
			<input type="text" name="www" value="<?php echo($results['UHomepage']); ?>" />
			<br /><br />
			<input type="submit" name="submit" value="Update" />
		</form>
	<div class="push"></div>
	</div> <!--Wrapper-->
	
</body>
	<?php include("./../includes/footer.php"); ?>
</html>