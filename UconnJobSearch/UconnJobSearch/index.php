<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Vijay, Austin" />
</head>
	<!--Austin - [2015-04-23] login page, redirects user after logged in
		(or if already logged in) to relevant user type page -->
<body>
<?php 
	session_start();
	$page_title = "Login";
	include("includes/header.php");
	login();
?>	
<div class="wrapper">
	<form class="login" action="index.php" method="post">
		<fieldset class="login">
		<legend>Login</legend><br />
		<input type="text" name="username" maxlength="50" placeholder="username"/>
		<br /><br />
		<input type="password" name="pass" maxlength="50" placeholder="password"/>
		<br /><br />
		<input type="submit" name="submit" value="Login" />
		</fieldset>
	</form>
	<form class="login" action="Register.php">
		<fieldset class="login">
			<p>Or you can...</p>
			<input type="submit" name="submit" value="Register" />
		</fieldset>
	</form>
<div class="push"></div>
</div>

</body>
<?php include("includes/footer.php"); ?>
</html>