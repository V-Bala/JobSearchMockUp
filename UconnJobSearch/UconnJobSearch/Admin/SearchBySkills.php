<html>
<head>
	<link rel="stylesheet" type="text/css" 
		href="search.css">
</head>
<body>
<h4>Please select any skills that may apply</h4>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "UCJS";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    //Create the query
    $sql = "SELECT DISTINCT SSkillName FROM skill";
    //Run the query
    $results = mysqli_query($conn,$sql);

    echo' <form name="skill" action="SearchBySkillsSubmit.php" method="post">';	
    //Iterate over the results
    while($skill = mysqli_fetch_assoc($results)){
   		$skillName = $skill['SSkillName'];
   		echo $skillName;
    	echo "<input type='checkbox' name='$skillName' value=$skillName>";
    	echo "<br />";
    }
	

?>

<br />
<input type="submit" name="search" value="Search"/>
</form>
<input type="button" name="back" value="Return to Administrator Page" 
onclick="window.location.href='AdminMainPage.php'"/></body>
</html>