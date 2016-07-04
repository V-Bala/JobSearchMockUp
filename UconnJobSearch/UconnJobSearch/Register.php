<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Vijay, Austin" />
	<!-- Date: 2015-04-22 -->
</head>

<?php
	$page_title = "Registration";
	$page_type = "seeker";
	include("includes/header.php");

		session_start();
		if(!empty($_SESSION['errMsg'])){
			$errMsg = $_SESSION['errMsg'];
			// tell em why they can't register!
	 		echo "<script>alert('$errMsg')</script>"; 
		}
		// so we don't get remnants from an unfinished registration
		session_destroy();
?>	

<body>
<div class="wrapper">
	<form class="login" action="RegisterUser.php" method='post'
	accept-charset='UTF-8'>
	<fieldset>
	<legend>Register</legend>
	<input type='hidden' name='submitted' id='submitted' value='1'/>
	
	<label for='username' >Username:</label><br />
	<input type='text' name='username' id='username' maxlength="50" />
	 <br />
	<label for='password' >Password:</label><br />
	<input type='password' name='password' id='password' maxlength="50" />
	<br />
	<label for='email' >Email Address:</label><br />
	<input type='text' name='email' id='email' maxlength="50" />
	<br />
	<label for='First Name' >First Name:</label><br />
	<input type='text' name='fname' id='fname' maxlength="50" />
	<br />
	<label for='Last Name' >Last Name:</label><br />
	<input type='text' name='lname' id='lname' maxlength="50" />
	<br />
	<label for='Phone Number' >Phone Number:</label><br />
	<input type='tel' name='phone' id='phone' maxlength="50" />
	<br />
	<label for='Address' >Address:</label><br />
	<input type='text' name='add' id='add' maxlength="50" />
	<br />
	<label for='City' >City:</label><br />
	<input type='text' name='city' id='city' maxlength="50" />
	<br />
	<label for='State' >State:</label><br />
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
	</select>
	<br />
	<label for='ZipCode' >Zip Code:</label><br />
	<input type='text' name='zip' id='zip' maxlength="50" />
	<br />
	<label for='Administrator' >Administrator</label><br />
	<input type="radio" name="type" value="admin" />
	<br />
	<label for='Job Poster' >Job Poster</label><br />
	<input type="radio" name="type" value="poster" />
	<br />
	<label for='Job Seeker' >Job Seeker</label><br />
	<input type="radio" name="type" value="seeker" />
	<br />
	<input type='submit' name='Submit' value='Submit' />
	
	</fieldset>
	</form>
	<form class="login" action="index.php">
	<fieldset>
		<input type="submit" name="submit" value="Cancel" />
	</fieldset>
	</form>
<div class="push"></div>
</div>
</body>
<?php include("includes/footer.php"); ?>
</html>
