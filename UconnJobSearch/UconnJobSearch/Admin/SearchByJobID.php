<html>
<head>
		<link rel="stylesheet" type="text/css" 
		href="search.css">
</head>
<body>

<?php
include_once 'JobSearch.php';

echo "<h2>Search Results:</h2><p>";

$searcher = new JobSearch($_POST);
$results = $searcher->searchByJobID();
//print(json_encode(($results)));
//And we display the results
foreach ($results as $result){
echo $result['UName'];
echo "<br>";
echo $result['UStreet1'];
echo "<br>";
echo $result['UEmail'];
echo "<br>";
echo "<br>";
}
//This counts the number or results - and if there wasn't any it gives them a little message explaining that
if (count($results)== 0)
{
echo "Sorry, but we can not find an entry to match your query...<br><br>";
}
?> 
<input type="button" name="back" value="Return to Administrator Page" 
onclick="window.location.href='AdminMainPage.php'"/>
</body>
</html>