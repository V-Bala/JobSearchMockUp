<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<?php
	session_start();
	$page_title = "Poster";
	include("./../includes/header.php");
	include("./../includes/login.handler.php");	
	
?>

<body>
	<div class="nav">
		<form class="nav" action="poster.handler.php">
			<input type="submit" name="profile" value="Profile"><br />
			<input type="submit" name="jobs" value="Jobs"><br />
			<input type="submit" name="Post Jobs" value="PostJobs"><br />
			<input type="submit" name="logoff" value="Log off"><br />
		</form>
	</div>
	

	
</body>
	<?php include("./../includes/footer.php"); ?>
</html>