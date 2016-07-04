<!DOCTYPE html>
<!--Decorative and functional footer, used primarily with login/
	registration system and seeker classes - Austin - [2015-04-25]-->
<head>
	<title><?php echo "UCJS | " . $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="/UconnJobSearch/includes/stylesheet.css" >
</head>	
	
<?php
include(dirname(__FILE__). "/login.handler.php");
?>
	
<body>
	<div id="header">	
		<h1><?php echo "UCJS | " . $page_title ?></h1>
		<img src="/UconnJobSearch/images/uconnlogo.jpg" height="60"
		width="80" alt="logo"/>
	</div>
</body>	
</html>