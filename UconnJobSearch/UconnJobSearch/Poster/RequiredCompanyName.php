<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Tyler" />
</head>

<?php
	$page_title = "Select a Company!";
	$page_type = "poster";
	include("./../includes/header.php");
		session_start();
		if(!empty($_SESSION['errMsg'])){
			$errMsg = $_SESSION['errMsg'];
	 		echo "<script>alert('$errMsg')</script>"; 
		}
			if(!validLogin('poster')) 
	die();	
	$database = new DatabaseConnector();
	$database->connect();
	$username = $_SESSION['username'];
?>

<body>
<div class="wrapper">
	<form class="login" action="SetCompanyName.php" method='post'
	 accept-charset='UTF-8'>
	<fieldset>
	<legend>Company Select</legend>	
	<input type="hidden" name="username" value="<?php echo($username);?>"/>
	
	<label for='Test Enterprises' >Test Enterprises</label><br />
	<input type="radio" name="cname" value="Test Enterprises" />
	<br />
	<label for='Applied Sciences' >Applied Sciences</label><br />
	<input type="radio" name="cname" value="Applied Sciences" />
	<br />
	<label for='BillCo' >Billco</label><br />
	<input type="radio" name="cname" value="BillCo" />
	<br />
	<label for='Tarzak' >Tarzak</label><br />
	<input type="radio" name="cname" value="Tarzak" />
	<br />	
	<label for='Starbucks' >Starbucks</label><br />
	<input type="radio" name="cname" value="Starbucks" />
	<br />	
	<input type='submit' name='Submit' value='Submit' />
	</fieldset>
	</form>
	<div class="push"></div>
</div>
</body>
<?php include("./../includes/footer.php"); ?>
</html>


